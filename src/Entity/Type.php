<?php declare(strict_types=1);

namespace App\Entity;

use App\Repository\TypeRepository;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeRepository::class)]
class Type
{
    protected const UTILITY_TYPE = 1;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(
        length: 100,
        unique: true
    )]
    private string $label;

    public function getId(): int
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    public function requiresGVWR(): bool
    {
        return $this->id === self::UTILITY_TYPE;
    }
}