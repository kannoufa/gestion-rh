<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ParametreRepository;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=ParametreRepository::class)
 * @Vich\Uploadable()
 */
class Parametre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $logo;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="parametre_image", fileNameProperty="logo")
     */
    private $logoFile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $enTeteOrdreMission;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="parametre_image", fileNameProperty="enTeteOrdreMission")
     */
    private $enTeteOrdreMissionFile;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getEnTeteOrdreMission(): ?string
    {
        return $this->enTeteOrdreMission;
    }

    public function setEnTeteOrdreMission(string $enTeteOrdreMission): self
    {
        $this->enTeteOrdreMission = $enTeteOrdreMission;

        return $this;
    }

    /**
     * @return null|File
     */
    public function getLogoFile(): ?File
    {
        return $this->logoFile;
    }

    public function setLogoFile(?File $logoFile): self
    {
        $this->logoFile = $logoFile;

        return $this;
    }

    /**
     * @return null|File
     */
    public function getEnTeteOrdreMissionFile(): ?File
    {
        return $this->enTeteOrdreMissionFile;
    }

    public function setEnTeteOrdreMissionFile(?File $enTeteOrdreMissionFile): self
    {
        $this->enTeteOrdreMissionFile = $enTeteOrdreMissionFile;

        return $this;
    }
}