<?php

namespace App\Console\Commands;

use App\Console\CrmCommand;
use App\Models\DatiContratto;
use Exception;

class CrmSplitDual extends CrmCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = "crm:split-dual";

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature =  "crm:split-dual";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Separa i contratti "luce-gas" in due contratti separati "luce"+"gas"';

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

        if(!env("SPLIT_DUAL_FROM_BATCH",false)){
            print_r("\nOpzione disabilitata! Impostare la variabile 'SPLIT_DUAL_FROM_BATCH' nel file .env\n");
            print_r("\nOperazione completata con successo\n");
            return;
        }


        $dual = DatiContratto::where("tipo_offerta","lucegas")->get();
        foreach($dual as $contratto){
            try{
                $attributes = $contratto->getAttributes();
                print_r("\n\n-------------\n");
                print_r("Splitting contract [ {$contratto->id} ]\n");
                $newContract = new DatiContratto($contratto->getAttributes());

                //sul contratto luce, cancello i dati "gas"
                $contratto->tipo_offerta = "luce";
                $contratto->gas_pdr = null;
                $contratto->gas_consumo = null;
                $contratto->gas_fornitore = null;
                $contratto->gas_matricola = null;
                $contratto->gas_remi = null;
                $contratto->gas_mercato = null;
                $contratto->gas_polizza = false;
                $contratto->gas_polizza_caldaia = false;
                $contratto->update();

                //sul contratto gas, cancello i dati "luce"
                $newContract->id = null;
                $newContract->tipo_offerta = "gas";
                $newContract->luce_pod = null;
                $newContract->luce_kw = null;
                $newContract->luce_tensione = null;
                $newContract->luce_consumo = null;
                $newContract->luce_fornitore = null;
                $newContract->luce_mercato = null;
                $newContract->luce_polizza = false;
                $newContract->save();

                if(env("SPLIT_DUAL_COPY_MEDIA",false)){
                    //Copia file media
                    foreach($contratto->media->all() as $media){
                        $newContract
                            ->addMediaFromDisk("/media/{$media->id}/{$media->file_name}","local")
                            ->withCustomProperties($media->custom_properties)
                            ->preservingOriginal()
                            ->toMediaCollection($media->collection_name);
                    }
                }

                print_r("Splitting complete [ {$contratto->id} ]\n");
                print_r("\nC1: {$contratto->id}");
                print_r("\nC2: {$newContract->id}");
                print_r("\n-------------\n\n");
            }
            catch(Exception $exception){
                print_r("\n ERRORE:\n");
                print_r($exception->getMessage());
                print_r($exception->getTrace());
                print_r("\n-------------\n\n");
                return;
            }
        }

        print_r("\nOperazione completata con successo\n");
    }
}
