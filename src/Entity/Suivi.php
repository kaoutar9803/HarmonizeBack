<?php

namespace App\Entity;

use App\Repository\SuiviRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SuiviRepository::class)]
class Suivi
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column(type: "float")]
    private ?float $valeur_actuelle = null;

    #[ORM\Column(type: "date")]
    private ?\DateTimeInterface $date_suivi = null;

    #[ORM\ManyToOne(targetEntity: "Objectifs")]
    #[ORM\JoinColumn(name: "objectifs_id", referencedColumnName: "id")]
    private ?Objectifs $objectifs = null;

    #[ORM\ManyToOne(targetEntity: "User")]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id")]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValeurActuelle(): ?float
    {
        return $this->valeur_actuelle;
    }

    public function setValeurActuelle(float $valeur_actuelle): static
    {
        $this->valeur_actuelle = $valeur_actuelle;

        return $this;
    }

    public function getDateSuivi(): ?\DateTimeInterface
    {
        return $this->date_suivi;
    }

    public function setDateSuivi(\DateTimeInterface $date_suivi): self
    {
        $this->date_suivi = $date_suivi;

        return $this;
    }

    public function getObjectifs(): ?Objectifs
    {
        return $this->objectifs;
    }

    public function setObjectifs(?Objectifs $objectifs): self
    {
        $this->objectifs= $objectifs;
        return $this;
    }

    // Getter et Setter pour User
    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }

}
