<?php

namespace App\Service;

use App\DTO\CompanyDTO;
use App\DTO\WorkPointDTO;
use App\Entity\Company;
use AutoMapperPlus\AutoMapperInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CompanyService
{
    public function __construct(
        private EntityManagerInterface $manager,
        private AutoMapperInterface    $mapper
    )
    {
    }

    public function showCompany(): array
    {
        $companies = $this->manager->getRepository(Company::class)->findAll();
        return $this->mapper->mapMultiple($companies, CompanyDTO::class);
    }

    public function addCompany(CompanyDTO $dto): Company
    {
        $companies = $this->mapper->map($dto, Company::class);

        if ($companies->getParentId() !== null) {
            $holdingCompany = $this->manager->getRepository(Company::class)->find($companies->getParentId());
            if ($holdingCompany == null) {
                throw new NotFoundHttpException("Compania Holding nu exista!");
            }
        }

        $this->manager->persist($companies);
        $this->manager->flush();

        return $companies;
    }

    public function changeName(int $id, string $name): CompanyDTO
    {
        $company = $this->manager->getRepository(Company::class)->find($id);
        if ($company === null) {
            throw new NotFoundHttpException("Compania nu a fost gasita!");
        }
        $company->setName($name);
        $this->manager->persist($company);
        $this->manager->flush();
        return $this->mapper->map($company, CompanyDTO::class);
    }

    public function readCompany(int $id): CompanyDTO
    {
        $company = $this->manager->getRepository(Company::class)->find($id);

        if ($company === null) {
            throw new NotFoundHttpException("Compania nu a fost gasita!");
        }

        return $this->mapper->map($company, CompanyDTO::class);
    }

    public function deleteCompany(int $id): void
    {
        $company = $this->manager->getRepository(Company::class)->find($id);
        if ($company === null) {
            throw new NotFoundHttpException("Compania nu a fost gasita!");
        }
        $this->manager->remove($company);
        $this->manager->flush();
    }

    public function showWorkPoints(int $id): array
    {
        $company = $this->manager->getRepository(Company::class)->find($id);
        if ($company === null) {
            throw new NotFoundHttpException("Compania nu a fost gasita!");
        }
        $workPoints = [];
        foreach ($company->getWorkPoints() as $item) {
            $workPoints[] = $this->mapper->map($item, WorkPointDTO::class);
        }
        return $workPoints;
    }
}
