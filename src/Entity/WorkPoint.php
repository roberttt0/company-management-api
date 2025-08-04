<?php

namespace App\Entity;

use App\Repository\WorkPointRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\MaxDepth;

#[ORM\Entity(repositoryClass: WorkPointRepository::class)]
class WorkPoint
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(length: 255)]
    private ?string $county = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column]
    private ?string $phoneNumber = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTime $programStart = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTime $programEnd = null;

    #[MaxDepth(1)]
    #[ORM\ManyToOne(inversedBy: 'workPoints')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company = null;

    /**
     * @var Collection<int, Department>
     */
    #[ORM\OneToMany(targetEntity: Department::class, mappedBy: 'workPoints', orphanRemoval: true)]
    private Collection $departments;

    public function __construct()
    {
        $this->departments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getCounty(): ?string
    {
        return $this->county;
    }

    public function setCounty(string $county): static
    {
        $this->county = $county;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

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

    public function getProgramStart(): ?\DateTime
    {
        return $this->programStart;
    }

    public function setProgramStart(\DateTime $programStart): static
    {
        $this->programStart = $programStart;

        return $this;
    }

    public function getProgramEnd(): ?\DateTime
    {
        return $this->programEnd;
    }

    public function setProgramEnd(\DateTime $programEnd): static
    {
        $this->programEnd = $programEnd;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): static
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return Collection<int, Department>
     */
    public function getDepartments(): Collection
    {
        return $this->departments;
    }

    public function addDepartment(Department $department): static
    {
        if (!$this->departments->contains($department)) {
            $this->departments->add($department);
            $department->setWorkPoint($this);
        }
        return $this;
    }

    public function removeDepartment(Department $department): static
    {
        if ($this->departments->removeElement($department)) {
            // set the owning side to null (unless already changed)
            if ($department->getWorkPoint() === $this) {
                $department->setWorkPoint(null);
            }
        }
        return $this;
    }
}
