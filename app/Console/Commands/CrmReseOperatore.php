<?php

namespace App\Console\Commands;

use App\Console\CrmCommand;
use App\Models\UserPerformance;
use App\Models\UserTimelog;
use App\Notifications\ReseOperatoreNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class CrmReseOperatore extends CrmCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = "crm:rese-operatore";

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature =  "crm:rese-operatore";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Invia mail con le rese operatore del giorno';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws Exception
     */
    public function handle(): void
    {

        $today = Carbon::now();

        $request = new Request();
        $request->merge(['fromDate' => $today->toDateString(),"toDate" => $today->toDateString()]);

        $rows = UserPerformance::usersPerformanceStatistics($request)->get()->all();

        $title = "Rese Operatore del {$today->isoFormat("DD/MM/YYYY")}";
        $when = now()->addSeconds(5);

        $addresses = explode(";",Config::get("mail.notification.to"));

        $result = \Illuminate\Support\Facades\Notification::route('mail',  $addresses)
            ->notify(new ReseOperatoreNotification($title,$rows,$when));

        if($result){
            print_r($result);
        }
        else{
            print_r("Report Send\r\n");
        }

    }
}
