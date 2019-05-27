<?php
include __DIR__ . '/job-similarities.php';

$ff = new FaceFinder();
$ff->flush();

# add and search first face
$faces = $ff->resolve(new Face(1, 200, 500));
assert(count($faces) === 1 && $faces[0]->getId() === 1);
//var_dump('1', $faces);
# add +1 face
$faces = $ff->resolve(new Face(55, 100, 999));
assert(count($faces) === 2 && $faces[0]->getId() === 2);
//var_dump('2', $faces);
# only search, not adding (because id != 0)
$faces = $ff->resolve(new Face(55, 100, 999, 2));
assert(count($faces) === 2 && $faces[0]->getId() === 2);
//var_dump('3', $faces);exit;

# add 1000 random faces
for ($a = 0; $a < 1000; $a++) {
    $ff->resolve(new Face(rand(0, 100), rand(0, 1000), rand(0, 1000)));
}

# let's recreate instance
unset($ff);
$ff = new FaceFinder();

# find known similar face and check first 3 records to match
$faces = $ff->resolve(new Face(54, 101, 998, 1));
//var_dump('4', $faces);
assert(
    count($faces) === 5
    && ($faces[0]->getId() === 2 || $faces[1]->getId() === 2 || $faces[3]->getId() === 2)
);

$ff->flush();