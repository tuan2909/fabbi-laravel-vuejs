<?php

namespace App\Repositories\Eloquent;


use App\Repositories\Contracts\UserRepository;


/**
 * Class EloquentUserRepository
 *
 * @package App\Repositories\Eloquent
 */
class EloquentUserRepository extends EloquentBaseRepository implements UserRepository
{
    public function getUser($id)
    {
        // get user by id
        $query = $this->model->where('id', $id);
        $result = $query->first();
        return $result;
    }
}
