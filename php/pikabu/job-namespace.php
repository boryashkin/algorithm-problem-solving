<?php

namespace Pikabu32\Internal;

class JobSeeker  extends \SplFixedArray
{

}

var_dump(
    strpos(JobSeeker::class, "Pikabu32\\") === 0
    && array_slice(explode("\\", get_class(new JobSeeker)), 1, 1) === ["Internal"]
    && substr_count(JobSeeker::class, "\\") === 2
);