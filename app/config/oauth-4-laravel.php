<?php
return array(

    /*
    |--------------------------------------------------------------------------
    | oAuth Config
    |--------------------------------------------------------------------------
    */

    /**
     * Storage
     */
    'storage' => 'Session',

    /**
     * Consumers
     */
    'consumers' => array(

        /**
         * Facebook
         */
        'Facebook' => array(
            'client_id'     => '1532860157031762',
            'client_secret' => 'ed482e600cbfdd3cfaf1c9010074093b',
            'scope'         => array('email'),
        ),

        /**
         * GitHub
         */
        'GitHub' => array(
            'client_id'     => '4a3c81329f2b2cd7b04d',
            'client_secret' => 'bbf5652df01d210b8f5dc7f840e7151811b8d032',
            'scope'         => array('user'),
        ),

    )

);
