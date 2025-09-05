<?php

namespace Database\Seeders;

use App\Models\Major;
use Illuminate\Database\Seeder;

class MajorSeeder extends Seeder
{
    public function run(): void
    {
        $combos = ['A00','A01','C01','C02','D01','X02'];
        $group  = 'Kỹ thuật & Công nghệ';

        $rows = [
            ['order_no'=> 1, 'code'=>'D101','name'=>'Điều khiển tàu biển'],
            ['order_no'=> 2, 'code'=>'D102','name'=>'Khai thác máy tàu biển'],
            ['order_no'=> 3, 'code'=>'D129','name'=>'Quản lý hàng hải'],
            ['order_no'=> 4, 'code'=>'D104','name'=>'Điện tử viễn thông'],
            ['order_no'=> 5, 'code'=>'D103','name'=>'Điện tự động giao thông vận tải'],
            ['order_no'=> 6, 'code'=>'D105','name'=>'Điện tự động công nghiệp'],
            ['order_no'=> 7, 'code'=>'D121','name'=>'Tự động hoá hệ thống điện'],
            ['order_no'=> 8, 'code'=>'D106','name'=>'Máy tàu thuỷ'],
            ['order_no'=> 9, 'code'=>'D107','name'=>'Thiết kế tàu và công trình ngoài khơi'],
            ['order_no'=>10, 'code'=>'D108','name'=>'Đóng tàu và công trình ngoài khơi'],
            ['order_no'=>11, 'code'=>'D109','name'=>'Máy và tự động hoá xếp dỡ'],
            ['order_no'=>12, 'code'=>'D116','name'=>'Kỹ thuật cơ khí'],
            ['order_no'=>13, 'code'=>'D117','name'=>'Kỹ thuật cơ điện tử'],
            ['order_no'=>14, 'code'=>'D122','name'=>'Kỹ thuật ô tô'],
            ['order_no'=>15, 'code'=>'D123','name'=>'Kỹ thuật nhiệt lạnh'],
            ['order_no'=>16, 'code'=>'D128','name'=>'Máy và tự động công nghiệp'],
            ['order_no'=>17, 'code'=>'D110','name'=>'Xây dựng công trình thuỷ'],
            ['order_no'=>18, 'code'=>'D111','name'=>'Kỹ thuật an toàn hàng hải'],
            ['order_no'=>19, 'code'=>'D112','name'=>'Xây dựng dân dụng và công nghiệp'],
            ['order_no'=>20, 'code'=>'D113','name'=>'Công trình giao thông và cơ sở hạ tầng'],
            ['order_no'=>21, 'code'=>'D127','name'=>'Kiến trúc và nội thất', 'note'=>'(Sơ tuyển Vẽ mỹ thuật)'],
            ['order_no'=>22, 'code'=>'D130','name'=>'Quản lý công trình xây dựng'],
            ['order_no'=>23, 'code'=>'D114','name'=>'Công nghệ thông tin'],
            ['order_no'=>24, 'code'=>'D118','name'=>'Công nghệ phần mềm'],
            ['order_no'=>25, 'code'=>'D119','name'=>'Kỹ thuật truyền thông và mạng máy tính'],
            ['order_no'=>26, 'code'=>'D131','name'=>'Quản lý kỹ thuật công nghiệp'],
            ['order_no'=>27, 'code'=>'D115','name'=>'Kỹ thuật môi trường'],
            ['order_no'=>28, 'code'=>'D126','name'=>'Kỹ thuật công nghệ hoá học'],
            ['order_no'=>29, 'code'=>'H105','name'=>'Điện tự động công nghiệp (nâng cao)', 'is_advanced'=>true],
            ['order_no'=>30, 'code'=>'H114','name'=>'Công nghệ thông tin (nâng cao)', 'is_advanced'=>true],
            ['order_no'=>31, 'code'=>'S101','name'=>'Điều khiển tàu biển (chọn)', 'is_optional'=>true, 'taught_in_english'=>true],
            ['order_no'=>32, 'code'=>'S102','name'=>'Khai thác máy tàu biển (chọn)', 'is_optional'=>true, 'taught_in_english'=>true],
        ];

        foreach ($rows as $r) {
            Major::updateOrCreate(
                ['code' => $r['code']],
                array_merge([
                    'name'               => $r['name'],
                    'group_name'         => $group,
                    'exam_combos'        => $combos,
                    'is_advanced'        => $r['is_advanced']        ?? false,
                    'is_optional'        => $r['is_optional']        ?? false,
                    'taught_in_english'  => $r['taught_in_english']  ?? false,
                    'order_no'           => $r['order_no'],
                    'active'             => true,
                    'note'               => $r['note']               ?? null,
                ])
            );
        }
    }
}
