<?php

namespace App\Libs;

use OpenAI as OpenAIAPI;
use OpenAI\Client;

class OpenAI
{
    private Client $openai;

    public function __construct(
        string $token,
        private readonly string $model = "gpt-4o-mini"
    )
    {
        $this->openai = OpenAIAPI::client($token);
    }

    /**
     * @param string $question
     * @param string $background
     * @return string
     */
    public function answer(string $question, string $background = "You are a helpful assistant."): string
    {
        $response = $this->openai->chat()->create([
            "model" => $this->model,
            "messages" => [
                [
                    "role" => "system",
                    "content" => $background
                ],
                [
                    "role" => "user",
                    "content" => $question
                ]
            ]
        ]);

        return $response->choices[0]->message->content;
    }
}