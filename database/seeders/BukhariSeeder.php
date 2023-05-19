<?php

namespace Database\Seeders;

use App\Models\Hadith;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class BukhariSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(storage_path('bukhari.json'));
        $array = json_decode($json, true);

        foreach ($array as $volume) {
            foreach ($volume['books'] as $book) {
                foreach ($book['hadiths'] as $single) {
                    Hadith::create([
                        'collection' => "bukhari",
                        'volume' => preg_replace('/[^0-9]/', '', $volume['name']),
                        'book' => preg_replace('/[^0-9]/', '', $book['name']),
                        'number' => preg_replace('/[^0-9]/', '', explode('Number', $single['info'])[1]),
                        'content' => $single['text']
                    ]);
                }
            }
        }
    }
}
