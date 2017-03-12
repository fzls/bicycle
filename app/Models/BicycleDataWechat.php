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
        'address',
        'areaname',
        'bikenum',
        'guardType',
        'id',
        'lat',
        'len',
        'lon',
        'name',
        'number',
        'rentcount',
        'restorecount',
        'serviceType',
        'sort',
        'stationPhone',
        'stationPhone2',
        'useflag'
    ];

    protected $guarded = [];

        
}