<?php

// Defining menu structure here
// the items that need to appear when user is logged in should have logged_in set as true
return array(
    'en' => [
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
    ],
    'ja' => [
        'menu' => array(
            array(
                'label' => '新着',
                'route' => 'browse.recent',
                'active' => array('/','popular','comments')
            ),
            array(
                'label' => 'カテゴリ',
                'route' => 'browse.categories',
                'active' => array('categories*')
            ),
            array(
                'label' => 'タグ',
                'route' => 'browse.tags',
                'active' => array('tags*')
            ),
            array(
                'label' => '新規作成',
                'route' => 'tricks.new',
                'active' => array('user/tricks/new'),
                // 'logged_in' => true
            ),
        ),

        'browse' => array(
            array(
                'label' => '最近',
                'route' => 'browse.recent',
                'active' => array('/')
            ),
            array(
                'label' => '人気',
                'route' => 'browse.popular',
                'active' => array('popular')
            ),
            array(
                'label' => 'コメント数',
                'route' => 'browse.comments',
                'active' => array('comments')
            ),
        ),
    ],
);
