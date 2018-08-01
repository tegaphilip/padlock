<?php

/**
 * @author Tega Oghenekohwo <tega@cottacush.com>
 * Class ApiTestUtils
 * Used to create data needed for other tests and fetching utility data
 */
class ApiTestUtils
{
    /**
     * @return array
     */
    public static function tokenRequestSample()
    {
        return [
            'client_id' => 'test',
            'client_secret' => 'secret',
            'grant_type' => 'password',
            'username' => 'abc',
            'password' => 'abc',
        ];
    }
}
