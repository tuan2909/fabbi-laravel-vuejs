<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypePatient extends Model
{
    use HasFactory;

    /**
     * Name table
     *
     * @var string
     */
    protected $table = 'type_patients';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'name', 'created_at', 'updated_at'];

}
