<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;

#[Route('/api', name: 'api_')]
class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'register', methods: 'post')]
    public function index(ManagerRegistry $doctrine, Request $request, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $em = $doctrine->getManager();
        $decoded = json_decode($request->getContent());

        $user = new User();
        $user->setUsername($decoded->username);
        $user->setPassword($passwordHasher->hashPassword($user, $decoded->password));
        $user->setEmail($decoded->email);
        $user->setNom($decoded->nom);
        $user->setPrenom($decoded->prenom);
        $user->setAge($decoded->age);
        $user->setPoids($decoded->poids);
        $user->setTaille($decoded->taille);
        $user->setTelephone($decoded->telephone);
        $em->persist($user);
        $em->flush();

        return $this->json(['message' => 'Registered Successfully']);
    }}