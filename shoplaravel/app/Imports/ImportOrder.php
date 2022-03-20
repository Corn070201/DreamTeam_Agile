<?php

namespace App\Imports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportOrder implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Order([
            'customer_id' =>$row[0],
            'shipping_id' =>$row[1],
            'order_code' =>$row[2],
            'order_status' =>$row[3],
            'created_at' =>$row[4],
        ]);
    }
}
