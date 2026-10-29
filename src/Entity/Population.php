<?php

namespace App\Entity;

use App\Repository\PopulationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PopulationRepository::class)]
class Population
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $habitant = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHabitant(): ?int
    {
        return $this->habitant;
    }

    public function setHabitant(int $habitant): static
    {
        $this->habitant = $habitant;

        return $this;
    }
}
