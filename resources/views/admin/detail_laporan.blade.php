@extends('admin.template')

@section('head')
<title>Detail Laporan</title>

@endsection

@section('pageTitle')
<div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('akun-dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Detail-Laporan</li>
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
                <h5 class="card-title">Detail <span>| Laporan</span></h5>
                <div class="d-flex align-items-center">
                    <div class="row">
                        <h5 id="aset" style="font-weight:bold;">Barang</b></h5>
                        <div id="jenis" style="font-style:italic;">Jenis</div>
                        <div id="keterangan">Keterangan</div>
                        <div class="mt-2 mb-2" style="border-top:1px solid #cddfff;"></div>
                        <div class="col-lg-8">
                            <div><i class="bi bi-person"></i> <span id="nama">Nama Penanggung Jawab</span></div>
                            <div><i class="bi bi-phone"></i> <span id="no_hp" style="font-size:12px;">No. HP</span></div>
                            <div id="uploads">Daftar Lampiran</div>
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
    var vApi='/api/laporan';
    var vJudul='Detail Laporan';

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
                    var labelApp=labelSetupVerifikasi(dt.is_pengajuan,dt.is_diterima,dt.verifikasi_catatan,dt.verifikator);
                    var verifikasi=labelApp.label+labelApp.catatan;

                    var uploads="";
                    if(dt.upload_laporan.length>0){
                        uploads+="<ul>";
                        $.each(dt.upload_laporan, function(index, dt) {
                            if(is_image(dt.upload.type))
                                uploads +=`<li><span class="fa-li"><i class="fa-solid fa-arrow-up-right-from-square"></i></span><a href="javascript:;" data-url="${dt.upload.path}" class="imgprev" target="_self">${dt.upload.name}</a> </li>`;
                            else
                                uploads +=`<li><span class="fa-li"><i class="fa-solid fa-arrow-up-right-from-square"></i></span><a href="${dt.upload.path}" target="_blank">${dt.upload.name}</a> </li>`;
                        });
                        uploads+="<ul>";
                    }

                    $("#aset").html(dt.data_aset.nama);
                    $("#jenis").html(dt.data_aset.jenis_aset.nama);
                    $("#keterangan").html(dt.keterangan);
                    $("#nama").html(dt.user.name);
                    $("#no_hp").html(dt.user.profil[0].hp);
                    $("#verifikasi").html(verifikasi);
                    $("#uploads").html(uploads);
                    
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