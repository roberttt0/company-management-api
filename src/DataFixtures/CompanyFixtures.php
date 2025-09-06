<?php
// src/DataFixtures/CompanyFixtures.php

namespace App\DataFixtures;

use App\Entity\Company;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CompanyFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // O listă de nume reale de companii
        $companyNames = [
            'Google',
            'Apple',
            'Microsoft',
            'Amazon',
            'Tesla',
        ];

        // Se iterează prin lista de nume
        for ($i = 0; $i < count($companyNames); $i++) {
            $company = new Company();
            // Setează numele companiei din array
            $company->setName($companyNames[$i]);
            // Setează un CUI aleatoriu, conform formatului românesc
            $company->setCui("RO" . rand(10000000, 99999999));
            // Setează un an de înființare aleatoriu
            $company->setYearCreated(rand(1990, 2024));

            $manager->persist($company);
            // Salvează o referință la obiect
            $this->addReference("company_" . ($i + 1), $company);
        }

        $manager->flush();
    }
}
