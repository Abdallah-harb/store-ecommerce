<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class SubCategoryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       factory(Category::class ,10)->create([
           'parent_id' => $this->getRandomParentId()
       ]);
    }

    private function getRandomParentId()
    {
        return \App\Models\Category::inRandomOrder()->first();
    }
}
