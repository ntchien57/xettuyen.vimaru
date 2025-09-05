<?php

namespace App\Http\Controllers;

use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MajorController extends Controller
{
    // Tổ hợp mẫu để hiển thị trong form (có thể đưa sang config)
    private array $comboOptions = ['A00','A01','C01','C02','D01','X02'];

    public function index()
    {
        $majors = Major::orderBy('order_no')->orderBy('code')->paginate(10);

        return view('admin.majors.index', [
            'majors' => $majors,
            'comboOptions' => $this->comboOptions,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code'   => ['required','string','max:20','unique:majors,code'],
            'name'   => ['required','string','max:255'],
            'group_name' => ['nullable','string','max:255'],
            'exam_combos'=> ['nullable','array'],
            'exam_combos.*' => ['string', Rule::in($this->comboOptions)],
            'is_advanced'       => ['nullable','boolean'],
            'is_optional'       => ['nullable','boolean'],
            'taught_in_english' => ['nullable','boolean'],
            'order_no'          => ['nullable','integer','min:0'],
            'active'            => ['nullable','boolean'],
            'note'              => ['nullable','string','max:255'],
        ]);

        // checkbox null → false
        $data['is_advanced']       = (bool) ($data['is_advanced'] ?? false);
        $data['is_optional']       = (bool) ($data['is_optional'] ?? false);
        $data['taught_in_english'] = (bool) ($data['taught_in_english'] ?? false);
        $data['active']            = (bool) ($data['active'] ?? true);

        Major::create($data);

        return back()->with('success', 'Đã thêm chuyên ngành.');
    }

    public function update(Request $request, Major $major)
    {
        $data = $request->validate([
            'code'   => ['required','string','max:20', Rule::unique('majors','code')->ignore($major->id)],
            'name'   => ['required','string','max:255'],
            'group_name' => ['nullable','string','max:255'],
            'exam_combos'=> ['nullable','array'],
            'exam_combos.*' => ['string', Rule::in($this->comboOptions)],
            'is_advanced'       => ['nullable','boolean'],
            'is_optional'       => ['nullable','boolean'],
            'taught_in_english' => ['nullable','boolean'],
            'order_no'          => ['nullable','integer','min:0'],
            'active'            => ['nullable','boolean'],
            'note'              => ['nullable','string','max:255'],
        ]);

        $data['is_advanced']       = (bool) ($data['is_advanced'] ?? false);
        $data['is_optional']       = (bool) ($data['is_optional'] ?? false);
        $data['taught_in_english'] = (bool) ($data['taught_in_english'] ?? false);
        $data['active']            = (bool) ($data['active'] ?? true);

        $major->update($data);

        return back()->with('success', 'Đã cập nhật chuyên ngành.');
    }

    public function destroy(Major $major)
    {
        $major->delete();
        return back()->with('success','Đã xoá chuyên ngành.');
    }
}
