<?php

namespace App\Entity;

use App\Repository\NoteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity
 * @Vich\Uploadable
 */
#[ORM\Entity(repositoryClass: NoteRepository::class)]
class Note
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     */


    #[ORM\Column(type: 'text', nullable: true)]
    #[Assert\NotBlank]
    private $text;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    #[Assert\Email]
    private $email;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $slug;

    #[ORM\ManyToOne(targetEntity: Form::class, inversedBy: 'notes')]
    #[Assert\NotBlank]
    private $formes;

    #[ORM\ManyToOne(targetEntity: Color::class, inversedBy: 'notes')]
    #[Assert\NotBlank]
    private $colors;

    #[ORM\OneToMany(mappedBy: "notes", targetEntity: Image::class, cascade:["persist"])]
    private $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }






    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {

        $this->text = $text;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug): void
    {
        $this->slug = $slug;
    }





    public function getFormes(): ?Form
    {
        return $this->formes;
    }

    public function setFormes(?Form $formes): self
    {
        $this->formes = $formes;

        return $this;
    }

    public function getColors(): ?Color
    {
        return $this->colors;
    }

    public function setColors(?Color $colors): self
    {
        $this->colors = $colors;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setNotes($this);
        }

        return $this;
    }
    public function getVirtualFilename()
    {
        //Set path for easyadmin
        return realpath(__DIR__.'/uploads/image/'.$this->images);
    }
    public function setVirtualFilename()
    {

        $this->setFilename(basename(imageName));
    }

    public function removeImage(Image $images): self
    {
        if ($this->images->removeElement($images)) {
            // set the owning side to null (unless already changed)
            if ($images->getNotes() === $this) {
                $images->setNotes(null);
            }
        }

        return $this;
    }

}
