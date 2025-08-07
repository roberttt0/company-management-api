<?php

namespace App\Service;

use App\Repository\EmployeeRepository;

class SearchService
{
    public function __construct(
        private EmployeeRepository $employeeRepository
    )
    {
    }

    public function findEmployeeByFirstName(string $firstName): array
    {
        $employees = $this->employeeRepository->findEmployeeByFirstName($firstName);
        return $employees;
    }

    public function findEmployeeByJob(string $jobName): array
    {
        $employees = $this->employeeRepository->findEmployeeByJob($jobName);
        return $employees;
    }


}
