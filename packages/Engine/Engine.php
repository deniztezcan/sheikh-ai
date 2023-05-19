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
}
