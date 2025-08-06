<?php
// src/DataFixtures/JobInformationFixtures.php

namespace App\DataFixtures;

use App\Entity\JobInformation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class JobInformationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $jobNames = ['Manager', 'Developer', 'Tester', 'Contabil', 'Operator'];

        foreach ($jobNames as $index => $name) {
            $jobInfo = new JobInformation();
            $jobInfo->setName($name);

            $manager->persist($jobInfo);
            $this->addReference("job_info_$index", $jobInfo);
        }

        $manager->flush();
    }
}
