<?php

namespace App\Repository;

use App\Entity\Company;
use App\Entity\Department;
use App\Entity\DepartmentInfo;
use App\Entity\Employee;
use App\Entity\Job;
use App\Entity\JobInformation;
use App\Entity\WorkPoint;
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
            ->where('lower(e.firstName) like :firstName')
            ->setParameter('firstName','%'. strtolower($firstName) . '%')
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
            ->where('lower(ji.name) like :jobName')
            ->setParameter('jobName', '%' . strtolower($jobName) . '%')
            ->getQuery()
            ->getResult();
    }

    public function getEmployeeInfo() : array {
        return $this->getEntityManager()->createQueryBuilder()
            ->select('e.id', 'e.firstName', 'e.lastName', 'e.email', 'e.phoneNumber', 'e.hireDate', 'ji.name as job', 'di.name as department', 'w.name as workPoint','c.name as Company', 'e.createdAt', 'e.updatedAt')
            ->addSelect('w.id as workPointId', 'c.id as companyId', 'd.id as departmentId', 'di.id as departmentInfoId', 'j.id as jobId', 'ji.id as jobInformationId')
            ->from(Employee::class, 'e')
            ->join(Job::class, 'j', 'WITH', 'e.job = j.id')
            ->join(JobInformation::class, 'ji', 'WITH', 'ji.id = j.jobType')
            ->join(Department::class, 'd', 'WITH', 'd.id = j.department')
            ->join(DepartmentInfo::class, 'di', 'WITH', 'di.id = d.department')
            ->join(WorkPoint::class, 'w', 'WITH', 'w.id = d.workPoint')
            ->join(Company::class, 'c', 'WITH', 'c.id = w.company')
            ->orderBy('e.id')
            ->getQuery()
            ->getResult();
    }
}
