<?php

namespace App\Entity;

use App\Repository\DepartmentInfoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: DepartmentInfoRepository::class)]
class DepartmentInfo
{
    use TimestampableEntity;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Department>
     */
    #[ORM\OneToMany(targetEntity: Department::class, mappedBy: 'department', orphanRemoval: true)]
    private Collection $departmentsList;

    public function __construct()
    {
        $this->departmentsList = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Department>
     */
    public function getDepartmentsList(): Collection
    {
        return $this->departmentsList;
    }

    public function addDepartmentsList(Department $departmentsList): static
    {
        if (!$this->departmentsList->contains($departmentsList)) {
            $this->departmentsList->add($departmentsList);
            $departmentsList->setDepartment($this);
        }

        return $this;
    }

    public function removeDepartmentsList(Department $departmentsList): static
    {
        if ($this->departmentsList->removeElement($departmentsList)) {
            // set the owning side to null (unless already changed)
            if ($departmentsList->getDepartment() === $this) {
                $departmentsList->setDepartment(null);
            }
        }

        return $this;
    }
}
