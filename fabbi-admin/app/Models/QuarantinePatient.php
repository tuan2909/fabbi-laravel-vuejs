<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuarantinePatient extends Model
{
    use HasFactory;

    /**
     * Name table
     *
     * @var string
     */
    protected $table = 'quarantine_patients';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['patient_id', 'time_start', 'time_end', 'total', 'status', 'created_at', 'updated_at'];

    /**
     * One quarantine belong to one patient
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patients()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }

    public function specimens()
    {
        return $this->hasMany(Specimen::class, 'id', 'id');
    }
}
