<?php

namespace App\Repository;

use App\Entity\Company;
use App\Entity\Department;
use App\Entity\DepartmentInfo;
use App\Entity\WorkPoint;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Company>
 */
class CompanyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Company::class);
    }

    //    /**
    //     * @return Company[] Returns an array of Company objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Company
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function getDepartmentsOfCompany() : array {
        return $this->getEntityManager()->createQueryBuilder()
            ->select('c.id','c.name', 'di.id as departmentNameId', 'd.id as departmentId')
            ->from(Company::class, 'c')
            ->join(WorkPoint::class, 'w', 'WITH', 'w.company = c.id')
            ->join(Department::class, 'd', 'WITH', 'd.workPoint = w.id')
            ->join(DepartmentInfo::class, 'di', 'WITH', 'd.department = di.id')
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
