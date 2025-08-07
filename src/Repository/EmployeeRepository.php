<?php

namespace App\Repository;

use App\Entity\Employee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Employee>
 */
class EmployeeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employee::class);
    }

    //    /**
    //     * @return Employee[] Returns an array of Employee objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Employee
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function findByJobId(int $jobId) : array {
        return $this->createQueryBuilder('e')
            ->where ('e.job = :jobId')
            ->setParameter('jobId', $jobId)
            ->getQuery()
            ->getResult();
    }

    public function findEmployeeByFirstName(string $firstName) : array {
        return $this->getEntityManager()->createQueryBuilder()
            ->select('e.firstName', 'e.lastName', 'di.name as Department', 'ji.name as Job', 'w.id as WorkPoint', 'c.name as Company')
            ->from(Employee::class, 'e')
            ->join('e.job', 'j')
            ->join('j.jobType', 'ji')
            ->join('j.department', 'd')
            ->join('d.department', 'di')
            ->join('d.workPoint', 'w')
            ->join('w.company', 'c')
            ->where('lower(e.firstName) = :firstName')
            ->setParameter('firstName', $firstName)
            ->getQuery()
            ->getResult();
    }

    public function findEmployeeByJob(string $jobName) : array {
        return $this->getEntityManager()->createQueryBuilder()
        ->select('e.firstName', 'e.lastName', 'di.name as Department', 'ji.name as Job', 'w.id as WorkPoint', 'c.name as Company')
            ->from(Employee::class, 'e')
            ->join('e.job', 'j')
            ->join('j.jobType', 'ji')
            ->join('j.department', 'd')
            ->join('d.department', 'di')
            ->join('d.workPoint', 'w')
            ->join('w.company', 'c')
            ->where('lower(ji.name) = :jobName')
            ->setParameter('jobName', $jobName)
            ->getQuery()
            ->getResult();
    }
}
