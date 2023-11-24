<?php

namespace App\Http\Exports;

use App\Models\DatiContratto;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CheckFatturazioneExport implements FromArray, WithMapping, WithHeadings {

    private $exportColumns = [];
    private $data = [];

    public function __construct($data,$exportColumns) {
        $this->data = $data;
        $this->exportColumns = $exportColumns;
    }

    /**
     * @return array
     */
    public function array():array {
        return $this->data;
    }

    /**
     * @return array
     */

    public function headings(): array {

        $headings = [];
        foreach($this->exportColumns as $colName){
            $headings[] = trans("admin.verify_export.$colName");
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
            $value = $row[$colName];
            if($colName == "ids") $value = join(",",$row[$colName]);
            $map[] = $value;
        }

        return $map;
    }


}
?>
