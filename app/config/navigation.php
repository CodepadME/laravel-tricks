<?php

// Defining menu structure here
// the items that need to appear when user is logged in should have logged_in set as true
return array(

	'menu' => array(
		array(
			'label' => 'Browse',
			'route' => 'browse.recent',
			'active' => array('/','popular','comments')
		),
		array(
			'label' => 'Categories',
			'route' => 'browse.categories',
			'active' => array('categories*')
		),
		array(
			'label' => 'Tags',
			'route' => 'browse.tags',
			'active' => array('tags*')
		),
		array(
			'label' => 'Create New',
			'route' => 'tricks.new',
			'active' => array('user/tricks/new'),
			// 'logged_in' => true
		),
	),

	'browse' => array(
		array(
			'label' => 'Most recent',
			'route' => 'browse.recent',
			'active' => array('/')
		),
		array(
			'label' => 'Most popular',
			'route' => 'browse.popular',
			'active' => array('popular')
		),
		array(
			'label' => 'Most commented',
			'route' => 'browse.comments',
			'active' => array('comments')
		),
	),

);
