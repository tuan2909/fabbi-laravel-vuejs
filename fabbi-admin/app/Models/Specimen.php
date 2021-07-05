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
        'quarantine_id',
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
    public function quarantine()
    {
        return $this->belongsTo(QuarantinePatient::class, 'quarantine_id', 'id');
    }
}
