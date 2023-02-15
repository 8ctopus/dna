<?php

use Oct8pus\DNA\DeoxyriboNucleicAcid;
use Oct8pus\DNA\MutationType;
use Oct8pus\DNA\NucleoBase;

require_once './vendor/autoload.php';

// command line error handler
(new \NunoMaduro\Collision\Provider())->register();

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
