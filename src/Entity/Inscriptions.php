<?php

namespace App\Entity;

use App\Repository\InscriptionsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InscriptionsRepository::class)]
class Inscriptions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'inscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: Programmes::class, inversedBy: 'inscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Programmes $programmes = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dateInscription = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getProgrammes(): ?Programmes
    {
        return $this->programmes;
    }

    public function setProgrammes(?Programmes $programmes): self
    {
        $this->$programmes = $programmes;
        return $this;
    }
    public function getDateInscription(): ?string
    {
        return $this->dateInscription;
    }

    public function setDateInscription(?string $dateInscription): static
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }
}
