<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\AbTestRepository;
use App\Utils\DateTimeUtils;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Throwable;

#[ORM\Entity(repositoryClass: AbTestRepository::class)]
#[ORM\Table(name: 'ab_test')]
#[UniqueEntity(fields: ['patientIdentifier'], message: 'There is already an patient with this patient identifier')]
#[ORM\HasLifecycleCallbacks]
class AbTest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn]
    private User $user;

    #[ORM\Column(type: 'string', length: 180, nullable: false)]
    private ?string $patient;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private ?string $patientIdentifier;

    #[ORM\Column(type: 'datetime_immutable', nullable: false)]
    private ?DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: 'integer', nullable: false)]
    private ?int $abTest = null;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @throws Throwable
     */
    #[ORM\PrePersist]
    public function onCreate(): void
    {
        $this->createdAt = DateTimeUtils::createNow();
        $this->abTest = random_int(0, 1);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getPatient(): ?string
    {
        return $this->patient;
    }

    public function setPatient(?string $patient): void
    {
        $this->patient = $patient;
    }

    public function getPatientIdentifier(): ?string
    {
        return $this->patientIdentifier;
    }

    public function setPatientIdentifier(?string $patientIdentifier): void
    {
        $this->patientIdentifier = $patientIdentifier;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getAbTest(): ?int
    {
        return $this->abTest;
    }
}
