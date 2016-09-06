<?php

use Illuminate\Database\Seeder;
include 'AnimeTableSeeder.php';
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(AnimeTableSeeder::class);
    }
}
