<?php

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Http;

function showQRCode($kode, $size = 300)
{
    // $qrCode = QrCode::size($size)->generate($kode);
    $qrCode = QrCode::size($size)->format('svg')->generate($kode);
    $base64 = 'data:image/svg+xml;base64,' . base64_encode($qrCode);
    return $base64;
}

function generateUniqueFileName($originalFileName)
{
    $randomString = time() . Str::random(22);
    // $encryptedString = encrypt($randomString);
    $extension = pathinfo($originalFileName, PATHINFO_EXTENSION);
    $uniqueFileName = $randomString . '.' . $extension;
    return $uniqueFileName;
}

function generateKode($id, $len = 16)
{
    $sisa_panjang = $len - strlen($id);
    $sisa_random = '';
    for ($i = 0; $i < $sisa_panjang; $i++) {
        $sisa_random .= rand(0, 9);
    }

    $kode = $id . $sisa_random;
    return $kode;
}

function cekPort($host = '127.0.0.1', $ports = ['6001'])
{
    foreach ($ports as $port) {
        $connection = @fsockopen($host, $port);
        $return = 0;
        if (is_resource($connection)) {
            $return = 1;
            fclose($connection);
        }
        return $return;
    }
}

function formatNotNull($check = null)
{
    return ($check) ? $check : "";
}

function waktuFormat($dateTime, $format = 'Y-m-d H:i:s')
{
    return Carbon::parse($dateTime)->format($format);
}

function waktu_lalu($timestamp = null, $timestamp2 = null)
{
    $waktu = "";
    $label = " lalu";
    if (!$timestamp2)
        $timestamp2 = time();
    else {
        $label = "";
        $timestamp2 = strtotime($timestamp2);
        // $timestamp2 = date('Y-m-d H:i:s', $phpdate2);
    }

    if ($timestamp) {
        $phpdate = strtotime($timestamp);
        $mysqldate = date('Y-m-d H:i:s', $phpdate);

        $selisih = $timestamp2 - strtotime($mysqldate);
        $detik = $selisih;
        $menit = round($selisih / 60);
        $jam = round($selisih / 3600);
        $hari = round($selisih / 86400);
        $minggu = round($selisih / 604800);
        $bulan = round($selisih / 2419200);
        $tahun = round($selisih / 29030400);
        if ($detik <= 60) {
            $waktu = $detik . ' detik' . $label;
        } else if ($menit <= 60) {
            $waktu = $menit . ' menit' . $label;
        } else if ($jam <= 24) {
            $waktu = $jam . ' jam' . $label;
        } else if ($hari <= 7) {
            $waktu = $hari . ' hari' . $label;
        } else if ($minggu <= 4) {
            $waktu = $minggu . ' minggu' . $label;
        } else if ($bulan <= 12) {
            $waktu = $bulan . ' bulan' . $label;
        } else {
            $waktu = $tahun . ' tahun' . $label;
        }
    }
    return $waktu;
}

function listAksesHtml($hakakses = [])
{
    // dd($hakakses)
    // $hakakses = (object) $hakakses;
    $retval = '<ul>';
    foreach ($hakakses as $i => $dp) {
        // $dp = (object) $dp;
        $link = route('akun-set-akses', ['grup_id' => $dp['grup']['id']]);
        $retval .= '<li><a href="' . $link . '">' . $dp['grup']['grup'] . '</a></li>';
    }
    $retval .= '</ul>';
    return $retval;
}

function generateToken($length = 64)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = date("smy");
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    $randomString .= date("iHd");
    return $randomString;
}

function belumDikembalikan($id = null)
{
    $query = PenggunaAset::where("id", $id)->where("");
    $data = $query->get();
    return PenggunaAsetResource::collection($data);
}

function bulanAngkaToRomawi($bulan = 1)
{
    $bulan = (int)$bulan;
    $romawi = [
        1 => 'I',
        2 => 'II',
        3 => 'III',
        4 => 'IV',
        5 => 'V',
        6 => 'VI',
        7 => 'VII',
        8 => 'VIII',
        9 => 'IX',
        10 => 'X',
        11 => 'XI',
        12 => 'XII'
    ];
    return isset($romawi[$bulan]) ? $romawi[$bulan] : 'I';
}

function pemberitahuanBaru($request = null)
{
    $respon = false;
    if ($request) {
        $urlWeb = url()->current();
        $urlApi = $urlWeb . '/api/pemberitahuan';
        $response = Http::post($urlApi, [
            'judul' => $request['judul'],
            'pengirim' => $request['pengirim'],
            'link' => $request['link'],
            'pesan' => $request['pesan'],
            'user_id' => $request['user_id'],
        ]);

        if ($response->successful()) {
            $respon = true;
        }
    }
    return $respon;
}
