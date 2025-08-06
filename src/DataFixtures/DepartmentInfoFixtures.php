<?php
// src/DataFixtures/DepartmentInfoFixtures.php

namespace App\DataFixtures;

use App\Entity\DepartmentInfo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DepartmentInfoFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $names = ['DezvoltareSoft', 'Achizitii', 'HR', 'Financiar', 'Logistica'];

        foreach ($names as $index => $name) {
            $deptInfo = new DepartmentInfo();
            $deptInfo->setName($name);

            $manager->persist($deptInfo);
            $this->addReference("dept_info_$index", $deptInfo);
        }

        $manager->flush();
    }
}
