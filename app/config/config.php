<?php

return array(

	'view_throttle_time' => 3600,

	'version' => '1.0.0',
	'version_date' => 'February 19, 2014',

	'analytics_property_id' => 'UA-XXXX-Y',
	'disqus_shortname'      => 'Your Disqus shortname here',

	// Admin email (the notifications are sent to this email, also see the mail.php config for the "From" address)
	'admin_email' => '',

	// available user permission types that are matched by user_type column in the users table
	'user_types' => array(
		'admin' 	=> 100,
		'reviewer'  => 20,
		'user'		=> 10
	),

	// Some potential usernames should be protected and new or existing users will not
	// be able to take any of the following usernames :
	'forbidden_usernames' => [
		'tricks',
		'trick',
		'user',
		'admin',
		'privacy',
		'license',
		'resources',
		'about',
		'login',
		'logout',
		'register',
		'img',
		'css',
		'js',
		'feed',
		'feed.atom',
		'feed.xml'
	],
);
