<?php
// src/DataFixtures/EmployeeFixtures.php

namespace App\DataFixtures;

use App\Entity\Employee;
use App\Entity\Job;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EmployeeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $firstNames = ['Andrei', 'Maria', 'Ioana', 'George', 'Alina', 'Vlad', 'Elena', 'Radu', 'Cristina', 'Diana'];
        $lastNames = ['Popescu', 'Ionescu', 'Georgescu', 'Stan', 'Dumitrescu', 'Marin', 'Petrescu', 'Ilie', 'Vasilescu', 'Dragomir'];

        for ($i = 1; $i <= 40; $i++) {
            $employee = new Employee();

            $firstName = $firstNames[array_rand($firstNames)];
            $lastName = $lastNames[array_rand($lastNames)];
            $email = strtolower($firstName . '.' . $lastName . $i . '@example.com');

            $employee->setFirstName($firstName);
            $employee->setLastName($lastName);
            $employee->setEmail($email);
            $employee->setPhoneNumber('07' . rand(1000000, 9999999));

            $hireDate = new \DateTime();
            $hireDate->modify('-' . rand(0, 3650) . ' days');
            $employee->setHireDate($hireDate);

            $jobRefIndex = rand(1, 10);
            $employee->setJob($this->getReference("job_$jobRefIndex", Job::class));

            $manager->persist($employee);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [JobFixtures::class];
    }
}
