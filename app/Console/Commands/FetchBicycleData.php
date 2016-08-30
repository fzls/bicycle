<?php

namespace App\Console\Commands;

use App\Models\BicycleDataWechat;
use App\Models\BicycleDatum;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class FetchBicycleData extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:bicycle_data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '从杭州公共自行车接口获取自行车租还信息';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        /*run it every $T secs*/
        $T = 30;/*seconds*/
        while (true) {
            /*time when loop start*/
            $loop_start = Carbon::now();
            \Log::info('Start a new loop');

            $client = new Client();

            $start = Carbon::now();
            /*Android*/
            foreach (\Config::get('data.id_android') as $name => $id) {
                try {
                    $res  = $client->get("http://bike.hz.dingdatech.com/service/bicycle/stations/$id");
                    $json = \GuzzleHttp\json_decode($res->getBody(), true);
                    if ($json['meta']['code'] === 200) {
                        BicycleDatum::create($json['data']['station']);
                        \Log::info(sprintf('Insert record for station: %s', $name));
                    } else {
                        \Log::notice(sprintf("Error when insert record for station %s failed with code:%d, message:%s", $name, $json['meta']['code'], $json['meta']['message']));
                    }
                } catch (\Exception $e) {
                    \Log::error(sprintf("Failed to fetch station $name with exception %s", $e->getMessage()));
                }
            }
            \Log::info(sprintf("Get from Android api with %d seconds", Carbon::now()->diffInSeconds($start)));
            /*Wechat*/
            /*TODO: 这个接口目前由于微信端系统升级，暂不可用*/
//        $start = Carbon::now();
//        try {
//            $res  = $client->get('http://c.ggzxc.com.cn/wz/np_getBikesByWeiXin.do?lng=120.107&lat=30.295301&len=800&_=1472267874845');
//            $json = \GuzzleHttp\json_decode($res->getBody(), true);
//            if ($res->getStatusCode() === 200) {
//                foreach ($json['data'] as $record) {
//                    BicycleDataWechat::create($record);
//                    \Log::info(sprintf('insert record for station: %s<br>', $record['name']));
//                }
//            } else {
//                \Log::notice(sprintf("error when insert record for station %s failed with code:%d, message:%s", $json['data']['station']['name'], $json['meta']['code'], $json['meta']['message']));
//            }
//        } catch (\Exception $e) {
//            \Log::error(sprintf("failed to fetch station $id with exception %s"), $e->getMessage());
//        }
//        \Log::info(sprintf("Get from Wechat api with %s",Carbon::now()->diffForHumans($start)));

            /*time when loop end*/
            $loop_end = Carbon::now();
            /*calculate time to sleep*/
            $duration = $loop_end->diffInSeconds($loop_start);
            $time_to_sleep = $T-$duration;
            /*sleep for some tiem to make it T per loop*/
            \Log::info(sprintf("Sleep for %d seconds",$time_to_sleep));
            sleep($time_to_sleep);
        }
    }
}
