<?php

namespace App\Entity;

use App\Repository\FormRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormRepository::class)]
class Form
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $form;

    #[ORM\OneToMany(mappedBy: 'formes', targetEntity: Note::class)]
    private $notes;

    public function __construct()
    {
        $this->notes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getForm(): ?string
    {
        return $this->form;
    }

    public function setForm(string $form): self
    {
        $this->form = $form;

        return $this;
    }

    public function getNote(): ?Note
    {
        return $this->notes;
    }

    public function setNote(?Note $notes): self
    {
        $this->note = $notes;

        return $this;
    }

    /**
     * @return Collection<int, Note>
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $notes): self
    {
        if (!$this->notes->contains($notes)) {
            $this->notes[] = $notes;
            $notes->setFormes($this);
        }

        return $this;
    }

    public function removeNote(Note $notes): self
    {
        if ($this->notes->removeElement($notes)) {
            // set the owning side to null (unless already changed)
            if ($notes->getFormes() === $this) {
                $notes->setFormes(null);
            }
        }

        return $this;
    }
    public function __toString(){
        // to show the name of the Category in the select
        return $this->form;
    }


}
