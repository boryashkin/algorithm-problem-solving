<?php
include __DIR__ . '/job-similarities.php';

$ff = new FaceFinder();
$ff->flush();

$tCreate = microtime(true);
# add 1000 random faces
for ($a = 0; $a < 1000; $a++) {
    $ff->resolve(new Face(rand(0, 100), rand(0, 1000), rand(0, 1000)));
}
$tCreate = microtime(true) - $tCreate;

# let's recreate instance
unset($ff);
$ff = new FaceFinder();

$tSearch = microtime(true);
# search for 1000 random faces
for ($a = 0; $a < 1000; $a++) {
    $ff->resolve(new Face(rand(0, 100), rand(0, 1000), rand(0, 1000), 1));
}
$tSearch = microtime(true) - $tSearch;

print_r(['creation x1000' => $tCreate, 'search x1000' => $tSearch]);

$ff->flush();