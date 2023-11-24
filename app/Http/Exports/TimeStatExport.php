<?php

namespace App\Http\Exports;

use App\Models\DatiContratto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;

class TimeStatExport implements FromCollection, WithMapping, WithHeadings, WithEvents {

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
            if( $this->endsWith($colName,"_perc") ) $headings[] = trans("admin.vicidial-agent-log.columns.$colName") . " %";
            else $headings[] = trans("admin.vicidial-agent-log.columns.$colName");
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
            $value = $row->{$colName};
            if($colName == "user" && $row->user()->first()) $value = $row->user()->first()->user;
            else if($colName == "full_name" && $row->user()->first()) $value = $row->user()->first()->full_name;
            else if( $this->endsWith($colName,"_perc") )  $value = $row->{$colName} . " %" ;
            $map[] = $value . "";
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

    private function endsWith( $haystack, $needle ) {
        $length = strlen( $needle );
        if( !$length ) {
            return true;
        }
        return substr( $haystack, -$length ) === $needle;
    }

}
