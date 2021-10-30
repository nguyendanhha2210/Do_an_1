<?php

namespace App\Imports;

use App\Models\WareHouse;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Product;

class ExcelWarehouseImports implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new WareHouse([
            'name' => $row[1],
            'import_price' => $row[2],
            'import_quantity' => $row[3],
            'inventory' => $row[3],
            'status' => '3',
            'import_date' => Carbon::now(),
        ]);
    }
}
