<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

abstract class BaseFixtures extends Fixture
{
    /** @var ObjectManager */
    private $manager;
    /** @var Generator */
    protected $faker;
    private $referencesIndex = [];

    abstract protected function loadData(ObjectManager $manager);

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->faker = Factory::create();
        $this->loadData($manager);
    }

    /**
     * Create many objects at once:
     *
     *      $this->createMany(10, function(int $i) {
     *          $user = new User();
     *          $user->setFirstName('Ryan');
     *
     *           return $user;
     *      });
     *
     * @param int $count
     * @param string $className
     * @param callable $factory
     * @internal param string $groupName Tag these created objects with this group name,
     *                            and use this later with getRandomReference(s)
     *                            to fetch only from this specific group.
     */
    protected function createMany(int $count, string $className, callable $factory)
    {
        for ($i = 0; $i < $count; $i++) {
            $entity = new $className();
            $factory($entity, $i);
            $this->manager->persist($entity);
            // store for usage later as App\Entity\ClassName_#COUNT#
            $this->addReference($className . '_' . $i, $entity);
        }
    }

//    protected function getRandomReference(string $groupName)
//    {
//        if (!isset($this->referencesIndex[$groupName])) {
//            $this->referencesIndex[$groupName] = [];
//            foreach ($this->referenceRepository->getReferences() as $key => $ref) {
//                if (strpos($key, $groupName . '_') === 0) {
//                    $this->referencesIndex[$groupName][] = $key;
//                }
//            }
//        }
//        if (empty($this->referencesIndex[$groupName])) {
//            throw new \InvalidArgumentException(sprintf('Did not find any references saved with the group name "%s"', $groupName));
//        }
//        $randomReferenceKey = $this->faker->randomElement($this->referencesIndex[$groupName]);
//        return $this->getReference($randomReferenceKey);
//    }
//
//    protected function getRandomReferences(string $className, int $count)
//    {
//        $references = [];
//        while (count($references) < $count) {
//            $references[] = $this->getRandomReference($className);
//        }
//        return $references;
//    }
}