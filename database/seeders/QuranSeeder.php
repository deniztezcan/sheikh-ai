<?php

namespace Database\Seeders;

use App\Models\Ayah;
use App\Models\Surah;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class QuranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(storage_path('quran.json'));
        $array = json_decode($json, true);

        foreach ($array as $chapter) {
            $surah = Surah::create([
                'name' => $chapter['transliteration'],
            ]);

            foreach ($chapter['verses'] as $verse) {
                $ayah = Ayah::create([
                    'surah_id' => $surah->id,
                    'number' => $verse['id'],
                    'content' => $verse['translation'],
                ]);
            }
        }
    }
}
