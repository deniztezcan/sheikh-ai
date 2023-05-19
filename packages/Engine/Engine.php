<?php

namespace Packages\Engine;

use App\Models\Ayah;
use App\Models\Hadith;
use MathPHP\Statistics\Distance;
use Orhanerday\OpenAi\OpenAi;
use Yethee\Tiktoken\EncoderProvider;

class Engine
{
    public $open_ai;

    public $encoder;

    public function __construct()
    {
        $this->open_ai = new OpenAi(env('OPENAI_API_KEY'));
        $this->encoder = new EncoderProvider();
    }

    private function num_tokens(
        string $text,
        string $model
    ): int {
        $encoder = $this->encoder->getForModel($model);
        $tokens = $encoder->encode($text);

        return count($tokens);
    }

    private function lookForRelatedNess(
        $response,
        $obj
    ) {
        $relatedness = Distance::consine($response['data'][0]['embedding'], json_decode($obj['embedding'], true));

        return [$obj['text'], $relatedness];
    }

    private function stringsByRelatedness(
        string $string,
        int $top = 100
    ) {
        $response = $this->open_ai->embeddings([
            'model' => "text-embedding-ada-002",
            'input' => $string,
        ]);
        $response = json_decode($response, true);

        $strings_and_relatednesses = [];
        foreach (Ayah::all() as $i => $row) {
            $strings_and_relatednesses[] = $this->lookForRelatedNess($response, $row);
        }
        // foreach (Hadith::all() as $i => $row) {
        //     $strings_and_relatednesses[] = $this->lookForRelatedNess($response, $row);
        // }

        usort($strings_and_relatednesses, function ($a, $b) {
            return $b[1] <=> $a[1];
        });

        $strings = [];
        $relatednesses = [];
        foreach ($strings_and_relatednesses as $item) {
            $strings[] = $item[0];
            $relatednesses[] = $item[1];
        }

        $strings = array_slice($strings, 0, $top);
        $relatednesses = array_slice($relatednesses, 0, $top);

        return [$strings, $relatednesses];
    }

    private function queryMessage(
        string $query,
        string $model,
        int $budget
    ): string {
        $intro = 'Use the below verses from the Quran and Sunnah on Islamic Theology to answer the subsequent question. If the answer cannot be found in the given verses, write "I could not find an answer to your question yet. And Allah knows best."';
        $question = "\n\nQuestion: ".$query;
        $message = $intro;

        foreach ($this->stringsByRelatedness($query) as $string) {
            $next_article = "\n\Verse from Quran and Sunnah:\n\"\"\"\n$string\n\"\"\"";
            if ($this->num_tokens($message . $next_article . $question, $model) > $budget) {
                break;
            } else {
                $message .= $next_article;
            }
        }

        return $message.$question;
    }

    public function ask(
        string $query,
        string $model = "gpt-3.5-turbo",
        int $budget = 4096 - 500
    ) {
        $message = $this->queryMessage($query, $model, $budget);
        $messages = [
            ['role' => 'system', 'content' => 'You answer questions about Islamic Theology.'],
            ['role' => 'user', 'content' => $message],
        ];
    }
}
