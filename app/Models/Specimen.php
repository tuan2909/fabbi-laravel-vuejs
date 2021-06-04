<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specimen extends Model
{
    use HasFactory;

    /**
     * Name table
     *
     * @var string
     */
    protected $table = 'specimens';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'patient_id',
        'date_infection',
        'date_draw_blood',
        'date_test',
        'result_test',
        'address',
        'created_at',
        'updated_at'];

    /**
     * One specimen belong to one patient
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patients()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }
}
