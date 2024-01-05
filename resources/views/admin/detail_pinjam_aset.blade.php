@extends('admin.template')

@section('head')
<title>Detail Peminjaman Aset</title>

@endsection

@section('pageTitle')
<div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('akun-dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Detail-Peminjaman-Aset</li>
        </ol>
    </nav>
</div><!-- End Page Title -->
@endsection

@section('container')
<div class="col-lg-12">
    <div class="row">
        <div class="card info-card customers-card">
            <div class="filter">
                <a class="icon" href="javascript:;" onclick="load()"><i class="bi bi-arrow-clockwise"></i></a>
            </div>

            <div class="card-body">
                <h5 class="card-title">Detail Peminjaman  <span>| Barang</span></h5>
                <div class="d-flex align-items-center">
                    <div class="row">
                        <h5 id="aset" style="font-weight:bold;">Barang</b></h5>
                        <div id="jenis" style="font-style:italic;">Jenis</div>
                        <div id="waktu">Waktu Mulai sd Waktu Selesai (Jumlah Waktu)</div>
                        <div class="mt-2 mb-2" style="border-top:1px solid #cddfff;"></div>
                        <div class="col-lg-8">
                            <div><i class="bi bi-person"></i> <span id="peminjam_nama">Nama Penanggung Jawab</span></div>
                            <div><i class="bi bi-phone"></i> <span id="no_hp" style="font-size:12px;">No. HP</span></div>
                            <div id="peminjam_lembaga">Lembaga/ Unit</div>
                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                <h5 class="alert-heading">Keterangan</h5>
                                <p id="keterangan">Rincinan Keterangan</p>
                            </div>                            
                            <div><a href="javascript:;" id="file_upload">Lampiran</a></div>
                        </div>
                        <div class="col-lg-4">
                            <div id="verifikasi">Verifikasi</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('body')
<script type="text/javascript">
    var vId='{{ $id; }}'; 
    var vIdPemberitahuan='{{ $id_pemberitahuan; }}'; 
    var vApi='/api/pinjam-aset';
    var vJudul='Detail Peminjaman Barang';

    // statusPemberitahuan(vIdPemberitahuan);    
    load();

    function load(){
        $.ajax({
            type: 'GET',
            url: vApi + '?filter={"id":'+vId+'}',
            dataType: 'json',
            success: function(response) {
                
                if (response.data.length>0) {
                    var dt=response.data[0];
                    console.log(dt);
                    var labelApp=labelSetupVerifikasi(dt.is_pengajuan,dt.is_diterima,dt.verifikasi_catatan,dt.verifikator);
                    var verifikasi=labelApp.label+labelApp.catatan;
                    $("#aset").html(dt.data_aset.nama);
                    $("#jenis").html(dt.data_aset.jenis_aset.nama);
                    $("#waktu").html(`<span class="badge bg-info">${dt.waktu_mulai}</span> sd <span class="badge bg-info">${dt.waktu_selesai}</span> (${dt.jumlah_waktu})`);
                    $("#peminjam_nama").html(dt.peminjam_nama);
                    $("#peminjam_lembaga").html(dt.peminjam_lembaga);
                    $("#no_hp").html(dt.no_hp);
                    $("#keterangan").html(dt.keterangan);
                    $("#verifikasi").html(verifikasi);
                    
                } else
                    appShowNotification(response.success, [response.message]);
            },
            error: function(xhr, status, error) {
                appShowNotification(false, ['Something went wrong. Please try again later.']);
            }
        });
    }


</script>
@endsection