<?php

namespace App\Http\Controllers;

use App\Models\BicycleDataWechat;
use App\Models\BicycleDatum;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redis;
use JavaScript;

class BicycleController extends Controller {
    public function showDashboard() {
        /*Get data from db, with some filter*/
        $start = Input::get('start')?:Carbon::now()->startOfDay();
        $end   = Input::get('end');
        $name  = Input::get('name')?:'中天西城纪';

        $records = BicycleDatum::where('name', $name);
        if (!(is_null($start) || $start === '')) {
            $records = $records->where('created_at', '>=', (new Carbon($start))->toDateTimeString());
        }

        if (!(is_null($end) || $end === '')) {
            $records = $records->where('created_at', '<=', (new Carbon($end))->toDateTimeString());
        }

        $records = $records->get();
        $data    = [];
        foreach ($records as $record) {
            $data[] = [
                'remaining_bicycles' => $record->enHireNum,
                'rented_bicycles'    => $record->disHireNum,
                'time'               => $record->created_at->timestamp,
            ];
        }

        $station_names = array_keys(\Config::get('data.id_android'));

        /*make a json response for client render*/

        Javascript::put([
                            'records'       => $data,
                            'station_names' => $station_names,
                            'name'          => $name,
                        ]);

        return view('dashboard', [
            'data'          => $data,
            'station_names' => $station_names,
            'name'          => $name,
        ]);
    }
}
