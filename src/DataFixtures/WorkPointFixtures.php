<?php
// src/DataFixtures/WorkPointFixtures.php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\WorkPoint;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class WorkPointFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Set de litere distribuite aleator
        $lettersDistribution = [
            'A' => 1,
            'B' => 2,
            'C' => 3,
            'D' => 5,
            'E' => 7,
            'F' => 4,
            'G' => 6,
            'H' => 2,
            'I' => 3,
            'J' => 1,
            'K' => 2,
            'L' => 8,
            'M' => 10,
            'N' => 4,
            'O' => 5,
            'P' => 6,
            'R' => 7,
            'S' => 4
        ];

        // Verificăm să fie exact 80
        $total = array_sum($lettersDistribution);
        if ($total !== 80) {
            throw new \Exception("Distribuția nu însumează 80, are $total.");
        }

        $types = [
            'Sediu',
            'Punct de lucru',
            'Birou regional',
            'Centru logistic',
            'Centru de suport',
            'Hub de cercetare',
            'Centru de service',
        ];

        $i = 1;
        foreach ($lettersDistribution as $letter => $count) {
            for ($j = 1; $j <= $count; $j++) {
                $workPoint = new WorkPoint();

                // Nume care începe cu litera respectivă
                $name = $letter . " - Punct de lucru " . $j;
                $workPoint->setName($name);

                $workPoint->setAddress("Strada Exemplu " . $i . ", Nr. " . rand(1, 100));
                $workPoint->setCounty("Județ " . rand(1, 41));
                $workPoint->setType($types[array_rand($types)]);
                $workPoint->setPhoneNumber("07" . rand(1000000, 9999999));

                // Program variabil
                $startHour = rand(7, 10);
                $endHour = $startHour + rand(7, 10);
                $workPoint->setProgramStart(new \DateTime(sprintf('%02d:00', $startHour)));
                $workPoint->setProgramEnd(new \DateTime(sprintf('%02d:00', $endHour)));

                // Asociază la una dintre cele 5 companii existente
                $companyRef = $this->getReference("company_" . rand(1, 5), Company::class);
                $workPoint->setCompany($companyRef);

                $manager->persist($workPoint);
                $this->addReference("workpoint_" . $i, $workPoint);

                $i++;
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [CompanyFixtures::class];
    }
}
