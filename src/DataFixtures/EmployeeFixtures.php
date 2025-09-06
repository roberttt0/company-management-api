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

        // Se creează un pool de nume unice
        $uniqueNames = [];
        foreach ($firstNames as $firstName) {
            foreach ($lastNames as $lastName) {
                $uniqueNames[] = ['firstName' => $firstName, 'lastName' => $lastName];
            }
        }

        // Se amestecă pool-ul de nume pentru a fi aleatorii
        shuffle($uniqueNames);

        for ($i = 0; $i < 40; $i++) {
            // Verifică dacă există nume suficiente în pool
            if (!isset($uniqueNames[$i])) {
                break;
            }

            $employee = new Employee();

            // Obține numele unic din pool
            $firstName = $uniqueNames[$i]['firstName'];
            $lastName = $uniqueNames[$i]['lastName'];
            $email = strtolower($firstName . '.' . $lastName . '@example.com');

            $employee->setFirstName($firstName);
            $employee->setLastName($lastName);
            $employee->setEmail($email);
            $employee->setPhoneNumber('07' . rand(1000000, 9999999));

            $hireDate = new \DateTime();
            $hireDate->modify('-' . rand(0, 3650) . ' days');
            $employee->setHireDate($hireDate);

            // Alege un job aleatoriu
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
