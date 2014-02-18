<?php

// This config file stores social login Auth keys

return array(

	'github'	=> array(
        'clientId'     =>  '',
        'clientSecret' =>  '',
        'scopes'       => array('user:email')
    ),

    'disqus'   => array(
        'publicKey'    => '',
        'forum'        => '',
        'requestUrl'   => 'http://disqus.com/api/3.0/threads/set.json',
        'threadFormat' => 'ident:',
    ),
);
