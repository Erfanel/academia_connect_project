<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\ManyToOne(inversedBy: 'utilisateurs')]
    private ?Formation $formation_suivie = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'apprenants_suivis')]
    private ?self $tuteur_designe = null;

    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'tuteur_designe')]
    private Collection $apprenants_suivis;

    #[ORM\OneToMany(targetEntity: Matiere::class, mappedBy: 'formateur')]
    private Collection $matieres_enseignees;

    #[ORM\OneToMany(targetEntity: Note::class, mappedBy: 'apprenant')]
    private Collection $notes;

    public function __construct()
    {
        $this->apprenants_suivis = new ArrayCollection();
        $this->matieres_enseignees = new ArrayCollection();
        $this->notes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getFormationSuivie(): ?Formation
    {
        return $this->formation_suivie;
    }

    public function setFormationSuivie(?Formation $formation_suivie): static
    {
        $this->formation_suivie = $formation_suivie;

        return $this;
    }

    public function getTuteurDesigne(): ?self
    {
        return $this->tuteur_designe;
    }

    public function setTuteurDesigne(?self $tuteur_designe): static
    {
        $this->tuteur_designe = $tuteur_designe;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getApprenantsSuivis(): Collection
    {
        return $this->apprenants_suivis;
    }

    public function addApprenantsSuivi(self $apprenantsSuivi): static
    {
        if (!$this->apprenants_suivis->contains($apprenantsSuivi)) {
            $this->apprenants_suivis->add($apprenantsSuivi);
            $apprenantsSuivi->setTuteurDesigne($this);
        }

        return $this;
    }

    public function removeApprenantsSuivi(self $apprenantsSuivi): static
    {
        if ($this->apprenants_suivis->removeElement($apprenantsSuivi)) {
            // set the owning side to null (unless already changed)
            if ($apprenantsSuivi->getTuteurDesigne() === $this) {
                $apprenantsSuivi->setTuteurDesigne(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Matiere>
     */
    public function getMatieresEnseignees(): Collection
    {
        return $this->matieres_enseignees;
    }

    public function addMatieresEnseignee(Matiere $matieresEnseignee): static
    {
        if (!$this->matieres_enseignees->contains($matieresEnseignee)) {
            $this->matieres_enseignees->add($matieresEnseignee);
            $matieresEnseignee->setFormateur($this);
        }

        return $this;
    }

    public function removeMatieresEnseignee(Matiere $matieresEnseignee): static
    {
        if ($this->matieres_enseignees->removeElement($matieresEnseignee)) {
            // set the owning side to null (unless already changed)
            if ($matieresEnseignee->getFormateur() === $this) {
                $matieresEnseignee->setFormateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Note>
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): static
    {
        if (!$this->notes->contains($note)) {
            $this->notes->add($note);
            $note->setApprenant($this);
        }

        return $this;
    }

    public function removeNote(Note $note): static
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getApprenant() === $this) {
                $note->setApprenant(null);
            }
        }

        return $this;
    }
}
