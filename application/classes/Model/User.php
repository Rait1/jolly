<?php
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
