<?php

// Defining menu structure here
// the items that need to appear when user is logged in should have logged_in set as true
return [

    'menu' => [
        [
            'label'  => 'Browse',
            'route'  => 'browse.recent',
            'active' => ['/', 'popular', 'comments'],
        ],
        [
            'label'  => 'Categories',
            'route'  => 'browse.categories',
            'active' => ['categories*'],
        ],
        [
            'label'  => 'Tags',
            'route'  => 'browse.tags',
            'active' => ['tags*'],
        ],
        [
            'label'  => 'Create New',
            'route'  => 'tricks.new',
            'active' => ['user/tricks/new'],
            // 'logged_in' => true
        ],
    ],

    'browse' => [
        [
            'label'  => 'Most recent',
            'route'  => 'browse.recent',
            'active' => ['/'],
        ],
        [
            'label'  => 'Most popular',
            'route'  => 'browse.popular',
            'active' => ['popular'],
        ],
        [
            'label'  => 'Most commented',
            'route'  => 'browse.comments',
            'active' => ['comments'],
        ],
    ],

];
