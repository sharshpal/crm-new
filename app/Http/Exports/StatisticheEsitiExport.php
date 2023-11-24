<?php

namespace App\Http\Exports;

use App\Models\DatiContratto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;

class StatisticheEsitiExport implements FromCollection, WithMapping, WithHeadings, WithEvents {

    private $exportColumns = [];
    private $groupByPartner = false;
    private $groupByCampagna = false;
    private $groupByUser = false;
    private $groupByLabel = false;
    private $totale = 0;
    private $totalePz = 0;
    private $data = null;

    public function __construct($data,$exportColumns, $totale, $totalePz, $groupByPartner,$groupByCampagna,$groupByUser,$groupByLabel) {
        $this->data = $data;
        $this->groupByPartner = $groupByPartner;
        $this->groupByCampagna = $groupByCampagna;
        $this->groupByUser = $groupByUser;
        $this->groupByLabel = $groupByLabel;
        $this->exportColumns = $exportColumns;
        $this->totale = $totale;
        $this->totalePz = $totalePz;
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
            $headings[] = trans("admin.statistiche-esiti.columns.$colName");
        }

        return $headings;
    }


    /**
     * @param DatiContratto $datiContratto
     * @return array
     */

    public function map($row): array {

        $map = [];

        foreach($this->exportColumns as $colName){
            $value = "";
            if($colName == "esito") $value = ($this->groupByLabel || empty($row->nome) ? "-" : $row->nome);
            else if($colName == "campagna") $value = (!$this->groupByCampagna || empty($row->campagna) ? "-" : $row->campagna);
            else if($colName == "partner") $value = (!$this->groupByPartner || empty($row->partner) ? "-" : $row->partner);
            else if($colName == "crm_user") $value = (!$this->groupByUser || empty($row->first_name) || empty($row->last_name) ? "-" : $row->first_name . " " . $row->last_name);
            else if($colName == "partial_total" ) $value = $row->partialCount;
            else if($colName == "partial_total_pz" ) $value = $row->partialCountPz;
            else if($colName == "totale_globale" ) $value = $this->totale;
            else if($colName == "totale_pezzi" ) $value = $this->totalePz;
            else if($colName == "stato"){
                $st = $row->is_final ? "CONCLUSO" : "APERTO";
                if($row->is_new){
                    $st .= " - NEW";
                }
                else if($row->is_ok){
                    $st .= " - POSITIVO";
                }
                else if(!$row->is_ok){
                    $st .= " - NEGATIVO";
                }
                else if($row->is_recover){
                    $st = "RECUPERO";
                }
                $value = $st;
            }
            else{
                $value = $row->{$colName};
            }

            $map[] = $value;
        }

        return $map;
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
