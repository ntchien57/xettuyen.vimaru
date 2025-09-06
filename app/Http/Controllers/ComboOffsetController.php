<?php

namespace App\Http\Controllers;

use App\Models\ComboOffset;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class ComboOffsetController extends Controller
{
    // Map tổ hợp → danh sách môn (sửa tại đây khi cần)
    private array $comboOptions = [
        'A00' => 'A00 - Toán, Vật lí, Hóa học',
        'A01' => 'A01 - Toán, Vật lí, Tiếng Anh',
        'C00' => 'C00 - Ngữ văn, Lịch sử, Địa lí',
        'C01' => 'C01 - Ngữ văn, Toán, Vật lí',
        'C02' => 'C02 - Ngữ văn, Toán, Hóa học',
        'C03' => 'C03 - Ngữ văn, Toán, Lịch sử',
        'C04' => 'C04 - Ngữ văn, Toán, Địa lí',
        'D01' => 'D01 - Toán, Ngữ văn, Tiếng Anh',
        'D09' => 'D09 - Toán, Lịch sử, Tiếng Anh',
        'D10' => 'D10 - Toán, Địa lí, Tiếng Anh',
        'D14' => 'D14 -Ngữ văn, Lịch sử, Tiếng Anh',
        'D15' => 'D15 - Ngữ văn, Địa lí, Tiếng Anh',
        'X02' => 'X02 - Toán, Văn, Tin', 
    ];

    private array $methodOptions = ['PT1','PT2'];

    public function index(Request $request)
    {
        $offsets = \App\Models\ComboOffset::orderBy('order_no')->orderBy('combo_code')->paginate(12);
        return view('admin.combo_offsets.index', [
            'offsets'       => $offsets,
            'comboOptions'  => $this->comboOptions,
            'methodOptions' => $this->methodOptions,
        ]);
    }

    public function store(Request $request)
    {
        $codes = array_keys($this->comboOptions);

        $data = $request->validate([
            'combo_code' => ['required','string','max:10', Rule::in($codes)],
            'base_code'  => ['required','string','max:10', Rule::in($codes)],
            'method'     => ['nullable','string','max:10', Rule::in($this->methodOptions)],
            'delta'      => ['required','numeric','between:-10,10'],
            'order_no'   => ['nullable','integer','min:0'],
            'active'     => ['nullable','boolean'],
        ]);

        $data['active'] = (bool) ($data['active'] ?? true);

        $exists = \App\Models\ComboOffset::where('combo_code',$data['combo_code'])
                  ->where('base_code',$data['base_code'])
                  ->where('method',$data['method'])->exists();
        if ($exists) {
            return back()->withErrors(['combo_code'=>'Bản ghi đã tồn tại cho tổ hợp & phương thức này.'])->withInput();
        }

        \App\Models\ComboOffset::create($data);
        return back()->with('success','Đã thêm độ chênh.');
    }

    public function update(Request $request, \App\Models\ComboOffset $offset)
    {
        $codes = array_keys($this->comboOptions);

        $data = $request->validate([
            'combo_code' => ['required','string','max:10', Rule::in($codes)],
            'base_code'  => ['required','string','max:10', Rule::in($codes)],
            'method'     => ['nullable','string','max:10', Rule::in($this->methodOptions)],
            'delta'      => ['required','numeric','between:-10,10'],
            'order_no'   => ['nullable','integer','min:0'],
            'active'     => ['nullable','boolean'],
        ]);

        $data['active'] = (bool) ($data['active'] ?? true);

        $dupe = \App\Models\ComboOffset::where('combo_code',$data['combo_code'])
                ->where('base_code',$data['base_code'])
                ->where('method',$data['method'])
                ->where('id','<>',$offset->id)->exists();
        if ($dupe) {
            return back()->withErrors(['combo_code'=>'Bản ghi đã tồn tại cho tổ hợp & phương thức này.'])->withInput();
        }

        $offset->update($data);
        return back()->with('success','Đã cập nhật.');
    }
}

