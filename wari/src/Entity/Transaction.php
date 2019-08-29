<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TransactionRepository")
 */
class Transaction
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomEnvoi;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prenomEvoie;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cniEnvoie;

    /**
     * @ORM\Column(type="bigint", nullable=true)
     */
    private $montantEnvoi;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateEnvoie;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $codeEnvoie;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cniRetrait;

    /**
     * @ORM\Column(type="bigint", nullable=true)
     */
    private $montantRetrait;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateRetrait;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $telEnvoi;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $telRetrait;

    /**
     * @ORM\Column(type="bigint")
     */
    private $commissionEtat;

    /**
     * @ORM\Column(type="bigint")
     */
    private $commissionAdmin;

    /**
     * @ORM\Column(type="bigint")
     */
    private $commissionRetrait;

    /**
     * @ORM\Column(type="bigint")
     */
    private $commissionEnvoie;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="transactions")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEnvoi(): ?string
    {
        return $this->nomEnvoi;
    }

    public function setNomEnvoi(?string $nomEnvoi): self
    {
        $this->nomEnvoi = $nomEnvoi;

        return $this;
    }

    public function getPrenomEvoie(): ?string
    {
        return $this->prenomEvoie;
    }

    public function setPrenomEvoie(?string $prenomEvoie): self
    {
        $this->prenomEvoie = $prenomEvoie;

        return $this;
    }

    public function getCniEnvoie(): ?string
    {
        return $this->cniEnvoie;
    }

    public function setCniEnvoie(?string $cniEnvoie): self
    {
        $this->cniEnvoie = $cniEnvoie;

        return $this;
    }

    public function getMontantEnvoi(): ?int
    {
        return $this->montantEnvoi;
    }

    public function setMontantEnvoi(?int $montantEnvoi): self
    {
        $this->montantEnvoi = $montantEnvoi;

        return $this;
    }

    public function getDateEnvoie(): ?\DateTimeInterface
    {
        return $this->dateEnvoie;
    }

    public function setDateEnvoie(?\DateTimeInterface $dateEnvoie): self
    {
        $this->dateEnvoie = $dateEnvoie;

        return $this;
    }

    public function getCodeEnvoie(): ?string
    {
        return $this->codeEnvoie;
    }

    public function setCodeEnvoie(string $codeEnvoie): self
    {
        $this->codeEnvoie = $codeEnvoie;

        return $this;
    }

    public function getCniRetrait(): ?string
    {
        return $this->cniRetrait;
    }

    public function setCniRetrait(?string $cniRetrait): self
    {
        $this->cniRetrait = $cniRetrait;

        return $this;
    }

    public function getMontantRetrait(): ?int
    {
        return $this->montantRetrait;
    }

    public function setMontantRetrait(?int $montantRetrait): self
    {
        $this->montantRetrait = $montantRetrait;

        return $this;
    }

    public function getDateRetrait(): ?\DateTimeInterface
    {
        return $this->dateRetrait;
    }

    public function setDateRetrait(?\DateTimeInterface $dateRetrait): self
    {
        $this->dateRetrait = $dateRetrait;

        return $this;
    }

    public function getTelEnvoi(): ?int
    {
        return $this->telEnvoi;
    }

    public function setTelEnvoi(?int $telEnvoi): self
    {
        $this->telEnvoi = $telEnvoi;

        return $this;
    }

    public function getTelRetrait(): ?int
    {
        return $this->telRetrait;
    }

    public function setTelRetrait(?int $telRetrait): self
    {
        $this->telRetrait = $telRetrait;

        return $this;
    }

    public function getCommissionEtat(): ?int
    {
        return $this->commissionEtat;
    }

    public function setCommissionEtat(int $commissionEtat): self
    {
        $this->commissionEtat = $commissionEtat;

        return $this;
    }

    public function getCommissionAdmin(): ?int
    {
        return $this->commissionAdmin;
    }

    public function setCommissionAdmin(int $commissionAdmin): self
    {
        $this->commissionAdmin = $commissionAdmin;

        return $this;
    }

    public function getCommissionRetrait(): ?int
    {
        return $this->commissionRetrait;
    }

    public function setCommissionRetrait(int $commissionRetrait): self
    {
        $this->commissionRetrait = $commissionRetrait;

        return $this;
    }

    public function getCommissionEnvoie(): ?int
    {
        return $this->commissionEnvoie;
    }

    public function setCommissionEnvoie(int $commissionEnvoie): self
    {
        $this->commissionEnvoie = $commissionEnvoie;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
