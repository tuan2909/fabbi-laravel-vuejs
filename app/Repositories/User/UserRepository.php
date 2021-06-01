<?php

namespace App\Repositories\User;

use App\Repositories\BaseRepository;

/**
 * UserRepository Interface BaseRepository
 *
 * @package App\Repositories
 */
interface UserRepository extends BaseRepository
{
    /**
     * Get user by Id
     *
     * @param $id
     * @return mixed
     */
    public function getUser($id);

}
