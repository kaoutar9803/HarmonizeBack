<?php

namespace App\Entity;

use App\Repository\ObjectifsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ObjectifsRepository::class)]
class Objectifs
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type_objectif = null;

    #[ORM\Column(length: 255)]
    private ?string $valeur_cible = null;

    #[ORM\Column(length: 255)]
    private ?string $date_debut = null;

    #[ORM\Column(length: 255)]
    private ?string $date_fin = null;

    #[ORM\Column(length: 255, nullable:true)]
    private ?string $statut = null;

    #[ORM\Column(length: 255)]
    private ?string $frequence_hebdomadaire = null;

    #[ORM\Column(length: 255)]
    private ?string $allergies_alimentaires = null;

    #[ORM\Column(length: 255)]
    private ?string $condition_physique = null;

    #[ORM\Column(length: 255)]
    private ?string $priorite = null;
    #[ORM\ManyToOne(targetEntity: "user", inversedBy: "objectifs")]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id")]
    private ?User $user = null;

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeObjectif(): ?string
    {
        return $this->type_objectif;
    }

    public function setTypeObjectif(string $type_objectif): static
    {
        $this->type_objectif = $type_objectif;

        return $this;
    }

    public function getValeurCible(): ?string
    {
        return $this->valeur_cible;
    }

    public function setValeurCible(string $valeur_cible): static
    {
        $this->valeur_cible = $valeur_cible;

        return $this;
    }

    public function getDateDebut(): ?string
    {
        return $this->date_debut;
    }

    public function setDateDebut(string $date_debut): static
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?string
    {
        return $this->date_fin;
    }

    public function setDateFin(string $date_fin): static
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }
    public function getPriorite(): ?string
    {
        return $this->priorite;
    }

    public function setPriorite(string $priorite): static
    {
        $this->priorite = $priorite;

        return $this;
    }
    public function getRrequenceHebdomadaire(): ?string
    {
        return $this->frequence_hebdomadaire;
    }

    public function setFrequenceHebdomadaire(string $frequence_hebdomadaire): static
    {
        $this->frequence_hebdomadaire = $frequence_hebdomadaire;

        return $this;
    }

    public function getAllergiesAlimentaires(): ?string
    {
        return $this->allergies_alimentaires;
    }

    public function setAllergiesAlimentaires(string $allergies_alimentaires): static
    {
        $this->allergies_alimentaires = $allergies_alimentaires;

        return $this;
    }

    public function getConditionPhysique(): ?string
    {
        return $this->condition_physique;
    }

    public function setConditionPhysique(string $condition_physique): static
    {
        $this->condition_physique = $condition_physique;

        return $this;
    }
}
