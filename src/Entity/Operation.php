<?php

namespace App\Entity;

use App\Repository\OperationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OperationRepository::class)
 */
class Operation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $operation_type;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\Column(type="date")
     */
    private $registered;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $label;

    /**
     * @ORM\ManyToOne(targetEntity=Account::class, inversedBy="operations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Account;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOperationType(): ?string
    {
        return $this->operation_type;
    }

    public function setOperationType(string $operation_type): self
    {
        $this->operation_type = $operation_type;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getRegistered(): ?\DateTimeInterface
    {
        return $this->registered;
    }

    public function setRegistered(\DateTimeInterface $registered): self
    {
        $this->registered = $registered;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getAccount(): ?Account
    {
        return $this->Account;
    }

    public function setAccount(?Account $Account): self
    {
        $this->Account = $Account;

        return $this;
    }
}
