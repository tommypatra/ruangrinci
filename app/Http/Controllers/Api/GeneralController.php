<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\DataAset;
use Illuminate\Http\Request;
use App\Models\Pemberitahuan;
use App\Http\Controllers\Controller;
use App\Http\Resources\PemberitahuanResource;

class GeneralController extends Controller
{
    function asetBelumTerdistribusi(Request $request)
    {
        $searchTerm = $request->input('keyword');

        $query = DataAset::whereDoesntHave('asetRuangan');

        if (!empty($searchTerm)) {
            $query->where('nama', 'like', '%' . $searchTerm . '%');
        }
        $data = $query->get();

        return response()->json([
            'success' => true,
            'message' => 'ditemukan',
            'data' => $data,
        ], 201);
    }

    function notifikasiUser(Request $request)
    {
        $user_id = $request->input('user_id');

        // Daftar notifikasi terbaru
        $data = Pemberitahuan::where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->orderBy('is_dibaca', 'asc')
            ->take(5)
            ->get();

        // Total jumlah notifikasi
        // $notifTotal = Pemberitahuan::where('user_id', $user_id)->count();

        // Total notifikasi yang is_dibaca = 0
        $notifBelumDibaca = Pemberitahuan::where('user_id', $user_id)
            ->where('is_dibaca', 0)
            ->count();

        return response()->json([
            'success' => true,
            'message' => 'ditemukan',
            'data' => PemberitahuanResource::collection($data),
            'belumDibaca' => $notifBelumDibaca,
        ], 201);
    }

    function daftarAkunAdmin()
    {
        $query = User::select('id', 'name')->orderBy('id', 'asc')
            ->whereHas('grupUser', function ($query) {
                $query->where('grup_id', 1);
            });
        $data = $query->get();

        return response()->json([
            'success' => true,
            'message' => 'ditemukan',
            'data' => $data,
        ], 201);
    }
}
