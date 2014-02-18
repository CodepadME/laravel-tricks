<?php

class UsersTableSeeder extends Seeder {

    public function run()
    {
        # DB::table('users')->truncate();

        $users = [
            [
                'username' => 'msurguy',
                'email'    => 'user@example.com',
                'password' => Hash::make('password'),
                'is_admin' => '1'
            ],
            [
                'username' => 'stidges',
                'email'    => 'user@example.com',
                'password' => Hash::make('password'),
                'is_admin' => '1'
            ]
        ];

        DB::table('users')->insert($users);
    }

}
