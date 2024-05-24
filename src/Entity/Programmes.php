<?php

namespace App\Entity;

use App\Repository\ProgrammesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProgrammesRepository::class)]
class Programmes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nomProgramme = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $typeProgramme = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomProgramme(): ?string
    {
        return $this->nomProgramme;
    }

    public function setNomProgramme(?string $nomProgramme): static
    {
        $this->nomProgramme = $nomProgramme;

        return $this;
    }

    public function getTypeProgramme(): ?string
    {
        return $this->typeProgramme;
    }

    public function setTypeProgramme(?string $typeProgramme): static
    {
        $this->typeProgramme = $typeProgramme;

        return $this;
    }
}
