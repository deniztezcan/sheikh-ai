<?php

namespace App\Http\Controllers;

use App\Models\Ayah;
use Illuminate\Http\Request;
use Packages\Engine\Engine;

class ApiController extends Controller
{
    public function ask(Request $request)
    {
        $engine = new Engine();
        $ask = $engine->ask($request->input('question'));
        $response = json_decode($ask);
        return response()->json($response->choices[0]->message->content);
    }
}
