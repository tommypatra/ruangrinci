<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\GrupUser;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\AuthResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\GeneralController;

class AuthController extends Controller
{

    public function login(AuthRequest $request)
    {

        try {
            $credentials = $request->validated();
            if (Auth::attempt($credentials)) {
                $user = User::where('email', $request->email)->first();

                // $token = $user->createToken('api_token')->plainTextToken;
                $user = new AuthResource($user);
                $daftarAksesData = $this->daftarAkses($request)->getData();
                $hakakses = $daftarAksesData->data->hakakses;
                $akses = $daftarAksesData->data->akses;

                // $role = '';
                // foreach ($hakakses as $i => $dp) {
                //     $role .= strtolower($dp->grup->grup);
                //     if ($i < count($hakakses) - 1)
                //         $role .= '|';
                // };
                // $token = $user->createToken('api_token', ['role' => $hakakses])->plainTextToken;
                $token = $user->createToken('api_token')->plainTextToken;

                // untuk dapatkan daftar admin
                $generalController = new GeneralController();
                $data = $generalController->daftarAkunAdmin()->getContent();
                $admins = json_decode($data, true);
                $admins = $admins['data'];
                //--------------------

                $respon_data = [
                    'success' => true,
                    'message' => 'user ditemukan',
                    'data' => $user,
                    'access_token' => $token,
                    'hakakses' => $hakakses,
                    'admins' => $admins,
                    'akses' => $akses,
                    'token_type' => 'Bearer',
                ];
                return response()->json($respon_data, 200);
            }
            return response()->json([
                'success' => false,
                'message' => 'User atau password anda salah',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again later. ' . $e->getMessage(),
            ], 500);
        }
    }

    public function daftarAkses(Request $request)
    {
        try {
            $getAkses = User::with('grupUser.grup')->where('email', $request->email);
            if (!$getAkses->first()) {
                return response()->json([
                    'success' => false,
                    'message' => 'tidak ditemukan',
                ], 404);
            }
            $dtAkses = $getAkses->first();
            $akses = null;
            foreach ($dtAkses->grupUser as $i => $grp) {
                if (!$akses)
                    $akses = $grp->grup_id;
            }
            $hakakses = $dtAkses->grupUser;
            $respon_data = [
                'success' => true,
                'message' => 'ditemukan',
                'data' => [
                    'hakakses' => $hakakses,
                    'akses' => $akses,
                ]
            ];
            return response()->json($respon_data, 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again later. ' . $e->getMessage(),
            ], 500);
        }
    }

    public function keluar()
    {
        try {
            Auth::logout();
            return response()->json(["status" => "berhasil"], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again later. ' . $e->getMessage(),
            ], 500);
        }
    }
}
