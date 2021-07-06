<?php

namespace App\Repositories\Specimen;

use App\Repositories\BaseRepository;

/**
 * SpecimenRepository Interface BaseRepository
 *
 * @package App\Repositories
 */
interface SpecimenRepository extends BaseRepository
{

    public function getPatientSpecimen($data);

}
