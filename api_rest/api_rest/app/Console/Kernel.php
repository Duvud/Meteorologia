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
    //Para iniciar esto en development, hay que ejecutar el comando php artisan schedule:work
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function(){
            //Llamamos a la función que se encarga de organizar y actualizar los datos
            //de la base de datos
            BalizaController::obtenerDatos();
        })->everyThreeMinutes();
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
