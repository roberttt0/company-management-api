<?php
// src/DataFixtures/JobFixtures.php

namespace App\DataFixtures;

use App\Entity\Department;
use App\Entity\Job;
use App\Entity\JobInformation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class JobFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $job = new Job();
            $job->setSalary(rand(3000, 12000));
            $job->setJobType($this->getReference("job_info_" . rand(0, 4), JobInformation::class));
            $job->setDepartment($this->getReference("department_" . rand(1, 15), Department::class));

            $manager->persist($job);
            $this->addReference("job_$i", $job);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [JobInformationFixtures::class, DepartmentFixtures::class];
    }
}
