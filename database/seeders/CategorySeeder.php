<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = [
            'Liga Inggris', 
            'Liga Indonesia', 
            'Liga Spanyol', 
            'Liga Italia', 
            'Liga Jerman', 
            'Liga Prancis',
            'Champions', 
            'Transfer'
        ];

        foreach ($names as $name) {
            Category::firstOrCreate(
                ['name' => $name],
                ['slug' => Str::slug($name)]
            );
        }
    }
}
