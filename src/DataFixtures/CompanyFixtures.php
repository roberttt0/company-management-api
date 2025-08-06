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
        for ($i = 1; $i <= 5; $i++) {
            $company = new Company();
            $company->setName("Companie $i");
            $company->setCui("RO" . rand(1000000, 9999999));
            $company->setYearCreated(rand(1990, 2020));

            $manager->persist($company);
            $this->addReference("company_$i", $company);
        }

        $manager->flush();
    }
}
