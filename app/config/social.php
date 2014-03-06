<?php

// This config file stores social login Auth keys

return array(

    /* 
    |--------------------------------------------------------------------------
    | These are config variables for login with Github.
    |--------------------------------------------------------------------------
    | To use them you have to first create a new app on Github (https://github.com/settings/applications/new)
    | The callback URL would be 'login/github' relative to your application's URL
    | After you create the app on Github, copy the Client ID and Client Secret and insert them below
    | user_agent should be set to YOUR username on Github. They need this in order to 
    | track security issues and without this the Github login will not work. 
    |
    */
	'github'	=> array(
        'clientId'     =>  '',
        'clientSecret' =>  '',
        'scopes'       => array('user:email'),
        'user_agent'   => ''
    ),

    /* 
    |--------------------------------------------------------------------------
    | These are config variables for Disqus commenting system
    |--------------------------------------------------------------------------
    | To use these you first have to create a new forum on Disqus: http://disqus.com/
    | Then copy and paste the PublicKey and the forum name found in the integrations.
    |
    */
    'disqus'   => array(
        'publicKey'    => '',
        'forum'        => '',
        'requestUrl'   => 'http://disqus.com/api/3.0/threads/set.json',
        'threadFormat' => 'ident:',
    ),
);
