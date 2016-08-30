<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BicycleDatum
 */
class BicycleDatum extends Model
{
    protected $table = 'bicycle_data';

    protected $primaryKey = 'record_id';

	public $timestamps = true;

    protected $fillable = [
        'id',
        'name',
        'longitude',
        'latitude',
        'enHireNum',
        'disHireNum',
        'isSelected',
        'type'
    ];

    protected $guarded = [];

        
}