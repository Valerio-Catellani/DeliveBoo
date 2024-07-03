<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Typology;
use App\Functions\Helpers;

class TypologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $typologies = json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'json' . DIRECTORY_SEPARATOR . 'Typologies.json'));
        foreach ($typologies as $typology) {
            $new_typology = new Typology();
            $new_typology->name = $typology->name;
            $new_typology->image = $typology->image;
            $new_typology->color = $typology->color;
            $new_typology->icon = $typology->icon;
            $new_typology->slug = Helpers::generateSlug($typology->name, Typology::class);
            $new_typology->save();
        }
    }
}
