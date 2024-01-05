@extends('admin.template')

@section('head')
<title>Validasi Peminjaman Ruangan</title>
<link href="{{ asset('js/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet">
<link href="{{ asset('js/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('js/select2/dist/css/select2.custom.css') }}" rel="stylesheet">
<link href="{{ asset('js/img-viewer/viewer.min.css') }}" rel="stylesheet">
@endsection

@section('pageTitle')
<div class="pagetitle">
    <h1>Validasi Peminjaman Ruangan</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('akun-dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Validasi Peminjaman Ruangan</li>
        </ol>
    </nav>
</div><!-- End Page Title -->
@endsection


@section('container')
<div class="col-lg-12">
    <div class="row">
        <div class="card info-card customers-card">
            <div class="filter">
                <a class="icon" href="javascript:;" onclick="refresh()"><i class="bi bi-arrow-clockwise"></i></a>
                <a class="icon" href="javascript:;" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                        <h6>Filter</h6>
                    </li>
                </ul>
            </div>

            <div class="card-body">
                <h5 class="card-title">Validasi Peminjaman <span>| Ruangan</span></h5>
                
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="masuk-tab" data-bs-toggle="tab" data-bs-target="#masuk" type="button" role="tab" aria-controls="masuk" aria-selected="true" onclick="loadDataMasuk()">Masuk</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="disetujui-tab" data-bs-toggle="tab" data-bs-target="#disetujui" type="button" role="tab" aria-controls="disetujui" aria-selected="false" onclick="loadDataDisetujui()">Disetujui</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="ditolak-tab" data-bs-toggle="tab" data-bs-target="#ditolak" type="button" role="tab" aria-controls="ditolak" aria-selected="false" onclick="loadDataDitolak()">Ditolak</button>
                    </li>
                </ul>

                <div class="table-responsive">
                    <table class="table" >
                        <thead>
                            <tr>
                                <th>No</th>
                                <th style="width:50%">Ruangan/Keterangan/pengguna</th>
                                <th style="width:15%">Tanggal Penggunaan</th>
                                <th style="width:25%">Status/Lampiran</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="dataTableBody">
                            <!-- Data will be dynamically populated here -->
                        </tbody>
                    </table>
                    <nav aria-label="Page navigation">
                        <ul class="pagination" id="pagination">
                            <!-- Pagination links will be dynamically populated here -->
                        </ul>
                        <div id="pagination-info"></div>
                    </nav>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- MULAI MODAL -->
<div class="modal fade modal" id="modal-form" role="dialog">
    <div class="modal-dialog">
        <form id="myForm">
            <input type="hidden" name="id" id="id" >
            <input type="hidden" name="verifikator" id="verifikator" value="{{ auth()->user()->name }}" >
            <input type="hidden" name="keterangan" id="keterangan">
            <input type="hidden" name="no_hp" id="no_hp">
            <input type="hidden" name="biaya" id="biaya">
            <input type="hidden" name="peminjam_nama" id="peminjam_nama">
            <input type="hidden" name="peminjam_lembaga" id="peminjam_lembaga">
            <input type="hidden" name="waktu_mulai" id="waktu_mulai">
            <input type="hidden" name="waktu_selesai" id="waktu_selesai">
            <input type="hidden" name="user_id" id="user_id">
            <input type="hidden" name="ruangan_id" id="ruangan_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-label">Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <div class="row">
						<div class="col-lg-6 mb-3">
                            <label class="form-label">Diajukan</label>
                            <select name="is_pengajuan" id="is_pengajuan" class="form-control" required></select>
                        </div>
						<div class="col-lg-6 mb-3" id="input_is_diterima">
                            <label class="form-label">Status Persetujuan</label>
                            <select name="is_diterima" id="is_diterima" class="form-control" required></select>
                        </div>

                        <div class="col-lg-12 mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea rows="4" name="verifikasi_catatan" id="verifikasi_catatan" type="text" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="btn-simpan">Simpan</button>
                    <button type="button" class="btn btn-outline-primary " data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- AKHIR MODAL -->

{{-- Modal Upload --}}
<div class="modal fade modal-lg" id="modal-upload" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-upload-label">Ambil Gambar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3" style="align:center">
                    <div class="col-lg-8">
                        <video id="camera" autoplay width="100%"></video>
                    </div>                
                    <div class="col-lg-4">
                        <button type="button" class="btn btn-success" id="take-photo">Ambil Gambar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>                
                </div>                
            </div>
        </div>
    </div>
</div>
<!-- AKHIR MODAL -->

@endsection

@section('body')
<script src="{{ asset('js/bootstrap-material-moment/moment.js') }}"></script>
<script src="{{ asset('js/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>
<script src="{{ asset('js/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/select2lib.js') }}"></script>
<script src="{{ asset('js/crud.js') }}"></script>
<script src="{{ asset('js/filemod.js') }}"></script>
<script src="{{ asset('js/img-viewer/viewer.min.js') }}"></script>

<script type="text/javascript">
    var vRuangan_id; 
    var vApi='/api/pinjam-ruangan';
    var vJudul='Validasi Peminjaman Ruangan';
    var fieldInit={
        'id': { action: 'val' },
        'no_hp': { action: 'val' },
        'biaya': { action: 'val' },
        'peminjam_nama': { action: 'val' },
        'peminjam_lembaga': { action: 'val' },
        'keterangan': { action: 'val' },
        'waktu_mulai': { action: 'val' },
        'waktu_selesai': { action: 'val' },
        'user_id': { action: 'val' },
        'ruangan_id': { action: 'val' },
        'verifikasi_catatan': { action: 'val' },
        'is_pengajuan': { action: 'select2' },
        'is_diterima': { action: 'select2' },
    };

    $(".user_id").val(vUserId);

    sel2_publish("#is_pengajuan","#modal-form  .modal-content");
    sel2_publish("#is_diterima","#modal-form  .modal-content");
    function inputPersetujuan(val){
        $("#input_is_diterima").hide();
        if(val==1){
            $("#input_is_diterima").show();
        }
    }
    $('#is_pengajuan').on("change", function(e) { 
        inputPersetujuan($(this).val());
    });    
    $("#input_is_diterima").hide();


    $('.datepicker').bootstrapMaterialDatePicker({
        weekStart: 0,
        format: 'YYYY-MM-DD',
        time: false,
    });


    //refresh
    function refresh(){
        CrudModule.refresh(displayData);
    }

    //pencarian data
    $('#search-data').on('input', function() {
        var keyword = $(this).val();
        if (keyword.length == 0 || keyword.length >= 3) {
            CrudModule.setKeyword(keyword);
            CrudModule.fRead(1, displayData);
        }
    });    

    //read showdata
    function displayData(response) {
        var data = response.data;
        var tableBody = $('#dataTableBody');
        var nomor = response.meta.from;
        tableBody.empty();
        if(data.length>0)
            $.each(data, function(index, dt) {
                var is_diterima;
                var menuweb;

                var labelApp=labelSetupVerifikasi(dt.is_pengajuan,dt.is_diterima,dt.verifikasi_catatan,dt.verifikator);
                var verifikasi=labelApp.catatan;

                menuweb=`<div class="btn-group" role="group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></button>
                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                <li><a class="dropdown-item" href="javascript:;" onclick="ganti(${dt.id})"><i class="bi bi-arrow-90deg-right"></i> Proses Peminjaman</a></li>
                                <li><a class="dropdown-item" href="javascript:;" ><i class="bi bi-file-earmark"></i> Selengkapnya</a></li>
                            </ul>
                        </div>`;
                        
                var uploads = `${labelApp.label}<div><a href="${dt.file_upload}" target="_blank">Surat Permohonan</a></div>${labelApp.catatan}`;
                var row = `
                    <tr>
                        <td>${nomor++}</td>
                        <td>
                            <span class="badge bg-secondary">${dt.ruangan.gedung.nama}</span>
                            <p>
                                ${dt.ruangan.nama}
                                <hr>
                                ${dt.keterangan}
                                <br>
                                <i>(${dt.peminjam_nama} / ${dt.peminjam_lembaga})</i>
                            </p>
                        </td>
                        <td align="center">
                            <span style="font-size:13px; font-style:italic">${dt.waktu_mulai} sd ${dt.waktu_selesai}</span>
                        </td>
                        <td>
                            ${uploads}
                        </td>
                        <td>                            
                            ${menuweb}                                              
                        </td>
                    </tr>
                `;
                tableBody.append(row);
            });
        else{
            var row = `
                    <tr>
                        <td colspan="5">Tidak ditemukan</td>
                    </tr>
                `;
                tableBody.append(row);            
        }
    }

    //ketika halaman paging di klik
    $(document).on('click','.page-link', function(e) {
        e.preventDefault();
        var page = $(this).data('page');
        CrudModule.fRead(page,displayData);
    });

    //untuk tampilkan modal aset 
    function showModalForm(){
        $('#myForm')[0].reset();
        $("#id").val("");
        // $('#data_aset_id').val("").trigger("change");
        // $('#user_id').val("").trigger("change");
        CrudModule.resetForm(fieldInit);
        let myModalForm = new bootstrap.Modal(document.getElementById('modal-form'), {
            backdrop: 'static',
            keyboard: false,
        });
        myModalForm.toggle();
    }

    // tambah data
    function tambah() {
        showModalForm();
        $('#modal-label').text('Tambah '+vJudul);
        $('#btn-simpan').text('Simpan');
    };

    // ganti dan populasi data
    function ganti(id) {
        CrudModule.fEdit(id, function(response) {
            if(response.success){
                showModalForm();
                var dt = response.data;
                //populasi data secara dinamis
                CrudModule.populateEditForm(dt,fieldInit);
                //ubah form 
                $('#modal-label').text(vJudul);
                $('#btn-simpan').text('Simpan');

            }
        });
    }

    //validasi form dan submit handler untuk simpan atau ganti
    $("#myForm").validate({
        submitHandler: function(form) {
            let setup_ajax={type:'POST',url:vApi};
            let id=$("#id").val();
            if (id !== "")
                setup_ajax={type:'PUT',url:vApi+'/'+id};
            simpan(setup_ajax,form)
        }
    });    

    //simpan baru atau simpan perubahan
    function simpan(setup_ajax,form) {
        let dataForm = $(form).serialize();
        CrudModule.fSave(setup_ajax, dataForm, function(response) {
            if (response.success) {
                refresh();
                $('#modal-form').modal('hide');


                // ----- pemberitahuan -----
                // pemberitahuan ke user hasil validasi dari admin
                var pesan='';
                var link='';
                if(response.data.is_pengajuan==0){
                    pesan='Pengajuan dikembalikan '+response.data.verifikasi_catatan;
                    link='pinjam-ruangan';
                }else{
                    if(response.data.is_diterima==0)
                        pesan='Pengajuan ditolak '+response.data.verifikasi_catatan
                    else
                        pesan='Pengajuan diterima '+response.data.verifikasi_catatan
                }
                var parameter={
                    'pk_id':response.data.id,
                    'user_id':response.data.user_id,
                    'judul':'Peminjaman Ruangan',
                    'link':link,
                    'pesan':pesan,
                };
                postPemberitahuan(parameter);
                //---------------- end pemberitahuan -----------------------                   
            } 
            appShowNotification(response.success,[response.message]);
        });
    }		    

    // hapus
    function hapus(id) {
        CrudModule.fDelete(id, function(response) {
            appShowNotification(response.success, [response.message]);
            if (response.success) {
                refresh();
            }
        });
    }

    function loadDataMasuk(page = 1) {
        CrudModule.setFilter('masuk')
        CrudModule.fRead(page, displayData);
    }

    function loadDataDisetujui(page = 1) {
        CrudModule.setFilter('disetujui')
        CrudModule.fRead(page, displayData);
    }

    function loadDataDitolak(page = 1) {
        CrudModule.setFilter('ditolak')
        CrudModule.fRead(page, displayData);
    }


    $(document).ready(function() {
        CrudModule.setApi(vApi);
        loadDataMasuk();
    });

</script>
@endsection