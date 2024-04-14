<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OpenAIService;
use App\Services\ImageUtilitiesService;

class OpenAIController extends Controller
{
    protected $openAIService;

    public function __construct(OpenAIService $openAIService)
    {
        $this->openAIService = $openAIService;
    }

    public function getTextResponse(Request $request)
    {
        $prompt = $request->input('prompt');
        $modelVersion = $request->input('modelVersion', 'gpt-3.5-turbo');

        if ($modelVersion == 'gpt-4') {
            $response = $this->openAIService->getGPT4TextResponse($prompt);
        } else {
            $response = $this->openAIService->getGPT3TurboTextResponse($prompt);
        }

        return response()->json(['response' => $response], 200, ['Content-Type' => 'application/json; charset=UTF-8']);
    }

    public function getImage(Request $request)
    {
        $prompt = $request->input('prompt');
        $sizeSelector = $request->input('size', 'cuadrado');

        $imagePath = $this->openAIService->getImage($prompt, $sizeSelector);

        return response()->json(['imagePath' => $imagePath]);
    }
}
