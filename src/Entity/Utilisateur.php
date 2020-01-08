<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UtilisateurRepository")
 */
class Utilisateur
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ad_mail;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Breaks",mappedBy="utilisateur")
     */
    private $breaks;


    public function __construct()
    {
        $this->breaks = new ArrayCollection();        
    }

    public function getBreaks() : Collection
    {
        return $this->breaks;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdMail(): ?string
    {
        return $this->ad_mail;
    }

    public function setAdMail(string $ad_mail): self
    {
        $this->ad_mail = $ad_mail;

        return $this;
    }

    public function addBreaks(Breaks $break):self
    {
        if (!$this->breaks->contains($break)){
            $this->breaks[] = $break;
            $break->setUtilisateur($this);
        }
        return $this;
    }

    public function removeBreaks(Breaks $break):self
    {
        if ($this->breaks->contains($break)){
            $this->breaks->removeElement($break);
        }
        return $this;
    }
}
