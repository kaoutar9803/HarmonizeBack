<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[Route('/api', name: 'api_')]
class ChatController extends AbstractController
{
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    #[Route('/chat', name: 'app_chat', methods: ['POST'])]
    public function chatbot(Request $request): JsonResponse
    {

        $data = json_decode($request->getContent(), true);
        $question = $data['question'] ?? '';

        if (empty($question)) {
            return new JsonResponse(['error' => 'Question is required'], 400);
        }

        // Liste de questions prédéfinies
        $predefinedQuestions = [
            "Quels sont vos tarifs ?" => "Nos tarifs varient en fonction des programmes. Vous pouvez les consulter sur notre page des tarifs.",
            "Quels services offrez-vous ?" => "Nous offrons une variété de services de fitness, y compris des programmes de perte de poids, de renforcement musculaire et des plans nutritionnels.",
            "Comment puis-je m'inscrire ?" => "Vous pouvez vous inscrire directement sur notre site web en créant un compte.",
            "Quels sont les horaires d'ouverture ?" => "Nos horaires d'ouverture sont de 6h à 22h, du lundi au vendredi.",
            "Proposez-vous des cours en ligne ?" => "Oui, nous proposons une gamme de cours en ligne adaptés à différents niveaux de fitness.",
        ];

        if (array_key_exists($question, $predefinedQuestions)) {
            $answer = $predefinedQuestions[$question];
            return new JsonResponse(['answer' => $answer]);
        }

        $apiKey = 'sk-proj-oRXTF56YiBH64R5zwuG3T3BlbkFJcCbGGp9yzvcOd4NuwBIK';

        try {
            $response = $this->httpClient->request('POST', 'https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'You are a helpful assistant.'
                        ],
                        [
                            'role' => 'user',
                            'content' => $question
                        ]
                    ],
                ],
            ]);

            $statusCode = $response->getStatusCode();
            if ($statusCode === 429) {
                sleep(10);
                return $this->chatbot($request);
            }

            $content = $response->toArray();
            $answer = $content['choices'][0]['message']['content'] ?? 'No response';

            return new JsonResponse(['answer' => $answer]);

        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error occurred: ' . $e->getMessage()], $e->getCode() ?: 500);
        }
    }
}

