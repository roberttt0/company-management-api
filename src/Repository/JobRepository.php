<?php

namespace App\Repository;

use App\Entity\Company;
use App\Entity\Department;
use App\Entity\DepartmentInfo;
use App\Entity\Job;
use App\Entity\JobInformation;
use App\Entity\WorkPoint;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Job>
 */
class JobRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Job::class);
    }

    //    /**
    //     * @return Job[] Returns an array of Job objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('j')
    //            ->andWhere('j.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('j.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Job
    //    {
    //        return $this->createQueryBuilder('j')
    //            ->andWhere('j.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function getJobs() : array {
        return $this->getEntityManager()->createQueryBuilder()
            ->select('j.id', 'j.salary', 'j.createdAt', 'j.updatedAt')
            ->addSelect( 'ji.id as jobNameId', 'ji.name as job')
            ->addSelect('d.id as departmentId',)
            ->addSelect('di.id as departmentInfoId', 'di.name as department')
            ->addSelect('w.id as workPointId', 'w.name as workPoint')
            ->addSelect('c.id as companyId', 'c.name as company')
            ->from (Job::class, 'j')
            ->join(JobInformation::class, 'ji' , 'with', 'j.jobType = ji.id')
            ->join(Department::class, 'd', 'WITH', 'j.department = d.id')
            ->join(DepartmentInfo::class, 'di', 'WITH', 'd.department = di.id')
            ->join(WorkPoint::class, 'w', 'WITH', 'd.workPoint = w.id')
            ->join(Company::class, 'c', 'WITH', 'w.company = c.id')
            ->orderBy("ji.name", "ASC")
            ->getQuery()
            ->getResult();
    }
}
