<?php defined('SYSPATH') or die('No direct script access.');
class Controller_Login extends Controller_Template
{

    /**
     * Path to the LightOpenID library, relative to DOCROOT
     */
    const OPENID_LIB_PATH = 'vendor/fp/lightopenid/openid.php';

    /**
     * The URL of the OpenID provider to use for OpenID auth
     */
    const OPENID_URL = 'https://www.google.com/accounts/o8/id';

    /**
     * @var LightOpenID The initialized OpenID library object
     */
    private $_openid;

    /**
     * @var array Keys to request from the OpenID provider
     * @link http://code.google.com/p/lightopenid/wiki/GettingMoreInformation
     */
    public static $provider_keys = ['contact/email', 'namePerson/first', 'namePerson/last'];

    /**
     * Initialize the OpenID library before any actions are run
     *
     * @throws Kohana_Exception
     */
    public function before()
    {
        parent::before();

        $library_path = DOCROOT . self::OPENID_LIB_PATH;
        if (!file_exists($library_path)) {
            throw new Kohana_Exception('OpenID library ":path" not found!', [':path' => $library_path]);
        }

        // Include the OpenID library
        require DOCROOT . self::OPENID_LIB_PATH;

        // Initialize the library to the current host (localhost)
        $this->_openid = new LightOpenID($_SERVER['HTTP_HOST']);
    }

    /**
     * Redirects the user to the OpenID provider for authentication
     * or back to the application if already authenticated
     */
    public function action_index()
    {
        // Already logged in?
        if (Auth::instance()->logged_in()) {
            Notify::msg('You are already logged in!');
            $this->redirect('');
        }

        // Provider URL
        $this->_openid->identity = self::OPENID_URL;

        // Return URL
        $this->_openid->returnUrl = URL::base('http') . 'login/finish';

        // Requested info
        $this->_openid->required = self::$provider_keys;

        // Redirect to Google
        $this->redirect($this->_openid->authUrl());
    }

    /**
     * Finish OpenID authentication.
     * Second step of the two-step auth process.
     * User is redirected here from the provider page.
     */
    public function action_finish()
    {
        if ($this->_openid->mode == 'cancel') { // Auth was cancelled
            Notify::error('User pressed the "cancel" button! Can not log in.');
        } elseif ($this->_openid->validate()) { // Auth success

            // Try to find the user from the database
            $user = ORM::factory('User', ['google_id' => $this->_openid->identity]);

            if (!$user->loaded()) {
                // This is a new user
                $user = $this->_create_new_user($this->_openid);
            }
            if ($user->has('roles', 1)) {
                Auth::instance()->force_login($user);
                Notify::success(__('Logged in as user :user', [':user' => $user->email]));
            } else {
                Notify::error('You are not allowed to log in.');
            }
        }

        $this->redirect('');
    }

    /**
     * Create a new user and assign OpenID identity to the new account
     *
     * @param LightOpenID $openid OpenID instance that was used to login
     * @return \ORM
     */
    public static function _create_new_user(LightOpenID $openid)
    {
        $user = ORM::factory('User');

        // Get payload data returned by the provider
        $provider_data = Arr::extract($openid->getAttributes(), Controller_Login::$provider_keys);

        // Fill in user information
        $user->username = URL::title($provider_data['namePerson/first'] . $provider_data['namePerson/last']);
        $user->email = $provider_data['contact/email'];
        $user->google_id = $openid->identity;

        // Save the user
        try {
            $user->save();

            // Add login role to the new user
            $user->add('roles', 1);

        } catch (ORM_Validation_Exception $e) {
            Notify::error(print_r($e->errors()));
        }

        return $user;
    }

    public function action_logout(){
        Auth::instance()->logout();
        $this->redirect(URL::base());
    }
}