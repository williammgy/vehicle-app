<?php declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Type;

use Doctrine\Persistence\ObjectManager;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class TypeFixtures extends Fixture implements OrderedFixtureInterface
{
    public const UTILITY_REFERENCE = 'type-utility';
    public const SUV_REFERENCE = 'type-suv';
    public const CONVERTIBLE_REFERENCE = 'type-convertible';

    /**
     * {@inheritDoc}
     */
    public function getOrder(): int
    {
        return 2;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager): void
    {
        $types = [
            ['label' => 'Utility', 'reference' => self::UTILITY_REFERENCE],
            ['label' => 'SUV', 'reference' => self::SUV_REFERENCE],
            ['label' => 'Convertible', 'reference' => self::CONVERTIBLE_REFERENCE],
        ];

        foreach ($types as $data) {
            $type = new Type;
            $type->setLabel($data['label']);

            $manager->persist($type);

            $this->addReference($data['reference'], $type);
        }

        $manager->flush();
    }
}