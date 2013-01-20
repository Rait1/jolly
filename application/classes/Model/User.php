<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rait
 * Date: 1/20/13
 * Time: 3:40 PM
 * To change this template use File | Settings | File Templates.
 */
class Model_User extends Model_Auth_User
{
    public function rules()
    {
        return [
            'google_id' => [
                ['not_empty']
            ]
        ];
    }
}
