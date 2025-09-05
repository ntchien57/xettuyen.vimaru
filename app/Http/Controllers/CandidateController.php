<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    public function index(Request $request)
    {
        $users = User::where('role', 0)
            ->select('id','hoten','email','cccd','created_at')
            ->with(['profile' => function ($q) {
                $q->select(
                    'id','user_id','full_name','dob','gender','ethnicity','cccd_number','birth_place','email as profile_email','phone',
                    'address','priority_object','priority_area','graduation_year',
                    'contact_name','contact_relation','contact_phone','contact_email',
                    'cccd_front_path','cccd_back_path'
                );
            }])
            ->orderBy('hoten')
            ->paginate(10);

        return view('admin.candidates.index', compact('users'));
    }
}
