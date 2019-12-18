<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *      itemOperations={
 *          "get"
 *      })
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
}
