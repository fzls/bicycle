<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BicycleDataWechat
 */
class BicycleDataWechat extends Model
{
    protected $table = 'bicycle_data_wechat';

    protected $primaryKey = 'record_id';

	public $timestamps = true;

    protected $fillable = [
        'name',
        'rentcount',
        'restorecount',
    ];

    protected $guarded = [];

        
}