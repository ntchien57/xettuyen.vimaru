<?php 

namespace App\Exports;

use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class AcceptedWishesExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithColumnFormatting
{
    protected Builder $query;
    protected int $rowIndex = 0;

    public function __construct(Builder $query) { $this->query = $query; }
    public function query() { return $this->query; }

    public function headings(): array
    {
        return ['#','Họ tên','Email','CCCD','SBD','NV','Mã ngành','Chuyên ngành','Điểm D01','Thời điểm đậu'];
    }

    public function map($row): array
    {
        $this->rowIndex++;
        return [
            $this->rowIndex,
            $row->student_name,
            $row->email,
            $row->cccd,
            $row->exam_id,
            $row->order_no,
            $row->major_code,
            $row->major_name,
            is_null($row->score_d01) ? null : round($row->score_d01, 2),
            (string) $row->updated_at,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'I' => NumberFormat::FORMAT_NUMBER_00, // Điểm
            'D' => NumberFormat::FORMAT_TEXT,      // CCCD
            'E' => NumberFormat::FORMAT_TEXT,      // SBD
        ];
    }
}
