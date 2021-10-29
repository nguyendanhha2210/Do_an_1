<?php

namespace App\Exports;

use App\Models\Type;
// use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class ExcelTypeExports implements FromQuery
{
    // /**
    // * @return \Illuminate\Support\Collection
    // */
    // public function collection()
    // {
    //     return Type::all();
    // }

    use Exportable;
    protected $types;

    public function __construct($types)
    {
        $this->types = $types;
    }

    public function query()
    {
        return Type::query()->whereKey($this->types);
    }
}
