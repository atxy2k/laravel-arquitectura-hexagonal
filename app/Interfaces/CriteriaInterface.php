<?php

namespace App\Interfaces;

use App\Infrastructure\Criteria;
use App\Interfaces\RepositoryInterface;

interface CriteriaInterface
{
    /**
     * Add a Criteria object to criteria to going to apply later.
     * @param Criteria $criteria
     * @return RepositoryInterface
     */
    public function pushCriteria(Criteria $criteria) : RepositoryInterface;
    /**
     * Add a Criteria object to criteria to going to apply later.
     * @param Criteria $criteria
     * @return RepositoryInterface
     */
    public function addCriteria(Criteria $criteria) : RepositoryInterface;

    /**
     * Return all criteria added
     * @return array
     */
    public function getCriteria() : array;

    /**
     * Clean all criteria
     * @return RepositoryInterface
     */
    public function cleanCriteria() : RepositoryInterface;
}
