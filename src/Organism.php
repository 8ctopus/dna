<?php

declare(strict_types=1);

namespace Oct8pus\DNA;

use Exception;
use Stringable;

class Organism implements Stringable
{
    private string $name;
    private int $age;
    private float $energy;
    private DeoxyriboNucleicAcid $dna;

    /**
     * @var array <string, int>
     */
    private array $proteins;

    public function __construct(string $name, float $energy, int $length)
    {
        $this->name = $name;
        $this->age = 0;
        $this->energy = $energy;
        $this->dna = new DeoxyriboNucleicAcid($length);

        $this->proteins = [];
    }

    public function turn() : self
    {
        if ($this->dna->length() === 0) {
            throw new Exception("{$this->name} died of lack of dna at age {$this->age}");
        }

        $this->energy -= $this->dna->length() / 10;

        if ($this->energy < 0) {
            throw new Exception("{$this->name} died of starvation at age {$this->age}");
        }

        $this->dna->mutate(MutationType::random());

        foreach (Protein::cases() as $protein) {
            if ($this->dna->searchPattern($protein->value)) {
                if (array_key_exists($protein->name, $this->proteins)) {
                    $this->proteins[$protein->name] += 1;
                } else {
                    $this->proteins[$protein->name] = 1;
                }
            }
        }

        foreach ($this->proteins as $name => $count) {
            $protein = Protein::fromName($name);

            switch ($protein) {
                case Protein::EnergyFromLight:
                    $this->energy += $count * 10;
                    break;

                case Protein::EnergyFromHeat:
                    $this->energy += $count * 10;
                    break;

                case Protein::EnergyFromHunting:
                    $this->energy += $count * 10;
                    break;
            }
        }

        $this->age += 1;

        return $this;
    }

    public function __toString() : string
    {
        return "energy {$this->energy}\ndna [{$this->dna->length()}] {$this->dna}\nage {$this->age}\n";
    }
}
