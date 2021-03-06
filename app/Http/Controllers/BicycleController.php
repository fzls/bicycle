<?php

namespace App\Http\Controllers;

use App\Models\BicycleDataWechat;
use App\Models\BicycleDatum;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
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
        $start = Input::get('start')?:Carbon::now()->subHours(2);
        $end   = Input::get('end');
        $name  = Input::get('name')?:'石板巷新村';
        if(Input::get('time_span')){
            list($t, $unit) = explode(" ",Input::get('time_span'));
            $subTime = "sub$unit";
            $start = Carbon::now()->$subTime($t);
        }

        $records = BicycleDataWechat::select(["rentcount","restorecount","created_at"])->where('name', $name);
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
//                车站剩余自行车数
                'remaining_bicycles' => (int)$record->rentcount,
//              车站空位数
                'rented_bicycles'    => (int)$record->restorecount,
                'time'               => $record->created_at->timestamp,
            ];
        }

        $station_names = \Cache::remember('station_names_wechat', 60*24, function (){
            return BicycleDataWechat::select(['name'])->distinct()->get();
        });

//        $station_names = array_keys(\Config::get('data.id_android'));

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
