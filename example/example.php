<?php

include __DIR__.'/../vendor/autoload.php';

use NilPortugues\Example\Repository\ColorRepository;
use NilPortugues\Example\Repository\Color;
use NilPortugues\Foundation\Domain\Model\Repository\Filter;

$colors = [
    new Color('red', 1),
    new Color('green', 2),
    new Color('yellow', 3),
    new Color('blue', 4),
    new Color('cyan', 5),
    new Color('pink', 6),
    new Color('purple', 7),
    new Color('orange', 8),
    new Color('white', 9),
    new Color('black', 10),
];

$repository = new ColorRepository($colors);

echo '<h2>Print all colors</h2>';
echo '<pre>';
print_r($repository->findAll()->getContent());
echo '</pre>';



echo '<h2>Print all names containing R</h2>';
$filter = new Filter();
$filter->must()->contains('name', 'R');

$colorsContaining = $repository->findBy($filter);
echo '<pre>';
print_r($colorsContaining);
echo '</pre>';



echo '<h2>Print all colours with id between 2 and 6</h2>';
$filter = new Filter();
$filter->must()->ranges('hexCode', 2, 6);

$idRanges = $repository->findBy($filter);
echo '<pre>';
print_r($idRanges);
echo '</pre>';
