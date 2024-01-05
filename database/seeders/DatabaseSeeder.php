<?php

namespace Database\Seeders;

use App\Models\Grup;
use App\Models\User;
use App\Models\Gedung;
use App\Models\Profil;
use App\Models\Upload;
use App\Models\Laporan;
use App\Models\Ruangan;
use App\Models\DataAset;
use App\Models\GrupUser;
use App\Models\JenisAset;
use App\Models\Perawatan;
use App\Models\PinjamAset;
use App\Models\AsetRuangan;
use App\Models\PenggunaAset;
use App\Models\Pemberitahuan;
use App\Models\PinjamRuangan;
use App\Models\UploadLaporan;
use App\Models\SerahTerimaAset;
use App\Models\UploadPerawatan;
use Illuminate\Database\Seeder;
use App\Models\RincianPerawatan;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //nilai default grup
        $dtdef = [
            "Admin", "Pengguna",
        ];

        foreach ($dtdef as $dt) {
            Grup::create([
                'grup' => $dt,
            ]);
        }

        //untuk admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@thisapp.com', //email login
            'password' => Hash::make('00000000'), // password default login 
        ]);

        //untuk pengguna
        for ($i = 1; $i <= 20; $i++) {
            User::create([
                'name' => 'Pengguna ' . $i,
                'email' => 'pengguna' . $i . '@thisapp.com', //email login
                'password' => Hash::make('00000000'), // password default login 
            ]);
        }

        //dibuatkan admin
        GrupUser::create([
            'user_id' => 1,
            'grup_id' => 1,
        ]);
        //dibuatkan pengguna
        GrupUser::create([
            'user_id' => 1,
            'grup_id' => 2,
        ]);

        //untuk pengguna
        for ($i = 1; $i <= 20; $i++) {
            GrupUser::create([
                'user_id' => $i + 1,
                'grup_id' => 2,
            ]);
        }

        //untuk admin
        Profil::create([
            'user_id' => 1,
            'hp' => '085331019999',
            'alamat' => 'BTN Rizky Blok B/II Ranomeeto Konsel',
            'jenis_kelamin' => 'L',
        ]);

        //untuk pengguna
        Profil::create([
            'user_id' => 2,
            'hp' => '085292927153',
            'alamat' => 'Jl. Teratai No. 15 D',
            'jenis_kelamin' => 'P',
        ]);

        //untuk gedung
        Gedung::create([
            'user_id' => 1,
            'nama' => 'Rektorat',
            'luas' => 300,
            'longitude' => -6.193125,
            'latitude' => 106.821810,
            'deskripsi' => 'Gedung utama',
            'is_aktif' => 1,
        ]);

        //untuk gedung
        Gedung::create([
            'user_id' => 1,
            'nama' => 'Perpustakaan',
            'luas' => 350,
            'longitude' => 0,
            'latitude' => 0,
            'deskripsi' => 'Gedung Perpustakaan IAIN Kendari',
            'is_aktif' => 1,
        ]);

        //untuk gedung
        Gedung::create([
            'user_id' => 1,
            'nama' => 'Auditorium Serba Guna',
            'luas' => 1500,
            'longitude' => 0,
            'latitude' => 0,
            'deskripsi' => 'Gedung Auditorium Lab Terpadu IAIN Kendari',
            'is_aktif' => 1,
        ]);

        //untuk ruangan
        Ruangan::create([
            'user_id' => 1,
            'nama' => 'Ruang Rapat Senat',
            'deskripsi' => '',
            'luas' => 50,
            'kapasitas' => 30,
            'lantai' => 2,
            'gedung_id' => 1,
            'is_aktif' => 1,
        ]);

        Ruangan::create([
            'user_id' => 1,
            'nama' => 'Umum dan Layanan Akademik',
            'deskripsi' => '',
            'luas' => 50,
            'kapasitas' => 30,
            'lantai' => 1,
            'gedung_id' => 1,
            'is_aktif' => 1,
        ]);

        Ruangan::create([
            'user_id' => 1,
            'nama' => 'Aula Perpustakaan',
            'deskripsi' => '',
            'luas' => 150,
            'kapasitas' => 200,
            'lantai' => 1,
            'gedung_id' => 2,
            'is_aktif' => 1,
        ]);

        Ruangan::create([
            'user_id' => 1,
            'nama' => 'Auditorium Terpadu',
            'deskripsi' => '',
            'luas' => 1500,
            'kapasitas' => 3000,
            'lantai' => 2,
            'gedung_id' => 3,
            'is_aktif' => 1,
        ]);

        //nilai default grup
        $dtdef = [
            //1         2       3           4               5               6       7        8
            "Mobil", "Motor", "Laptop", "Komputer PC", "PC All In One", "Kursi", "Infocus", "Meja",
            //9
            "Taman"
        ];

        foreach ($dtdef as $dt) {
            JenisAset::create([
                'user_id' => 1,
                'nama' => $dt,
                'is_aktif' => 1,
            ]);
        }

        //nilai default aset
        $dtdef = [
            ["Mac Book 14inc", 3, "apple", "12345", "90", 1, 0],
            ["Toyota Avanza", 1, "toyota", "54321", "62", 1, 0],
            ["Kursi Futura", 6, "futura", "67890", "44", 1, 0],
            ["Kursi Futura", 6, "futura", "09876", "52", 1, 0],
            ["Kursi Futura", 6, "futura", "11223", "99", 1, 0],
            ["Kursi Futura", 6, "futura", "32211", "67", 1, 0],
            ["Meja Rapat", 8, "olimpic", "88776", "13", 1, 0],
            ["Panasonic", 7, "panasonic", "67788", "09", 1, 0],
            ["Bunga", 9, "bunga", "67238", "039", 0, 1],
        ];

        foreach ($dtdef as $dt) {
            DataAset::create([
                'user_id' => 1,
                'nama' => $dt[0],
                'kode_barang' => $dt[3],
                'nup' => $dt[4],
                'is_aset' => $dt[5],
                'bisa_dipinjam' => $dt[6],
                'deskripsi' => '',
                'tgl_masuk' => date('Y-m-d'),
                'jenis_aset_id' => $dt[1],
                'is_aktif' => 1,
            ]);
        }

        //nilai default aset
        $dtdef = [
            [1, 1, 3],
            [1, 1, 4],
            [1, 1, 5],
            [1, 1, 6],
            [1, 1, 7],
            [1, 1, 8],
        ];

        foreach ($dtdef as $dt) {
            AsetRuangan::create([
                'user_id' => $dt[0],
                'ruangan_id' => $dt[1],
                'data_aset_id' => $dt[2],
            ]);
        }

        //nilai default aset
        $dtdef = [
            [1, 1, '2022-01-01 08:00:10'],
            [2, 1, '2023-10-15 09:00:10'],
            [3, 2, '2023-01-01 10:00:10'],
            [4, 3, '2021-01-01 11:00:10'],
            [5, 3, '2023-07-18 12:00:10'],
        ];

        foreach ($dtdef as $dt) {
            PenggunaAset::create([
                'user_id' => $dt[0],
                'data_aset_id' => $dt[1],
                'tgl_masuk' => $dt[2],
                'keterangan' => ''
            ]);
        }

        SerahTerimaAset::create([
            'tgl_kembali' => date('Y-m-d'),
            'kondisi' => 'baik',
            'keterangan' => '',
            'pengguna_aset_id' => 1
        ]);

        Laporan::create([
            'is_pengajuan' => false,
            'keterangan' => 'Tabe, bisa dicek ini radiator keknya ada yang rusak',
            'kode' => '10987587683949800',
            'data_aset_id' => 2,
            'user_id' => 2,
        ]);

        Upload::create([
            'path' => 'http://google.co.id',
            'name' => 'foto radiator',
            'size' => 1024,
            'user_id' => 2,
            'type' => 'img',
        ]);

        UploadLaporan::create([
            'upload_id' => 1,
            'laporan_id' => 1,
        ]);


        Perawatan::create([
            'tempat' => 'Toyota Hj. Kalla',
            'keterangan' => 'perbaikan radiator',
            'tgl_masuk' => date('Y-m-d H:i:s'),
            'user_id' => 1,
            'laporan_id' => 1,
        ]);

        RincianPerawatan::create([
            'perawatan_id' => 1,
            'keterangan' => 'OKE',
            'data_aset_id' => 2,
            'biaya' => 1000000,
        ]);

        UploadPerawatan::create([
            'upload_id' => 1,
            'perawatan_id' => 1,
        ]);

        PinjamAset::create([
            'biaya' => 0,
            'keterangan' => 'Sosialisasi Maba',
            'no_hp' => '085339183726',
            'peminjam_nama' => 'tommy patra',
            'peminjam_lembaga' => 'AKMA',
            'waktu_mulai' => date('Y-m-2 08:00:00'),
            'waktu_selesai' => date('Y-m-5 16:30:00'),
            'user_id' => 1,
            'file_upload' => 'https://google.co.id',
            'data_aset_id' => 2,
            'verifikator' => 'admin',
            'is_diterima' => 1,
            'is_pengajuan' => 1,

            'verifikasi_catatan' => ''
        ]);

        PinjamAset::create([
            'biaya' => 0,
            'keterangan' => 'Rapat Maba',
            'no_hp' => '085369000726',
            'peminjam_nama' => 'Rosdiana',
            'peminjam_lembaga' => 'kabag umum dan layanan akademik',

            'waktu_mulai' => date('Y-m-3 08:00:00'),
            'file_upload' => 'https://google.co.id',
            'waktu_selesai' => date('Y-m-4 16:30:00'),
            'user_id' => 2,
            'data_aset_id' => 1,
            'verifikator' => 'admin',
            'is_diterima' => 0,
            'is_pengajuan' => 1,
            'verifikasi_catatan' => 'ruangan sedang perbaikan'
        ]);
        PinjamAset::create([
            'biaya' => 0,
            'keterangan' => 'LDK di toronipa',
            'peminjam_nama' => 'Sartia',
            'peminjam_lembaga' => 'UK Mahiscita',
            'waktu_mulai' => date('Y-m-4 08:00:00'),
            'waktu_selesai' => date('Y-m-4 17:30:00'),
            'user_id' => 3,
            'file_upload' => 'https://google.co.id',
            'data_aset_id' => 3,
            'no_hp' => '085339180001',
            'verifikator' => 'admin',
            'is_diterima' => 1,
            'is_pengajuan' => 1,
            'verifikasi_catatan' => ''
        ]);

        PinjamAset::create([
            'biaya' => 0,
            'keterangan' => 'Worskhop Kebangsaan',
            'peminjam_nama' => 'Sakri',
            'peminjam_lembaga' => 'Pascasarjana',
            'no_hp' => '085239183999',
            'file_upload' => 'https://google.co.id',
            'waktu_mulai' => date('Y-m-7 08:00:00'),
            'waktu_selesai' => date('Y-m-8 20:00:00'),
            'user_id' => 1,
            'data_aset_id' => 2,
        ]);

        PinjamRuangan::create([
            'biaya' => 0,
            'keterangan' => 'Ujian KIP',
            'peminjam_nama' => 'Sakri',
            'peminjam_lembaga' => 'Layanan Akademik dan Kemahasiswaan',
            'no_hp' => '085239183999',
            'file_upload' => 'https://iainkendari.ac.id',
            'waktu_mulai' => date('Y-m-10 08:00:00'),
            'waktu_selesai' => date('Y-m-10 14:00:00'),
            'user_id' => 1,
            'ruangan_id' => 4,
            'verifikator' => 'admin',
            'is_diterima' => 1,
            'is_pengajuan' => 1,
            'verifikasi_catatan' => ''
        ]);

        PinjamRuangan::create([
            'biaya' => 0,
            'keterangan' => 'Wisuda Sarjana dan Magister',
            'peminjam_nama' => 'Sakri',
            'peminjam_lembaga' => 'Layanan Akademik dan Kemahasiswaan',
            'no_hp' => '085239183999',
            'file_upload' => 'https://iainkendari.ac.id',
            'waktu_mulai' => date('Y-m-14 08:00:00'),
            'waktu_selesai' => date('Y-m-14 15:00:00'),
            'user_id' => 1,
            'ruangan_id' => 4,
            'verifikator' => 'admin',
            'is_diterima' => 1,
            'is_pengajuan' => 1,
            'verifikasi_catatan' => ''
        ]);

        PinjamRuangan::create([
            'biaya' => 0,
            'keterangan' => 'Yudisium Fakultas Tarbiyah',
            'peminjam_nama' => 'Supriano',
            'peminjam_lembaga' => 'FATIK',
            'no_hp' => '084251625378',
            'file_upload' => 'https://iainkendari.ac.id',
            'waktu_mulai' => date('Y-m-6 08:00:00'),
            'waktu_selesai' => date('Y-m-6 15:00:00'),
            'user_id' => 1,
            'ruangan_id' => 4,
            'verifikator' => 'admin',
            'is_diterima' => 0,
            'is_pengajuan' => 1,
            'verifikasi_catatan' => 'sudah meminjam aula perpustakaan'
        ]);

        PinjamRuangan::create([
            'biaya' => 0,
            'keterangan' => 'Yudisium Fakultas Tarbiyah',
            'peminjam_nama' => 'Supriano',
            'peminjam_lembaga' => 'FATIK',
            'no_hp' => '084251625378',
            'file_upload' => 'https://iainkendari.ac.id',
            'waktu_mulai' => date('Y-m-6 08:00:00'),
            'waktu_selesai' => date('Y-m-6 15:00:00'),
            'user_id' => 1,
            'ruangan_id' => 3,
            'verifikator' => 'admin',
            'is_diterima' => 1,
            'is_pengajuan' => 1,
            'verifikasi_catatan' => ''
        ]);

        PinjamRuangan::create([
            'biaya' => 0,
            'keterangan' => 'Pelantikan UK Olahraga',
            'peminjam_nama' => 'Agung',
            'peminjam_lembaga' => 'DEMA FATIK',
            'no_hp' => '084251622228',
            'file_upload' => 'https://iainkendari.ac.id',
            'waktu_mulai' => date('Y-m-22 08:00:00'),
            'waktu_selesai' => date('Y-m-22 15:00:00'),
            'user_id' => 1,
            'ruangan_id' => 3,
        ]);

        PinjamRuangan::create([
            'biaya' => 0,
            'keterangan' => 'Rapat Senat',
            'peminjam_nama' => 'Hafsikin',
            'peminjam_lembaga' => 'Senat',
            'no_hp' => '084251690872',
            'file_upload' => 'https://iainkendari.ac.id',
            'waktu_mulai' => date('Y-m-2 08:00:00'),
            'waktu_selesai' => date('Y-m-3 15:00:00'),
            'user_id' => 1,
            'ruangan_id' => 3,
            'is_pengajuan' => 1,
        ]);

        //nilai default aset
        $dtdef = [
            ['Tommy', 'Laporan Kerusakan', 'Ada Laporan kerusakan barang', 1, 1, 1],
            ['Amalia', 'Peminjaman Barang', 'Usulan anda ditolak, silahkan cek', 2, 0, 2],
            ['Aleesya', 'Peminjaman Ruangan', 'Usulan anda diterima', 3, 0, 3],
            ['Alfath', 'Peminjaman Ruangan', 'Peminjaman ruangan diterima', 1, 0, 1],
            ['Arumi', 'Peminjaman Barang', 'Peminjaman barang dikembalikan, silahkan cek', 2, 0, 2],
            ['Desi', 'Laporan Kerusakan', 'Laporan kerusakan barang diterima', 3, 1, 3],
            ['Arisani', 'Peminjaman Barang', 'Ada usul peminjaman barang', 1, 0, 1],
        ];

        foreach ($dtdef as $dt) {
            Pemberitahuan::create([
                'pengirim' => $dt[0],
                'judul' => $dt[1],
                'pesan' => $dt[2],
                'user_id' => $dt[3],
                'is_dibaca' => $dt[4],
                'pk_id' => $dt[5],
            ]);
        }
    }
}
