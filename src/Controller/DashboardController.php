<?php

namespace App\Controller;

use App\Entity\Activites;
use App\Entity\Objectifs;
use App\Entity\Suivi;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

#[Route('/api', name: 'api_')]
class DashboardController extends AbstractController
{
    private $entityManager;
    private $security;
    private $logger;

    public function __construct(EntityManagerInterface $entityManager, Security $security, LoggerInterface $logger)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
        $this->logger = $logger;
    }

    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/DashboardController.php',
        ]);
    }
    #[Route('/objectifs', name: 'get_user_objectifs', methods: ['GET'])]
    public function getUserObjectifs(): Response
    {
        $user = $this->security->getUser();
        if (!$user) {
            $this->logger->error('Unauthorized access attempt');
            return $this->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        $this->logger->info('User authenticated', ['username' => $user->getUsername()]);

        $objectifs = $this->entityManager->getRepository(Objectifs::class)->findBy(['user' => $user]);

        $data = [];
        foreach ($objectifs as $objectif) {
            $data[] = [
                'type_objectif' => $objectif->getTypeObjectif(),
                'valeur_cible' => $objectif->getValeurCible(),
                'date_debut' => $objectif->getDateDebut() instanceof \DateTimeInterface ? $objectif->getDateDebut()->format('Y-m-d') : null,
                'date_fin' => $objectif->getDateFin() instanceof \DateTimeInterface ? $objectif->getDateFin()->format('Y-m-d') : null,
                'statut' => $objectif->getStatut(),
            ];
        }

        return $this->json($data);
    }


    #[Route('/activites', name: 'get_user_activites', methods: ['GET'])]
    public function getUserActivites(): Response
    {
        $user = $this->security->getUser();
        if (!$user) {
            $this->logger->error('Unauthorized access attempt');
            return $this->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        $this->logger->info('User authenticated', ['username' => $user->getUsername()]);

        $activites = $this->entityManager->getRepository(Activites::class)->findBy(['user' => $user]);

        $data = [];
        foreach ($activites as $activite) {
            $data[] = [
                'type_activite' => $activite->getTypeActivite(),
                'duree' => $activite->getDuree(),
                'calories' => $activite->getCalories(),
                'date' => $activite->getDate() instanceof \DateTimeInterface ? $activite->getDate()->format('Y-m-d') : null
            ];
        }

        return $this->json($data);
    }

    #[Route('/suivi', name: 'get_user_suivi', methods: ['GET'])]
    public function getUserSuivi(): Response
    {

        $user = $this->security->getUser();
        if (!$user) {
            $this->logger->error('Unauthorized access attempt');
            return $this->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        $this->logger->info('User authenticated', ['username' => $user->getUsername()]);

        $qb = $this->entityManager->createQueryBuilder()
            ->select('s', 'o.type_objectif')
            ->from(Suivi::class, 's')
            ->leftJoin('s.objectifs', 'o')
            ->where('s.user = :user')
            ->setParameter('user', $user);

        $result = $qb->getQuery()->getResult();

        $data = [];
        foreach ($result as $item) {
            $suivi = $item[0];
            $typeObjectif = $item['type_objectif'];

            $data[] = [
                'valeur_actuelle' => $suivi->getValeurActuelle(),
                'date_suivi' => $suivi->getDateSuivi() instanceof \DateTimeInterface ? $suivi->getDateSuivi()->format('Y-m-d') : null,
                'type_objectif' => $typeObjectif
            ];
        }

        return $this->json($data);
    }

    #[Route('/profilForm', name: 'profil_form', methods: ['POST'])]
    public function updateObjectif(Request $request, Security $security, EntityManagerInterface $entityManager): Response
    {
        $user = $security->getUser();
        if (!$user) {
            return $this->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }
        $userRepository = $entityManager->getRepository(User::class);
        $userEntity = $userRepository->find($user->getId());

        if (!$userEntity) {
            return $this->json(['message' => 'User not found'], Response::HTTP_UNAUTHORIZED);
        }

        $data = json_decode($request->getContent(), true);

        $objectif = new Objectifs();
        $objectif->setUser($userEntity);
        $objectif->setTypeObjectif($data['typeObjectif'] ?? null);
        $objectif->setValeurCible($data['valeurCible'] ?? null);
        $objectif->setDateDebut($data['dateDebut'] ?? null);
        $objectif->setDateFin($data['dateFin'] ?? null);
        $objectif->setPriorite($data['priorite'] ?? null);
        $objectif->setFrequenceHebdomadaire($data['frequenceHebdomadaire'] ?? null);
        $objectif->setAllergiesAlimentaires($data['allergiesAlimentaires'] ?? null);
        $objectif->setConditionPhysique($data['niveauConditionPhysique'] ?? null);

        $entityManager->persist($objectif);
        $entityManager->flush();

        return $this->json([
            'message' => 'Objectif updated successfully!',
            'data' => $objectif
        ]);

    }

}