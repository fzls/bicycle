<?php

namespace App\Console\Commands;

use App\Models\BicycleDatum;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class FetchBicycleDataAll extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:bicycle_data_all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'fetch 3020 bicycle stations data';

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
        $client = new Client();

//        $start = Carbon::now();
//        $chunk = [];
//        define('CHUNK_SIZE', 500);
//        \Log::notice("Start gathering data with chunk size " . CHUNK_SIZE);
//        /*Android*/
//        for ($i = 2; $i <= 3020; $i++) {
//            try {
//                $id   = sprintf("%05d", $i);
//                $res  = $client->get("http://bike.hz.dingdatech.com/service/bicycle/stations/20160802161027hzl$id");
//                $json = \GuzzleHttp\json_decode($res->getBody(), true);
//                if ($json['meta']['code'] === 200) {
//                    if ($json['data']['station']) {
//                        $chunk[] = array_merge($json['data']['station'], [
//                            'created_at' => Carbon::now()->toDateTimeString(),
//                            'updated_at' => Carbon::now()->toDateTimeString(),
//                        ]);
//                    }
//                    if (count($chunk) >= CHUNK_SIZE || $i === 3020) {
//                        \DB::table('bicycle_data')->insert($chunk);
//                        $chunk = [];
//                    }
//                    \Log::info(sprintf('Insert record for station: %s', $id));
//                } else {
//                    \Log::info(sprintf("Error when insert record for station %s failed with code:%d, message:%s", $id, $json['meta']['code'], $json['meta']['message']));
//                }
//            } catch (\Exception $e) {
//                \Log::error(sprintf("Failed to fetch station $id with exception %s", $e->getMessage()));
//            }
//        }
//        \Log::notice(sprintf("Get 3020 stations data from Android api with %d seconds", Carbon::now()->diffInSeconds($start)));

        /*Wechat*/
        $start = Carbon::now();
        $chunk = [];
        define('CHUNK_SIZE', 500);
        \Log::notice("Start gathering data with chunk size " . CHUNK_SIZE);
        $data     = file_get_contents(base_path('bicycle_stations_list_from_wechat_not_ascii.json'));
        $stations = json_decode($data, true);

        $base_url_wechat = 'http://c.ggzxc.com.cn/wz/np_getBikes.do';


        foreach ($stations as $station) {
            try {
                $res  = $client->get($base_url_wechat, [
                    'query' => [
                        'lng' => $station['result']['lon'],
                        'lat' => $station['result']['lat'],
                        'len' => '0',
                    ],
                ]);
                $json = \GuzzleHttp\json_decode($res->getBody(), true);
                if ($res->getStatusCode() === 200) {
                    if ($json['count']) {
                        $item    = $json['data'][0];
                        $chunk[] = [
                            'name' => $item['name'],
                            'rentcount' => $item['rentcount'],
                            'restorecount' => $item['restorecount'],
                            'created_at' => Carbon::now()->toDateTimeString(),
                            'updated_at' => Carbon::now()->toDateTimeString(),
                        ];

                        print("\r Current is : " . $json['data'][0]['number']);

                        if (count($chunk) >= CHUNK_SIZE) {
                            \DB::table('bicycle_data_wechat')->insert($chunk);
                            $chunk = [];
                        }
                    }
                } else {
                    \Log::notice(sprintf("error when insert record for station %s", $json['data'][0]['name']));
                }
            } catch (\Exception $e) {
                \Log::error(sprintf("failed to fetch station %s with exception %s", $station['title'], $e->getMessage()));
            }
        }

        if (count($chunk)) {
            \DB::table('bicycle_data_wechat')->insert($chunk);
        }

        \Log::notice(sprintf("Get %d stations data from Wechat api with %s seconds", count($stations), Carbon::now()->diffForHumans($start)));
    }
}
