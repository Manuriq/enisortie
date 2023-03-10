<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ParticipantRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: ParticipantRepository::class)]
#[UniqueEntity("pseudo")]
#[Vich\Uploadable]
class Participant implements UserInterface, PasswordAuthenticatedUserInterface, \Serializable
{


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $mail = null;


    /**
     * @var string The hashed motPasse
     */
    #[ORM\Column]
    private ?string $motPasse = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $pseudo = null;

    #[ORM\Column(length: 255)]
    private ?string $telephone = null;

    #[ORM\Column]
    private ?bool $actif = null;

    #[ORM\Column]
    private ?bool $administrateur = null;

    #[ORM\ManyToOne(inversedBy: 'participants')]
    private ?Campus $campus = null;

    #[ORM\OneToMany(mappedBy: 'organisateur',targetEntity: Sortie::class)]
    private Collection $sorties;

    #[ORM\ManyToMany(targetEntity: Sortie::class, mappedBy: 'listeInscrits')]
    private Collection $listeInscrits;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $image = null;

    /**
     * ...
     * @Assert\Image(mimeTypes={"image/png", "image/jpeg", "image/jpg", "image/gif"})
     */
    #[Vich\UploadableField(mapping: 'profil_images', fileNameProperty: 'image')]
    private ?File $imageFile = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->mail;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        return $this->administrateur ? ['ROLE_ADMIN'] : ['ROLE_USER'];
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getMotPasse(): string
    {
        return $this->motPasse;
    }

    public function getPassword(): string
    {
        return $this->motPasse;
    }

    public function setPassword(string $motPasse): self
    {
        $this->motPasse = $motPasse;

        return $this;
    }

    public function setMotPasse(string $motPasse): self
    {
        $this->motPasse = $motPasse;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainmotPasse = null;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function isActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): self
    {
        $this->actif = $actif;

        return $this;
    }

    public function setAdministrateur(bool $administrateur): self
    {
        $this->administrateur = $administrateur;

        return $this;
    }

    public function getAdministrateur(): bool
    {
        return $this->administrateur;
    }

    public function __toString() {
        return $this->prenom . ' ' . $this->nom;
    }

    /**
     * @return Collection
     */
    public function getListeInscrits(): Collection
    {
        return $this->listeInscrits;
    }

    /**
     * @param Collection $listeInscrits
     */
    public function setListeInscrits(Collection $listeInscrits): void
    {
        $this->listeInscrits = $listeInscrits;
    }

    /**
     * @return Collection
     */
    public function getSorties(): Collection
    {
        return $this->sorties;
    }

    /**
     * @param Collection $sorties
     */
    public function setSorties(Collection $sorties): void
    {
        $this->sorties = $sorties;
    }

    /**
     * @return Campus|null
     */
    public function getCampus(): ?Campus
    {
        return $this->campus;
    }

    /**
     * @param Campus|null $campus
     */
    public function setCampus(?Campus $campus): void
    {
        $this->campus = $campus;
    }


    public function setImageFile(File|null|UploadedFile $image):Participant
    {
        $this->imageFile = $image;
        if (null !== $image) {
            $this->updatedAt = new \DateTimeImmutable();
        }
        return  $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->mail,
            $this->motPasse,
        ));
    }

    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->mail,
            $this->motPasse,
            ) = unserialize($serialized);
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

}
