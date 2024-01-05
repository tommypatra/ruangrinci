<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\GrupUser;
use App\Http\Controllers\Api\GeneralController;

class WebController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function setSession(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'tidak ditemukan',
            ], 404);
        }
        //set auth session login untuk middleware
        Auth::login($user);
        //set session
        session()->put('access_token', $request->input('access_token'));
        session()->put('akses', $request->input('akses'));
        session()->put('admins', $request->input('admins'));
        session()->put('hakakses', $request->input('hakakses'));

        $respon_data = [
            'success' => true,
            'message' => 'set berhasil ditemukan',
        ];
        $respon_data['hakakses'] = session()->get("hakakses");
        $respon_data['hakakses_html'] = listAksesHtml(session()->get("hakakses"));

        return response()->json($respon_data, 200);
    }

    public function setAkses($grup_id = null)
    {
        $hakakses = session()->get("hakakses");
        $boleh = false;
        foreach ($hakakses as $i => $dp) {
            if ($dp['grup_id'] == $grup_id) {
                $boleh = true;
            }
        }
        if ($boleh) {
            session(
                [
                    'akses' => $grup_id,
                ]
            );
        }
        return redirect()->route('akun-dashboard');
    }


    public function masuk()
    {
        return view('masuk');
    }

    public function mendaftar()
    {
        return view('daftar');
    }

    public function grup()
    {
        return view('admin.grup');
    }

    public function pengguna()
    {
        return view('admin.pengguna');
    }

    public function gedung()
    {
        return view('admin.gedung');
    }

    public function ruangan()
    {
        return view('admin.ruangan');
    }

    public function jenisAset()
    {
        return view('admin.jenis_aset');
    }

    public function dataAset()
    {
        return view('admin.data_aset');
    }

    public function pinjamAset()
    {
        return view('admin.pinjam_aset');
    }

    public function pinjamRuangan()
    {
        return view('admin.pinjam_ruangan');
    }

    public function penggunaAset()
    {
        return view('admin.pengguna_aset');
    }

    public function pengajuanLaporan()
    {
        return view('admin.pengajuan_laporan');
    }

    public function laporan()
    {
        return view('admin.laporan');
    }

    public function perawatan()
    {
        return view('admin.perawatan');
    }

    public function pinjamAsetValidasi()
    {
        return view('admin.pinjam_aset_validasi');
    }

    public function pinjamRuanganValidasi()
    {
        return view('admin.pinjam_ruangan_validasi');
    }

    public function detailPinjamRuangan($id = null, $id_pemberitahuan = null)
    {
        return view('admin.detail_pinjam_ruangan', ["id" => $id, "id_pemberitahuan" => $id_pemberitahuan]);
    }

    public function detailPinjamAset($id = null, $id_pemberitahuan = null)
    {
        return view('admin.detail_pinjam_aset', ["id" => $id, "id_pemberitahuan" => $id_pemberitahuan]);
    }

    public function detailLaporan($id = null, $id_pemberitahuan = null)
    {
        return view('admin.detail_laporan', ["id" => $id, "id_pemberitahuan" => $id_pemberitahuan]);
    }

    public function profil()
    {
        return view('admin.profil');
    }
}
