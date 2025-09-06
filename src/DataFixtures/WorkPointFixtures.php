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
        // Nume realiste pentru punctele de lucru, asociate companiilor
        $workPointNames = [
            'Google' => [
                'Birou de dezvoltare software Google',
                'Google Cloud Data Center',
                'Google Hub București',
            ],
            'Apple' => [
                'Centrul de service Apple',
                'Apple Store Piața Victoriei',
                'Birou de vânzări Apple',
            ],
            'Microsoft' => [
                'Microsoft Sediu România',
                'Microsoft Innovation Center',
                'Centrul de suport Microsoft',
            ],
            'Amazon' => [
                'Centrul de distribuție Amazon',
                'Amazon Web Services (AWS) Office',
                'Birou de recrutare Amazon',
            ],
            'Tesla' => [
                'Tesla Service Center',
                'Tesla Showroom',
                'Centrul de cercetare Tesla',
            ],
        ];

        $types = ['Sediu', 'Punct de lucru', 'Birou regional'];

        for ($i = 1; $i <= 10; $i++) {
            $workPoint = new WorkPoint();
            $workPoint->setAddress("Strada Exemplu " . $i);

            // Obține o companie aleatorie pentru a asocia punctul de lucru
            $companyRef = $this->getReference("company_" . rand(1, 5), Company::class);
            $companyName = $companyRef->getName();

            // Setează un nume realist din lista specifică companiei
            $namePool = $workPointNames[$companyName];
            $workPoint->setName($namePool[array_rand($namePool)]);

            $workPoint->setCounty("Județ " . $i);
            $workPoint->setType($types[array_rand($types)]);
            $workPoint->setPhoneNumber("07" . rand(1000000, 9999999));
            $workPoint->setProgramStart(new \DateTime('08:00'));
            $workPoint->setProgramEnd(new \DateTime('17:00'));

            $workPoint->setCompany($companyRef);

            $manager->persist($workPoint);
            $this->addReference("workpoint_" . $i, $workPoint);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [CompanyFixtures::class];
    }
}
