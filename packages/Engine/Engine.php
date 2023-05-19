<?php

namespace Packages\Engine;

use Orhanerday\OpenAi\OpenAi;

class Engine
{
    public $open_ai;

    public function __construct()
    {
        $this->open_ai = new OpenAi(env('OPENAI_API_KEY'));
    }

    private function queryMessage(
        string $query,
        string $model,
        int $budget
    ): string {
        $intro = 'Use the below verses from the Quran and Sunnah on Islamic Theology to answer the subsequent question. If the answer cannot be found in the articles, write "I could not find an answer to your question yet. And Allah knows best."';
        $question = "\n\nQuestion: ".$query;
        $message = $intro;

        return $message.$question;
    }

    public function ask(
        string $query,
        string $model,
        int $budget = 4096 - 500
    ) {
        $message = $this->queryMessage($query, $model, $budget);
        $messages = [
            ['role' => 'system', 'content' => 'You answer questions about Islamic Theology.'],
            ['role' => 'user', 'content' => $message],
        ];
    }
}
