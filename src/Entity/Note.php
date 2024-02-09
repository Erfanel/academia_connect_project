<?php

namespace App\Entity;

use App\Repository\NoteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NoteRepository::class)]
class Note
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 4, scale: 2)]
    private ?string $note = null;

    #[ORM\ManyToOne(inversedBy: 'notes')]
    private ?Matiere $matiere = null;

    #[ORM\ManyToOne(inversedBy: 'notes')]
    private ?Utilisateur $apprenant = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $evaluation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getMatiere(): ?Matiere
    {
        return $this->matiere;
    }

    public function setMatiere(?Matiere $matiere): static
    {
        $this->matiere = $matiere;

        return $this;
    }

    public function getApprenant(): ?Utilisateur
    {
        return $this->apprenant;
    }

    public function setApprenant(?Utilisateur $apprenant): static
    {
        $this->apprenant = $apprenant;

        return $this;
    }

    public function getEvaluation(): ?string
    {
        return $this->evaluation;
    }

    public function setEvaluation(?string $evaluation): static
    {
        $this->evaluation = $evaluation;

        return $this;
    }
}
