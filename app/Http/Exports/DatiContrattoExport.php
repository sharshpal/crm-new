<?php

namespace App\Http\Exports;

use App\Models\DatiContratto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;

class DatiContrattoExport implements FromCollection, WithMapping, WithHeadings, WithEvents {

    private $exportColumns = [];
    private $data = null;

    public function __construct($data,$exportColumns) {
        $this->data = $data;
        $this->exportColumns = $exportColumns;
    }

    /**
     * @return Collection
     */
    public function collection() {
        return $this->data;
    }

    /**
     * @return array
     */

    public function headings(): array {

        $headings = [];
        foreach($this->exportColumns as $colName){
            $headings[] = trans("admin.dati-contratto.export-columns.$colName");
        }

        return $headings;
    }


    /**
     * @param DatiContratto $datiContratto
     * @return array
     */

    public function map($datiContratto): array {

        $datiContratto = $this->cleatDatiContratto($datiContratto);


        $map = [];
        foreach($this->exportColumns as $colName){
            $value = $datiContratto->{$colName};
            if($colName == "esito" && !empty($datiContratto->esito) && !empty($datiContratto->esito()->first())) $value = $datiContratto->esito()->first()->nome;
            if($colName == "campagna" && !empty($datiContratto->campagna) && !empty($datiContratto->campagna()->first())) $value = $datiContratto->campagna()->first()->nome;
            if($colName == "partner" && !empty($datiContratto->partner) && !empty($datiContratto->partner()->first())) $value = $datiContratto->partner()->first()->nome;
            if($colName == "crm_user" && !empty($datiContratto->crm_user) && !empty($datiContratto->crm_user()->withTrashed()) && !empty($datiContratto->crm_user()->withTrashed()->first())) $value = $datiContratto->crm_user()->withTrashed()->first()->full_name;
            if($colName == "update_user" && !empty($datiContratto->update_user) && !empty($datiContratto->update_user()->withTrashed()) && !empty($datiContratto->update_user()->withTrashed()->first())) $value = $datiContratto->update_user()->withTrashed()->first()->full_name;
            if($colName == "created_at" && !empty($datiContratto->created_at)) $value = (explode(" ",$datiContratto->created_at))[0];
            if($colName == "updated_at" && !empty($datiContratto->updated_at)) $value = (explode(" ",$datiContratto->updated_at))[0];
            if($colName == "deleted_at" && !empty($datiContratto->deleted_at)) $value = (explode(" ",$datiContratto->deleted_at))[0];
            if($colName == "recover_at" && !empty($datiContratto->recover_at)) $value = (explode(" ",$datiContratto->recover_at))[0];
            $map[] = $value;
        }

        return $map;
    }


    private function cleatDatiContratto($datiContratto){

        if($datiContratto->tipo_offerta=="luce"){
            $datiContratto->gas_pdr = null;
        }
        else if($datiContratto->tipo_offerta=="gas"){
            $datiContratto->luce_pod = null;
        }
        else if($datiContratto->tipo_offerta=="telefonia"){
            $datiContratto->gas_pdr = null;
            $datiContratto->luce_pod = null;
        }

        return $datiContratto;
    }



    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $highestColumn = $event->sheet->getHighestColumn();
                $event->sheet->getStyle("A1:{$highestColumn}1")->applyFromArray([
                    'font' => [
                        'bold' => true
                    ]
                ]);
            },
        ];
    }


}
