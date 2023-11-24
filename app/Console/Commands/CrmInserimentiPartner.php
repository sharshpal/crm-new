<?php

namespace App\Console\Commands;

use App\Console\CrmCommand;
use App\Models\DatiContratto;
use App\Models\UserPerformance;
use App\Models\UserTimelog;
use App\Notifications\InserimentiPartnerNotification;
use App\Notifications\ReseOperatoreNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class CrmInserimentiPartner extends CrmCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = "crm:inserimenti-partner";

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature =  "crm:inserimenti-partner";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Invia mail con numero di pezzi del giorno, suddiviso per partner';

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

        $rows = DatiContratto::partnersInsert($request)->get()->all();

        $title = "Inserimenti Partner del {$today->isoFormat("DD/MM/YYYY")}";
        $when = now()->addSeconds(5);

        $addresses = explode(";",Config::get("mail.notification.to"));

        $result = \Illuminate\Support\Facades\Notification::route('mail',  $addresses)
            ->notify(new InserimentiPartnerNotification($title,$rows,$when));

        if($result){
            print_r($result);
        }
        else{
            print_r("Report Inserimenti Partner Inviato\r\n");
        }

    }
}
