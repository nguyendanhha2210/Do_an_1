<?php

namespace App\Imports;

use App\Models\Type;
use Maatwebsite\Excel\Concerns\ToModel;

class ExcelImports implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Type([
            'type' => $row[1],
        ]);
    }
}
