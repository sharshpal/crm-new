<?php

namespace App\Http\Exports;

use App\Models\DatiContratto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;

class StatusStatExport implements FromCollection, WithMapping, WithHeadings, WithEvents {

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
            if($colName == "user")  $headings[] = trans("admin.vicidial-agent-log.columns.$colName");
            else if($colName == "userinfo")  $headings[] = trans("admin.vicidial-agent-log.columns.$colName");
            else if($colName == "calls")  $headings[] = trans("admin.vicidial-agent-log.columns.$colName");
            else $headings[] = $colName;
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
            if($colName == "user" && $row->user ) $value = $row->user;
            else if($colName == "userinfo" && $row->userinfo ) $value = $row->userinfo["full_name"];
            else if($colName == "calls" && $row->calls ) $value = $row->calls;
            else $value = $row->statuses[$colName];
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
