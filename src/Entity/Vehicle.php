<?php declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use App\Repository\VehicleRepository;

use Symfony\Component\Uid\Uuid;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: VehicleRepository::class)]
class Vehicle
{
    #[ORM\Id]
    #[ORM\Column(
        type: 'uuid',
        unique: true
    )]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private Uuid $id;

    #[ORM\Column(length: 150, unique: true)]
    private string $label;

    #[ORM\Column(length: 150)]
    private string $brand;

    #[ORM\Column(type: 'integer')]
    private int $seatsAmount;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $color = null;

    #[ORM\ManyToOne(targetEntity: Type::class)]
    private Type $type;

    #[ORM\Column(
        type: 'float',
        nullable: true
    )]
    private ?float $gvwr = null;

    #[Assert\Callback]
    public function validateGVWR(ExecutionContextInterface $context): void
    {
        if (
            $this->type && 
            $this->type->requiresGVWR() && 
            $this->gvwr === null
        ) {
            $context
                ->buildViolation('The GVWR is required for utility vehicles.')
                ->atPath('gvwr')
                ->addViolation();
        }
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function getSeatsAmount(): int
    {
        return $this->seatsAmount;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function getType(): Type
    {
        return $this->type;
    }

    public function getGVWR(): ?float
    {
        return $this->gvwr;
    }

    public function setId(Uuid $id): void
    {
        $this->id = $id;
    }

    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    public function setBrand(string $brand): void
    {
        $this->brand = $brand;
    }

    public function setSeatsAmount(int $seatsAmount): void
    {
        $this->seatsAmount = $seatsAmount;
    }

    public function setColor(?string $color): void
    {
        $this->color = $color;
    }

    public function setType(Type $type): void
    {
        $this->type = $type;
    }

    public function setGVWR(?float $gvwr): void
    {
        $this->gvwr = $gvwr;
    }
}