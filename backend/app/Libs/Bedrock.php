<?php

namespace App\Libs;

use Aws\BedrockRuntime\BedrockRuntimeClient;
use Psr\Http\Message\StreamInterface;

class Bedrock
{
    private BedrockRuntimeClient $bedrock;

    public function __construct(
        private readonly string $model_id = "anthropic.claude-3-haiku-20240307-v1:0",
        private readonly string $anthropic_version = "anthropic.claude-3-haiku-20240307-v1:0",
        private readonly int $max_token = 1000,
        array $client_configs = [
            "region" => "us-east-1",
            "version" => "latest"
        ]
    )
    {
        $this->bedrock = new BedrockRuntimeClient($client_configs);
    }

    /**
     * @param string $question
     * @return string
     */
    public function answer(string $question): string
    {
        /* @var StreamInterface $response */
        $response = $this->bedrock->invokeModel([
            "body" => json_encode([
                "anthropic_version" => $this->anthropic_version,
                "max_tokens" => $this->max_token,
                "messages" => [
                    [
                        "role" => "user",
                        "content" => $question
                    ]
                ],
            ]),
            "modelId" => $this->model_id
        ])->get("body");

        $response_json = $response->getContents();

        return json_decode($response_json, true)["content"][0]["text"];
    }
}