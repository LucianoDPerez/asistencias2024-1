<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Client::class, fetch: "EAGER", inversedBy: 'services')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $assignedDate = null;

    #[ORM\Column(type: 'time')]
    private ?\DateTimeInterface $assignedTime = null;

    #[ORM\ManyToOne(targetEntity: ServiceType::class, fetch: "EAGER", inversedBy: "services")]
    private ?ServiceType $serviceType = null;

    #[ORM\Column(type: 'text')]
    private ?string $description = null;

    #[ORM\Column(type: 'string', length: 20)]
    private ?string $status = 'pending';

    #[ORM\Column(type: 'boolean')]
    private ?bool $isActive = true;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'service', targetEntity: TechnicalReport::class, orphanRemoval: true)]
    private Collection $technicalReports;

    public function __construct()
    {
        $this->technicalReports = new ArrayCollection();
    }

    public function getId():?int
    {
        return $this->id;
    }

    public function getClient():?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getAssignedDate():?\DateTimeInterface
    {
        return $this->assignedDate;
    }

    public function setAssignedDate(\DateTimeInterface $assignedDate): self
    {
        $this->assignedDate = $assignedDate;

        return $this;
    }

    public function getAssignedTime():?\DateTimeInterface
    {
        return $this->assignedTime;
    }

    public function setAssignedTime(\DateTimeInterface $assignedTime): self
    {
        $this->assignedTime = $assignedTime;

        return $this;
    }

    public function getServiceType():?ServiceType
    {
        return $this->serviceType;
    }

    public function setServiceType(?ServiceType $serviceType): self
    {
        $this->serviceType = $serviceType;

        return $this;
    }

    public function getServiceTypeName(): ?string
    {
        return $this->serviceType?->getName();
    }

    public function getDescription():?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStatus():?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getIsActive():?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getCreatedAt():?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt():?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    #[ORM\PrePersist]
    public function setCreatedAtValue()
    {
        $this->createdAt = new \DateTime();
    }

    #[ORM\PreUpdate]
    public function setUpdatedAtValue()
    {
        $this->updatedAt = new \DateTime();
    }

    public function addTechnicalReports(TechnicalReport $techReport): self
    {
        if (!$this->technicalReports->contains($techReport)) {
            $this->technicalReports->add($techReport);
            $techReport->setService($this);
        }

        return $this;
    }

    public function removeTechnicalReports(TechnicalReport $techReport): self
    {
        if ($this->technicalReports->contains($techReport)) {
            $this->technicalReports->removeElement($techReport);
            if ($techReport->getService() === $this) {
                $techReport->getService(null);
            }
        }

        return $this;
    }

    public function getTechnicalReports(): Collection
    {
        return $this->technicalReports;
    }
}