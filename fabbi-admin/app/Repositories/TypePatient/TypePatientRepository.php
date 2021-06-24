<?php

namespace App\Repositories\TypePatient;

use App\Repositories\BaseRepository;

/**
 * TypePatientRepository Interface BaseRepository
 *
 * @package App\Repositories
 */
interface TypePatientRepository extends BaseRepository
{
    public function getDataTypePatient($keyWord);

}
