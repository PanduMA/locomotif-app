<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Log;

class Locomotif extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:locomotif';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create data locomotif';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info("=== START SCHEDULER DATA DUMMY ===");
        $code = $this->getRandomCode();
        $data = array(
            'code'      => $code,
            'name'      => 'Lokomotif '.$code,
            'dimension' => $this->getRandomDimension(),
            'status'    => $this->getRandomStatus(),
            'date'      => date('Y-m-d H:i:s'),
        );
        Log::info(json_encode($data));

        $response = Http::post('http://localhost:8080/api/send', $data);
        Log::info($response);
        Log::info("=== END SCHEDULER DATA DUMMY ===");
    }

    public function getRandomCode()
    {
        $randCode  = (string)mt_rand(1000,9999);
        $randChar  = rand(65,90);
        $randInx   = rand(0,3);
        $randCode[$randInx] = chr($randChar);

        return $randCode;
    }

    public function getRandomStatus()
    {
        $arrStatus = array(0, 1);
        $randomKey = array_rand($arrStatus, 1);

        return $arrStatus[$randomKey];
    }

    public function getRandomDimension()
    {
        $arrDimension = array('20x3', '21x3', '22x3', '23x4', '24x4');
        $randomKey = array_rand($arrDimension, 1);

        return $arrDimension[$randomKey];
    }
}
