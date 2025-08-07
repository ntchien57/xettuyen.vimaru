<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DaoTaoController extends Controller
{
    public function index()
    {
        return view('daotao.home');
    }

    public function xettuyen()
    {
        $thiSinhs = json_decode(Storage::get('dulieu_thisinh.json'), true);

        return view('daotao.xettuyen', compact('thiSinhs'));
    }

    public function chayXetTuyen(Request $request)
    {
        $thiSinhs = json_decode(Storage::get('dulieu_thisinh.json'), true);

        // Thêm các trường cần thiết
        foreach ($thiSinhs as &$ts) {
            $ts['trang_thai'] = 'dang_xet';
            $ts['index_nv'] = 0;
        }

        $quotas = $request->input('quota');
        $nganhs = [];
        foreach ($quotas as $key => $value) {
            $nganhs[$key] = ['quota' => (int)$value, 'tam_nhan' => [], 'ds_moi' => []];
        }
        // Thuật toán DAA
        $co_thay_doi = true;
        while ($co_thay_doi) {
            $co_thay_doi = false;
            $ung_vien_moi = [];

            foreach ($thiSinhs as &$ts) {
                if ($ts['trang_thai'] !== 'dang_xet') continue;

                $nv = $ts['nguyen_vongs'][$ts['index_nv']] ?? null;
                if (!$nv) {
                    $ts['trang_thai'] = 'rot';
                    continue;
                }

                $ung_vien_moi[$nv][] = &$ts;
            }

            foreach ($ung_vien_moi as $nganh => $ds) {
                $cu = $nganhs[$nganh]['tam_nhan'];
                $tap_hop = array_merge($cu, $ds);

                usort($tap_hop, fn($a, $b) => $b['diem'] <=> $a['diem']);
                $moi = array_slice($tap_hop, 0, $nganhs[$nganh]['quota']);

                $ids_cu = array_column($cu, 'id');
                $ids_moi = array_column($moi, 'id');

                if ($ids_cu !== $ids_moi) $co_thay_doi = true;

                $nganhs[$nganh]['tam_nhan'] = $moi;

                foreach ($tap_hop as &$ts) {
                    if (in_array($ts['id'], $ids_moi)) {
                        $ts['trang_thai'] = 'trung_tuyen';
                    } else {
                        $ts['index_nv']++;
                        if (!isset($ts['nguyen_vongs'][$ts['index_nv']])) {
                            $ts['trang_thai'] = 'rot';
                        } else {
                            $ts['trang_thai'] = 'dang_xet';
                        }
                    }
                }
            }
        }

        return view('daotao.xettuyen', [
            'thiSinhs' => $thiSinhs,
            'daXetTuyen' => true
        ]);
    }
}
