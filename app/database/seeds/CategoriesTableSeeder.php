<?php

class CategoriesTableSeeder extends Seeder {

    public function run()
    {
        $categories = [
            [
                'id'          => '1',
                'name'        => 'Views',
                'slug'        => 'views',
                'description' => 'All tricks related to the View class, e.g. View Composers.',
                'order'       => '1',
            ],
            [
                'id'          => '2',
                'name'        => 'Eloquent',
                'slug'        => 'eloquent',
                'description' => 'Eloquent ORM',
                'order'       => '2',
            ],
        ];

        DB::table('categories')->insert($categories);
        DB::table('category_trick')->insert([
            [ 'category_id' => '2', 'trick_id' => '1' ],
            [ 'category_id' => '1', 'trick_id' => '2' ],
            [ 'category_id' => '2', 'trick_id' => '3' ],
        ]);
    }
}


