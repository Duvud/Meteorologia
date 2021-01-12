<?php

namespace App\Console;

use App\Http\Controllers\BalizaController;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $nombres = ["Higer","Oiartzun","Jaizubia","Santa%20Clara","Txomin%20Enea","Martutene","Miramon","Lasarte","Andoain","Ereñozu","Puerto%20de%20Pasaia","Aitzu"];
            for ($i =0; $i<count($nombres);$i++){
                $url = "https://www.euskalmet.euskadi.eus/s07-5853x/es/meteorologia/datos/graficasMeteogene.apl?e=5&nombre=Higer&fechasel=08/01/2021&R01HNoPortal=true";
                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
                $resp = curl_exec($curl);
                if (preg_match('/arrayDatos=([^;]+)/',$resp,$matches)) {
                    BalizaController::procesarDatos($matches[1]);
                    return "actualizado";
                }
                else {
                    return "no match";
                }
            }

        })->everyTenMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
