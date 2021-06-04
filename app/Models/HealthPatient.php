<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthPatient extends Model
{
    use HasFactory;

    /**
     * Name table
     *
     * @var string
     */
    protected $table = 'health_patients';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'patient_id',
        'fever',
        'cough',
        'difficulty_breathing',
        'sore_throat', '
        vomiting',
        'diarrhea',
        'skin_haemorrhage',
        'rash',
        'other',
        'created_at',
        'updated_at'
    ];

    /**
     * One health belong to one patient.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patients()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }
}
