<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\Vehicle;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class VehicleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vehicle::class);
    }

    public function findWithFilters(
        array $filters, 
        int $page = 1, 
        int $limit = 20
    ): Paginator
    {
        $query = $this->createQueryBuilder('v');

        if (!empty($filters['brand'])) {
            $query
                ->andWhere('v.brand = :brand')
                ->setParameter('brand', $filters['brand']);
        }

        if (!empty($filters['type'])) {
            $query
                ->leftJoin('v.type', 't')
                ->andWhere('t.id = :type')
                ->setParameter('type', $filters['type']);
        }

        if (!empty($filters['seats_amount'])) {
            $query
                ->andWhere('v.seatsAmount = :seats_amount')
                ->setParameter('seats_amount', (int) $filters['seats_amount']);
        }

        $query->orderBy('v.label', 'ASC');

        $query
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);

        return new Paginator($query->getQuery());
    }
}
