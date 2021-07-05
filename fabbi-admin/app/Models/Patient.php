<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    /**
     * Name table
     *
     * @var string
     */
    protected $table = 'patients';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id',
        'type_patient',
        'city_id',
        'full_name',
        'citizen_identify',
        'gender', 'nation',
        'year_birth',
        'address',
        'number',
        'email',
        'address_start',
        'address_end',
        'created_at',
        'updated_at'
    ];

    /**
     * One city belong to one patient
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cities()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    /**
     * One patient  belong to one type
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function typePatients()
    {
        return $this->belongsTo(TypePatient::class, 'type_id', 'id');
    }

    public function health()
    {
        return $this->hasOne(HealthPatient::class, 'patient_id', 'id');
    }
}
