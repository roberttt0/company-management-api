<?php

// src/DataFixtures/DepartmentFixtures.php

namespace App\DataFixtures;

use App\Entity\Department;
use App\Entity\DepartmentInfo;
use App\Entity\WorkPoint;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class DepartmentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $statuses = ['activ', 'inactiv'];

        for ($i = 1; $i <= 15; $i++) {
            $department = new Department();
            $department->setStatus($statuses[array_rand($statuses)]);
            $department->setPhoneNumber("03" . rand(1000000, 9999999));
            $department->setEmail("department$i@example.com");

            $deptInfoRef = $this->getReference("dept_info_" . rand(0, 4), DepartmentInfo::class);
            $workPointRef = $this->getReference("workpoint_" . rand(1, 10), WorkPoint::class);

            $department->setDepartment($deptInfoRef);
            $department->setWorkPoint($workPointRef);

            $manager->persist($department);
            $this->addReference("department_$i", $department);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [DepartmentInfoFixtures::class, WorkPointFixtures::class];
    }
}

