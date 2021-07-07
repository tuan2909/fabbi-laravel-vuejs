<?php

namespace App\Repositories\QuarantinePatient;

use App\Repositories\BaseRepository;

/**
 * QuarantinePatientRepository Interface BaseRepository
 *
 * @package App\Repositories
 */
interface QuarantinePatientRepository extends BaseRepository
{
    public function getDataQuarantines($data);

    public function getPatientsQuarantine();
}
