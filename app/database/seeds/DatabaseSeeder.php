<?php

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        $this->call('UsersTableSeeder');
        $this->call('TricksTableSeeder');
        $this->call('CategoriesTableSeeder');
        $this->call('TagsTableSeeder');
    }
}
