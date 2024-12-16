<?php declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Type;
use App\Entity\Vehicle;

use Symfony\Component\Uid\Uuid;

use Doctrine\Persistence\ObjectManager;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class VehicleFixtures extends Fixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function getOrder(): int
    {
        return 3;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager): void
    {
        $existingLabels = [];

        $brands = ['Ford', 'Toyota', 'BMW', 'Chevrolet', 'Nissan'];
        $seatsOptions = [2, 4, 5];
        $colors = ['Red', 'Blue', 'White', 'Black', 'Silver'];
        $types = [TypeFixtures::UTILITY_REFERENCE, TypeFixtures::SUV_REFERENCE, TypeFixtures::CONVERTIBLE_REFERENCE];
        $gvwrValues = [3500.5, 4000.0, 4500.0];

        for ($i = 1; $i <= 150; $i++) {
            $vehicle = new Vehicle;

            $vehicle->setId(Uuid::v4());
            $vehicle->setLabel($this->generateLabel($existingLabels));
            $vehicle->setBrand($brands[array_rand($brands)]);
            $vehicle->setSeatsAmount($seatsOptions[array_rand($seatsOptions)]);
            $vehicle->setColor($colors[array_rand($colors)]);
            
            $typeReference = $types[array_rand($types)];
            $type = $this->getReference($typeReference, Type::class);

            $vehicle->setType($type);

            if ($typeReference === TypeFixtures::UTILITY_REFERENCE) {
                $vehicle->setGVWR($gvwrValues[array_rand($gvwrValues)]);
            }

            $manager->persist($vehicle);
        }

        $manager->flush();
    }
    
    /**
     * Generates a random unique label with letters and digits
     * (e.g. "AX305", "H48X0" etc).
     */
    private function generateLabel(array &$existingLabels): string
    {
        do {
            $letters = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 2);
            $digits = str_pad((string)rand(0, 999), 3, '0', STR_PAD_LEFT);
    
            $parts = str_split($letters . $digits);

            shuffle($parts);

            $label = implode('', $parts);
        } while (in_array($label, $existingLabels));
    
        $existingLabels[] = $label;
    
        return $label;
    }
}