<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\ManyToOne(targetEntity: Note::class, inversedBy: 'images')]
    private $notes;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $image;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
    public function getVirtualFilename()
    {
        //Set path for easyadmin
        return realpath(__DIR__.'/uploads/image/'.$this->name);
    }
    public function setVirtualFilename()
    {

        $this->setFilename(basename(name));
    }

    public function getNotes(): ?Note
    {
        return $this->notes;
    }

    public function setNotes(?Note $notes): self
    {
        $this->notes = $notes;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function __toString(){
        // to show the name of the Category in the select
        return $this->name;
    }
}
