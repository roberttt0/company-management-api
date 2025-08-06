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
        $types = ['Sediu', 'Punct de lucru', 'Birou regional'];

        for ($i = 1; $i <= 10; $i++) {
            $workPoint = new WorkPoint();
            $workPoint->setAddress("Strada Exemplu $i");
            $workPoint->setCounty("Județ $i");
            $workPoint->setType($types[array_rand($types)]);
            $workPoint->setPhoneNumber("07" . rand(1000000, 9999999));
            $workPoint->setProgramStart(new \DateTime('08:00'));
            $workPoint->setProgramEnd(new \DateTime('17:00'));

            $companyRef = $this->getReference("company_" . rand(1, 5), Company::class);
            $workPoint->setCompany($companyRef);

            $manager->persist($workPoint);
            $this->addReference("workpoint_$i", $workPoint);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [CompanyFixtures::class];
    }
}
