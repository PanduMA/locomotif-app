<?php

namespace App\Console\Commands;

use Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Console\Command;
use App\Models\Mongo\Locomotif;
use App\Models\Summary as SummaryModel;
use App\Notifications\SummaryTelegram;

date_default_timezone_set('Asia/Jakarta');
class Summary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:summary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get data summary locomotif';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info("=== START SCHEDULER SUMMARY REPORT ===");
        $data = Locomotif::raw( function ( $collection ) {
            return $collection->aggregate([
                [
                    '$match' => [
                        'date' => ['$gte' => date('Y-m-d', strtotime('-1 days')), '$lt' => date('Y-m-d', strtotime('+1 days'))]
                    ]
                ],
                [
                    '$group' => [
                        '_id' => array(
                            'status' => '$status',
                            'date' => [ '$dateToString' => ['format' => '%Y-%m-%d %H:00:00', 'date' => [ '$toDate' => '$date']]]
                        ),
                        'total' => ['$sum' => 1],
                    ]
                ],
            ]);
        });

        foreach ($data as $key => $item) {
            $dataInsert = array(
                'status'    => $item->_id->status,
                'tanggal'   => $item->_id->date,
                'total'     => $item->total
            );
            try {
                $dataChecked = $dataInsert;
                unset($dataChecked['total']);
                if(SummaryModel::updateOrInsert($dataChecked, $dataInsert)){
                    Log::info("Success insert data to mysql ".json_encode($dataInsert));
                }else {
                    Log::error("Failed insert data to mysql");
                }
            } catch (\Exception $error) {
                Log::error("Failed insert data to mysql ".$error->getMessage());
            }
        }


        $dataSummary = SummaryModel::whereDate('tanggal', date('Y-m-d'))->whereTime('tanggal', '=', date('H').':00:00')->select('status', 'total')->get();
        if ($dataSummary->count() > 0) {
            $data = array(
                'telegram_user_id'  => env('TELEGRAM_USER_ID'),
                'tanggal'           => date('Y-m-d H').':00:00',
                'total'             => $dataSummary->sum('total'),
                'total_active'      => $dataSummary->where('status', true)->first()->total,
                'total_nonactive'   => $dataSummary->where('status', false)->first()->total
            );
            Notification::route('telegram', env('TELEGRAM_USER_ID'))->notify(new SummaryTelegram($data));
        }

        Log::info("=== END SCHEDULER SUMMARY REPORT ===");
    }
}
