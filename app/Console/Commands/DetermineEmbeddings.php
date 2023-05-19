<?php

namespace App\Console\Commands;

use App\Models\Ayah;
use Faker\Core\File;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File as FacadesFile;
use Orhanerday\OpenAi\OpenAi;

class DetermineEmbeddings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:determine-embeddings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $openai = new OpenAi(env('OPENAI_API_KEY'));

        foreach (Ayah::all() as $ayah) {
            $response = $openai->embeddings([
                'model' => "text-embedding-ada-002",
                'input' => $ayah->content,
            ]);
            $response = json_decode($response, true);
            Ayah::where('id', $ayah->id)->update([
                'embedding' => json_encode($response['data'][0]['embedding']),
            ]);
        }
    }
}
