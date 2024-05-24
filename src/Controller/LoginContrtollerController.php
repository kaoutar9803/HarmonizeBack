<?php

namespace App\Controller;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

#[Route('/api', name: 'api_')]
class LoginContrtollerController extends AbstractController
{
    #[Route('/login/contrtoller', name: 'app_login_contrtoller')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/LoginContrtollerController.php',
        ]);
    }
    #[Route('/login', name: 'login_check', methods: 'post')]
    public function login(
        Request $request,
        UserProviderInterface $userProvider,
        UserPasswordHasherInterface $passwordHasher,
        JWTTokenManagerInterface $JWTManager,
        LoggerInterface $logger
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        $username = $data['username'] ?? null;
        $password = $data['password'] ?? null;

        $logger->info('Attempting login', ['username' => $username]);

        if (!$username || !$password) {
            $logger->error('Username or password not provided.');
            return new JsonResponse(['error' => 'Username and password are required'], Response::HTTP_BAD_REQUEST);
        }

        try {
            $logger->info('Loading user by identifier.');
            $user = $userProvider->loadUserByIdentifier($username);

            $logger->info('Checking password validity.');
            if (!$passwordHasher->isPasswordValid($user, $password)) {
                $logger->error('Invalid password', ['username' => $username]);
                throw new AuthenticationException('Invalid credentials.');
            }

            $logger->info('Generating JWT.');
            $token = $JWTManager->create($user);
            if (!$token) {
                $logger->error('Failed to generate JWT token.');
                throw new \RuntimeException('Failed to generate JWT token.');
            }

            $logger->info('JWT Token generated successfully', ['token' => $token]);
            return new JsonResponse([
                'message' => 'Login success',
                'token' => $token,
                'user' => [
                    'id' => $user->getId(),
                    'nom' => $user->getNom(),
                    'prenom' => $user->getPrenom(),
                    'email' => $user->getEmail(),
                    'age' => $user->getAge(),
                    'poids' => $user->getPoids(),
                    'taille' => $user->getTaille(),
                    'telephone' => $user->getTelephone()
                ]
            ], 200);

        } catch (AuthenticationException $e) {
            $logger->error('Authentication exception', ['message' => $e->getMessage()]);
            return new JsonResponse(['error' => 'Authentication failed', 'message' => $e->getMessage()], Response::HTTP_UNAUTHORIZED);
        } catch (\Exception $e) {
            $logger->error('Error during login process', ['error' => $e->getMessage()]);
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route(path: '/logout', name: 'app_logout', methods: ['GET', 'POST'])]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
