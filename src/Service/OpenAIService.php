<?php
// src/Service/OpenAIService.php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class OpenAIService
{
    private $httpClient;
    private $apiKey;

    public function __construct(HttpClientInterface $httpClient, string $apiKey)
    {
        $this->httpClient = $httpClient;
        $this->apiKey = $apiKey;
        error_log("API Key: " . $this->apiKey);
    }

    public function askQuestion(string $question): string
    {
        $response = $this->httpClient->request('POST', 'https://api.openai.com/v1/engines/davinci-codex/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
            ],
            'json' => [
                'prompt' => $question,
                'max_tokens' => 150,
            ],
        ]);

        $content = $response->toArray();

        return $content['choices'][0]['text'] ?? 'No response';
    }
}
