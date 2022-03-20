<?php

namespace App\Imports;

use App\Models\Coupon;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportCoupon implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Coupon([
            'coupon_name'  =>$row[0],
            'coupon_times'  =>$row[1],
            'coupon_condition'  =>$row[2],
            'coupon_number'  =>$row[3],
            'coupon_code'  =>$row[4],
        ]);
    }
}
