<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Attribute\MaxDepth;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company
{
    use TimestampableEntity;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $cui = null;

    #[ORM\Column]
    private ?int $yearCreated = null;

    #[ORM\Column(nullable: true)]
    private ?int $parentId = null;

    /**
     * @var Collection<int, WorkPoint>
     */
    #[MaxDepth(1)]
    #[ORM\OneToMany(targetEntity: WorkPoint::class, mappedBy: 'company', orphanRemoval: true)]
    private Collection $workPoints;

    public function __construct()
    {
        $this->workPoints = new ArrayCollection();
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

    public function getCui(): ?string
    {
        return $this->cui;
    }

    public function setCui(string $cui): static
    {
        $this->cui = $cui;

        return $this;
    }

    public function getYearCreated(): ?int
    {
        return $this->yearCreated;
    }

    public function setYearCreated(int $yearCreated): static
    {
        $this->yearCreated = $yearCreated;

        return $this;
    }

    public function getParentId(): ?int
    {
        return $this->parentId;
    }

    public function setParentId(?int $parentId): static
    {
        $this->parentId = $parentId;

        return $this;
    }

    /**
     * @return Collection<int, WorkPoint>
     */
    public function getWorkPoints(): Collection
    {
        return $this->workPoints;
    }

    public function setWorkPoints(WorkPoint $workPoints): static
    {
        if (!$this->workPoints->contains($workPoints)) {
            $this->workPoints->add($workPoints);
            $workPoints->setCompany($this);
        }

        return $this;
    }

    public function removeWorkPoints(WorkPoint $workPoints): static
    {
        if ($this->workPoints->removeElement($workPoints)) {
            // set the owning side to null (unless already changed)
            if ($workPoints->getCompany() === $this) {
                $workPoints->setCompany(null);
            }
        }

        return $this;
    }
}
