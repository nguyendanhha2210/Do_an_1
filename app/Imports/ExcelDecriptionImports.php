<?php

namespace App\Imports;

use App\Models\Description;
use Maatwebsite\Excel\Concerns\ToModel;

class ExcelDecriptionImports implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Description ([
            'description' => $row[1],
        ]);
    }
}
