<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pages')->insert([
            [
                'title' => 'Main',
                'slug' => 'main'
            ], [
                'title' => 'Investitions',
                'slug' => 'investitions'
            ], [
                'title' => 'Our projects',
                'slug' => 'our-projects'
            ], [
                'title' => 'Work with us',
                'slug' => 'Work-with-us'
            ],
            [
                'title' => 'News',
                'slug' => 'news'
            ]
        ]);
        DB::table('investments')->insert([
            [
                'title' => 'default',
                'description' => 'default',
                'image_desc' => 'default',
            ]
        ]);
        DB::table('contacts')->insert([
            [
                'address' => 'default',
                'email' => 'default',
                'phone' => 'default',
                'created_at' => '2023-04-02 11:21:54',
            ]
        ]);
        DB::table('manifestos')->insert([
            [
                'title' => 'default',
                'description' => 'default',
                'image_desc_title' => 'default',
                'image_desc' => 'default',
                'image_mob_title' => 'default',
                'image_mob' => 'default',
                'created_at' => '2023-04-02 11:21:54',

            ]
        ]);
    }
}
