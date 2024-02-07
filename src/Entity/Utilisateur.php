<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    private ?string $prenom = null;

    #[ORM\ManyToOne(inversedBy: 'apprenants')]
    private ?Formation $formationSuivie = null;



    #[ORM\OneToMany(targetEntity: Matiere::class, mappedBy: 'formateur')]
    private Collection $matiereEnseignee;

    #[ORM\OneToMany(targetEntity: Note::class, mappedBy: 'apprenant')]
    private Collection $notes;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'apprenants')]
    private ?self $tuteurAssigne = null;

    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'tuteurAssigne')]
    private Collection $apprenants;

    public function __construct()
    {
        $this->matiereEnseignee = new ArrayCollection();
        $this->notes = new ArrayCollection();
        $this->apprenants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getFormationSuivie(): ?Formation
    {
        return $this->formationSuivie;
    }

    public function setFormationSuivie(?Formation $formationSuivie): static
    {
        $this->formationSuivie = $formationSuivie;

        return $this;
    }


    

    
    /**
     * @return Collection<int, Matiere>
     */
    public function getMatiereEnseignee(): Collection
    {
        return $this->matiereEnseignee;
    }

    public function addMatiereEnseignee(Matiere $matiereEnseignee): static
    {
        if (!$this->matiereEnseignee->contains($matiereEnseignee)) {
            $this->matiereEnseignee->add($matiereEnseignee);
            $matiereEnseignee->setFormateur($this);
        }

        return $this;
    }

    public function removeMatiereEnseignee(Matiere $matiereEnseignee): static
    {
        if ($this->matiereEnseignee->removeElement($matiereEnseignee)) {
            // set the owning side to null (unless already changed)
            if ($matiereEnseignee->getFormateur() === $this) {
                $matiereEnseignee->setFormateur(null);
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

    public function getTuteurAssigne(): ?self
    {
        return $this->tuteurAssigne;
    }

    public function setTuteurAssigne(?self $tuteurAssigne): static
    {
        $this->tuteurAssigne = $tuteurAssigne;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getApprenants(): Collection
    {
        return $this->apprenants;
    }

    public function addApprenant(self $apprenant): static
    {
        if (!$this->apprenants->contains($apprenant)) {
            $this->apprenants->add($apprenant);
            $apprenant->setTuteurAssigne($this);
        }

        return $this;
    }

    public function removeApprenant(self $apprenant): static
    {
        if ($this->apprenants->removeElement($apprenant)) {
            // set the owning side to null (unless already changed)
            if ($apprenant->getTuteurAssigne() === $this) {
                $apprenant->setTuteurAssigne(null);
            }
        }

        return $this;
    }



}
