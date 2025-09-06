<?php

namespace App\Repository;

use App\Entity\Company;
use App\Entity\Department;
use App\Entity\DepartmentInfo;
use App\Entity\Employee;
use App\Entity\Job;
use App\Entity\WorkPoint;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Department>
 */
class DepartmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Department::class);
    }

    //    /**
    //     * @return Department[] Returns an array of Department objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('d.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Department
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    // Examples of query builder
    public function findJobByDepartmentId(int $departmentId): array
    {
        return $this->createQueryBuilder('d')
            ->innerJoin('d.jobs', 'j')
            ->andWhere('d.id = :departmentId')
            ->setParameter('departmentId', $departmentId)
            ->getQuery()
            ->getResult();
    }

    public function findTest(int $departmentId): array
    {
        return $this->getEntityManager()->createQueryBuilder()
            ->select('j.name', 'j.id', 'j.department')
            ->addSelect('t')
            ->from(Job::class, 'j')
            ->getQuery()
            ->getResult();
    }

    public function findEmployeesByDepartmentId(int $departmentId): array
    {
        return $this->getEntityManager()->createQueryBuilder()
            ->select('e')
            ->from(Employee::class, 'e')
            ->join('e.department', 'd')
            ->where('d.id = :departmentId')
            ->setParameter('departmentId', $departmentId)
            ->getQuery()
            ->getResult();
    }

//}

    public function showDepartmentNameAndCompany(): array
    {
        return $this->getEntityManager()->createQueryBuilder()
            ->select('d.id', 'di.name', 'w.name as workPoint', 'c.name as company', 'd.status', 'd.phoneNumber', 'd.email', 'd.createdAt', 'd.updatedAt')
            ->addSelect('c.id as companyId', 'w.id as workPointId', 'di.id as departmentNameId')
            ->from(Department::class, 'd')
            ->join(DepartmentInfo::class, 'di', 'WITH', 'd.department = di.id')
            ->join(WorkPoint::class, 'w', 'WITH', 'd.workPoint = w.id')
            ->join(Company::class, 'c', 'WITH', 'w.company = c.id')
            ->orderBy('d.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
