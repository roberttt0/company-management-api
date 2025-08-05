<?php

namespace App\Service;

use App\DTO\CompanyDTO;
use App\DTO\OutputCompanyDTO;
use App\DTO\OutputWorkPointDTO;
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
        return $this->mapper->mapMultiple($companies, OutputCompanyDTO::class);
    }

    public function addCompany(CompanyDTO $dto): OutputCompanyDTO
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

//        return $companies;
        return $this->mapper->map($companies, OutputCompanyDTO::class);
    }

    public function changeCompany(int $id, CompanyDTO $dto): OutputCompanyDTO
    {
        $company = $this->manager->getRepository(Company::class)->find($id);
        if ($company === null) {
            throw new NotFoundHttpException("Compania nu a fost gasita!");
        }
        $company->setName($dto->name);
        $company->setCui($dto->cui);
        $company->setDateCreated($dto->dateCreated);
        $company->setParentId($dto->parentId);
        $this->manager->persist($company);
        $this->manager->flush();
        return $this->mapper->map($company, OutputCompanyDTO::class);
    }

    public function readCompany(int $id): OutputCompanyDTO
    {
        $company = $this->manager->getRepository(Company::class)->find($id);

        if ($company === null) {
            throw new NotFoundHttpException("Compania nu a fost gasita!");
        }

        return $this->mapper->map($company, OutputCompanyDTO::class);
    }

    public function deleteCompany(int $id): array
    {
        $company = $this->manager->getRepository(Company::class)->find($id);
        if ($company === null) {
            throw new NotFoundHttpException("Compania nu a fost gasita!");
        }
        $this->manager->remove($company);
        $this->manager->flush();
        return $this->showCompany();
    }

    public function showWorkPoints(int $id): array
    {
        $company = $this->manager->getRepository(Company::class)->find($id);
        if ($company === null) {
            throw new NotFoundHttpException("Compania nu a fost gasita!");
        }
        $workPoints = [];
        foreach ($company->getWorkPoints() as $item) {
            $workPoints[] = $this->mapper->map($item, OutputWorkPointDTO::class);
        }
        return $workPoints;
    }
}
