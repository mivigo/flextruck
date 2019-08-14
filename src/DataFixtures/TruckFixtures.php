<?php

namespace App\DataFixtures;

use App\Entity\Delivery;
use App\Entity\Route;
use App\Entity\Truck;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TruckFixtures extends BaseFixtures
{

    private static $routeTitles = [
        'Route 66',
        'Pacific Coast Highway',
        'Extraterrestrial Highway',
        'Oregon Trail',
        'Blue Ridge Parkway',
        'Going-to-the-Sun Road'
    ];
    private static $truckRegistration = [
        'Truck Registration – First Time',
        'Vehicle Addition',
        'Form 2290',
        'IFTA Reporting – Company'
    ];
    private static $truckVendor = [
        'Canada',
        'Australia',
        'Mexico',
        'Asia',
        'United Kingdom'
    ];
    private static $truckModel = [
        'Honda',
        'Ford',
        'Diesel',
        'Mitsubi',
        'Bugatti'
    ];
    private static $clientNames = [
        'Oleg Gazmanovv',
        'Henry Wasker',
        'Helen Swarts',
        'Mao Lei',
        'Egor Egorka',
        'Till Lindemann'
    ];

    private static $clientAddresses = [
        'U Imperiálu 198/11',
        'Saltiv str. 342',
        '2300 N Airport Blvd, Springfield, MO 65802',
        '132 N Main St, Fair Grove, MO 65648',
        '1360 N Hickory St, Buffalo, MO 65622',
        'Буффало, Миссури 65622',
        '1518 North Ash Street, Buffalo, MO 65622'
    ];

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(10, Truck::class, function (Truck $truck) use ($manager) {

            $truck->setRegistration($this->faker->randomElement(self::$truckRegistration));
            $truck->setVendor($this->faker->randomElement(self::$truckVendor));
            $truck->setModel($this->faker->randomElement(self::$truckModel));
            $truck->setWeight($this->faker->randomFloat());
            $truck->setLength($this->faker->randomFloat());
            $truck->setHeight($this->faker->randomFloat());

            for ($i = 0; $i <= 3; $i++) {
                $route = new Route();
                $route->setRouteTitle($this->faker->randomElement(self::$routeTitles));
                $route->setStartTime($this->faker->dateTimeBetween('-100 days', '-1 days'));
                $route->setEndTime($this->faker->dateTimeBetween('1 days', '100 days'));

                if ($this->faker->boolean(63)) {
                    $route->setTruck($truck);
                }
                $manager->persist($route);

            $delivery = new Delivery();
            $delivery->setClientName($this->faker->randomElement(self::$clientNames));
            $delivery->setClientAddress($this->faker->randomElement(self::$clientAddresses));
            $delivery->setDeliveryTime($this->faker->dateTimeBetween('1 days', '100 days'));
            $delivery->setLatitude($this->faker->randomFloat());
            $delivery->setLongtitude($this->faker->randomFloat());
            $delivery->setDone($this->faker->boolean(50));

            if ($this->faker->boolean(75)) {
                $delivery->setRoute($route);
            }
            $manager->persist($delivery);
            }
        });
        $manager->flush();
    }
}
