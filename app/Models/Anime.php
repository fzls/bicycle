<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Anime
 */
class Anime extends Model
{
    protected $table = 'anime';

    public $timestamps = false;

    protected $fillable = [
        'download_times',
        'url',
        'file_name',
        'file_size',
        'download_link',
        'url_1',
        'url_2',
        'url_3',
        'upload_time'
    ];

    protected $guarded = [];

        
}