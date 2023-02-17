<?php

//use Oct8pus\DNA\DeoxyriboNucleicAcid;
//use Oct8pus\DNA\MutationType;
//use Oct8pus\DNA\NucleoBase;
use Oct8pus\DNA\Organism;

require_once './vendor/autoload.php';

// command line error handler
(new \NunoMaduro\Collision\Provider())->register();

$n = 200;

echo "Let's create {$n} organisms\n";

$organisms = [];

for ($i = 1; $i <= $n; ++$i) {
    $energy = rand(5000, 7000);
    $length = rand(50, 80);

    $organisms[] = new Organism("#{$i}", $energy, $length);
}

//echo $organism;

while (1) {
    foreach ($organisms as $index => $organism) {
        try {
            //echo "Wait one turn\n";
            $organism?->turn();

            //echo $organism;
        } catch (Exception $e) {
            echo $e->getMessage() . PHP_EOL;
            $organisms[$index] = null;
        }
    }

    // cleanup array
}

/*
echo "Let's create some DNA\n";

$dna = (new DeoxyriboNucleicAcid(6 * 6))
    ->add(NucleoBase::Adenine)
    ->add(NucleoBase::Adenine)
    ->add(NucleoBase::Adenine)
    ->add(NucleoBase::Adenine)
    ->add(NucleoBase::Adenine)
    ->add(NucleoBase::Adenine);

echo $dna . PHP_EOL;
$dna1 = (string) $dna;

$dna->mutate(MutationType::Substitution);

echo $dna . PHP_EOL;
$dna2 = (string) $dna;

$dna->mutate(MutationType::Insertion);

echo $dna . PHP_EOL;

$dna->mutate(MutationType::Deletion);

echo $dna . PHP_EOL;
*/

