<?php

return array(

    'appNameIOS'     => array(
        'environment' => 'production',
        'certificate' => app_path() . '/prod.pem',
        'passPhrase'  => '',
        'service'     => 'apns'
    ),
    'appNameAndroid' => array(
        'environment' =>'production',
        'apiKey'      =>'yourAPIKey',
        'service'     =>'gcm'
    )

);