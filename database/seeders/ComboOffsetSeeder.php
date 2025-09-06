<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ComboOffset;

class ComboOffsetSeeder extends Seeder
{
    public function run(): void
    {
        $base   = 'D01';   // tổ hợp gốc
        $method = null;    // áp dụng chung (nếu muốn PT1/PT2, đổi thành 'PT1' hoặc 'PT2')

        // Độ chênh theo bảng so với D01
        $rows = [
            ['combo_code' => 'A00', 'delta' =>  0.17],
            ['combo_code' => 'A01', 'delta' =>  0.00],
            ['combo_code' => 'C00', 'delta' =>  0.75],
            ['combo_code' => 'C01', 'delta' =>  0.40],
            ['combo_code' => 'C02', 'delta' =>  0.17],
            ['combo_code' => 'C03', 'delta' =>  0.29],
            ['combo_code' => 'C04', 'delta' =>  0.31],
            ['combo_code' => 'D09', 'delta' => -0.12],
            ['combo_code' => 'D10', 'delta' => -0.09],
            ['combo_code' => 'D14', 'delta' =>  0.44],
            ['combo_code' => 'D15', 'delta' =>  0.46],
            ['combo_code' => 'X02', 'delta' =>  0.35], // nếu không dùng X02 thì xoá dòng này
        ];

        $order = 1;
        foreach ($rows as $r) {
            ComboOffset::updateOrCreate(
                ['combo_code' => $r['combo_code'], 'base_code' => $base, 'method' => $method],
                ['delta' => $r['delta'], 'order_no' => $order++, 'active' => true]
            );
        }

    }
}
