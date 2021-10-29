<?php

namespace App\Exports;

use App\Models\Type;
// use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Models\Description;

class ExcelDescriptionExports implements FromQuery
{
    // /**
    // * @return \Illuminate\Support\Collection
    // */
    // public function collection()
    // {
    //     return Type::all();
    // }

    use Exportable;
    protected $descriptions;

    public function __construct($descriptions)
    {
        $this->descriptions = $descriptions;
    }

    public function query()
    {
        return Description::query()->whereKey($this->descriptions);
    }
}
