<?php

namespace App\Infrastructure;

use Illuminate\Database\Eloquent\Builder;

abstract class Criteria
{
    public abstract function apply($builder, Repository $repository) : Builder;
}
