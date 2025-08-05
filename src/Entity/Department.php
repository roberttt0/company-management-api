<?php

namespace App\Entity;

use App\Repository\DepartmentRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: DepartmentRepository::class)]
class Department
{
    use TimestampableEntity;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'departmentsList')]
    #[ORM\JoinColumn(nullable: false)]
    private ?DepartmentInfo $department = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column(length: 255)]
    private ?string $phoneNumber = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\ManyToOne(inversedBy: 'departments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?WorkPoint $workPoint = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDepartment(): ?DepartmentInfo
    {
        return $this->department;
    }

    public function setDepartment(?DepartmentInfo $department): static
    {
        $this->department = $department;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getWorkPoint(): ?WorkPoint
    {
        return $this->workPoint;
    }

    public function setWorkPoint(?WorkPoint $workPoint): static
    {
        $this->workPoint = $workPoint;

        return $this;
    }
}
