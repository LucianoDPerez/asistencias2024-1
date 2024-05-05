<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: "App\Repository\TechnicalReportRepository")]
#[ORM\Table(name: "technical_reports")]
#[ORM\HasLifecycleCallbacks]
class TechnicalReport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private $id;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\Column(type: "text")]
    private $content;

    #[ORM\ManyToOne(targetEntity: "Service", fetch: "EAGER", inversedBy: "technicalReports")]
    #[ORM\JoinColumn(nullable: false)]
    private ?Service $service;

    #[ORM\Column(type: "boolean")]
    private $closed = true;

    #[ORM\Column(type: "float", nullable: true)]
    private $responseTime = 0;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?DateTimeInterface $createdAt = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?DateTimeInterface $updatedAt = null;


    #[ORM\PrePersist]
    public function calculateResponseTime(): void
    {
        $serviceAssignedDate = $this->service->getAssignedDate();
        $serviceAssignedTime = $this->service->getAssignedTime();

         $serviceAssignedDateTime = new DateTime($serviceAssignedDate->format('Y-m-d') . ' ' . $serviceAssignedTime->format('H:i:s'));

         $timezone = new \DateTimeZone('America/Argentina/Buenos_Aires');
         $now = new DateTime('now', $timezone);

         $timeDifference = $now->getTimestamp() - $serviceAssignedDateTime->getTimestamp();

         $responseTimeInMinutes = round($timeDifference);

         $responseTimeInHours = round($responseTimeInMinutes / 60, 2);

         $this->responseTime = $responseTimeInHours;
    }

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->createdAt = new \DateTimeImmutable('America/Argentina/Buenos_Aires');
    }

    #[ORM\PreUpdate]
    public function setUpdatedAtValue(): void
    {
        $this->updatedAt = new \DateTimeImmutable('America/Argentina/Buenos_Aires');
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    public function getService():?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function isClosed(): bool
    {
        return $this->closed;
    }

    public function setClosed(bool $closed): void
    {
        $this->closed=$closed;
    }

    public function getResponseTime(): float
    {
        return $this->responseTime;
    }


    /**
     * @return DateTimeInterface
     */
    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @return DateTimeInterface
     */
    public function getUpdatedAt(): DateTimeInterface
    {
        return $this->updatedAt;
    }


}
