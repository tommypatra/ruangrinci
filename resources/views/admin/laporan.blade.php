@extends('admin.template')

@section('head')
<title>Pengajuan Laporan</title>
<link href="{{ asset('js/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet">
<link href="{{ asset('js/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('js/select2/dist/css/select2.custom.css') }}" rel="stylesheet">
<link href="{{ asset('js/img-viewer/viewer.min.css') }}" rel="stylesheet">
@endsection

@section('pageTitle')
<div class="pagetitle">
    <h1>Pengajuan Laporan</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('akun-dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Pengajuan Laporan</li>
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
                <h5 class="card-title">Pengajuan <span>| Laporan</span></h5>
                
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
                                <th style="width:15%">Tanggal</th>
                                <th style="width:50%">Barang/Keterangan/pengguna</th>
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
            <input type="hidden" name="data_aset_id" id="data_aset_id" >
            <input type="hidden" name="user_id" class="user_id" >
            <input type="hidden" name="verifikator" value="{{ auth()->user()->name }}" >
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
    var vApi='/api/laporan';
    var vJudul='Laporan';
    var fieldInit={
        'id': { action: 'val' },
        'verifikasi_catatan': { action: 'val' },
        'data_aset_id': { action: 'val' },
        'is_pengajuan': { action: 'select2' },
        'is_diterima': { action: 'select2' },
    };

    $(".user_id").val(vUserId);

    sel2_publish("#is_pengajuan","#modal-form  .modal-content");
    
    function inputPersetujuan(val){
        $("#input_is_diterima").hide();
        if(val==1){
            $("#input_is_diterima").show();
        }
    }

    $('#is_pengajuan').on("change", function(e) { 
        inputPersetujuan($(this).val());
    });    

    sel2_publish("#is_diterima","#modal-form  .modal-content");
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
                var verifikasi_catatan=labelApp.catatan;
                var is_diterima=labelApp.label;

                menuweb=`<div class="btn-group" role="group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></button>
                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                <li><a class="dropdown-item" href="javascript:;" onclick="ganti(${dt.id})"><i class="bi bi-arrow-90deg-right"></i> Proses Laporan</a></li>
                                <li><a class="dropdown-item" href="javascript:;" ><i class="bi bi-file-earmark"></i> Selengkapnya</a></li>
                            </ul>
                        </div>`;
                
            
                var uploads=is_diterima;
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
                var row = `
                    <tr>
                        <td>${nomor++}</td>
                        <td align="center">
                            <span style="font-style:italic">${dt.created_at}</span>
                            <div>
                                <img src="${dt.qrcode}" alt="QRCode">
                                <div style="font-size:10px">${dt.kode}</div>
                            </div>
                        </td>
                        <td>
                            <span style="font-style:italic">${dt.data_aset.jenis_aset.nama}</span> 
                            <p>
                                ${dt.data_aset.nama}
                                <hr>
                                ${dt.keterangan}
                                <br>
                                (${dt.user.name})
                                ${verifikasi_catatan}
                            </p>
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
                $('#modal-label').text('Ganti '+vJudul);
                $('#btn-simpan').text('Ubah Sekarang');

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

                // ----- pemberitahuan -----
                // pemberitahuan ke user hasil validasi dari admin
                var pesan='';
                var link='';
                if(response.data.is_pengajuan==0){
                    pesan='Pengajuan dikembalikan '+response.data.verifikasi_catatan;
                    link='pengajuan-laporan';
                }else{
                    if(response.data.is_diterima==0)
                        pesan='Pengajuan ditolak '+response.data.verifikasi_catatan
                    else
                        pesan='Pengajuan diterima '+response.data.verifikasi_catatan
                }
                var parameter={
                    'pk_id':response.data.id,
                    'user_id':response.data.user_id,
                    'judul':'Laporan Kerusakan',
                    'link':link,
                    'pesan':pesan,
                };
                postPemberitahuan(parameter);
                //---------------- end pemberitahuan -----------------------

                refresh();
                $('#modal-form').modal('hide');
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

    // pengajuan laporan
    function ajukan(id){
        const formData = new FormData();
        formData.append("id", id);
        formData.append("is_diterima", true);
        // console.log('uploadFile '+idFk);
        if(confirm('apakah anda yakin?'))
            $.ajax({
                url: 'api/laporan-ajukan',
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.success) {
                        loadDataMasuk();
                        appShowNotification(response.success,[response.message]);
                    } else {
                        appShowNotification(false, ["Failed to upload attachment."]);
                    }
                },
                error: function (xhr, status, error) {
                    appShowNotification(false, ["Something went wrong. Please try again later."]);
                }
            });        
    }

    // ------------------------ preview gambar
    var image = new Image();
    $(document).on('click','.imgprev',function() {
        image.src = $(this).data('url');
        var viewer = new Viewer(image, {
            toolbar: {
                zoomIn: 4,
                zoomOut: 4,
                oneToOne: 4,
                reset: 4,
                prev: 0,
                play: {
                    show: 0,
                    size: 'large',
                },
                next: 0,
                rotateLeft: 4,
                rotateRight: 4,
                flipHorizontal: 4,
                flipVertical: 4,
            },            
            hidden: function() {
                viewer.destroy();
            },
        });        
        viewer.show();
    });    

    $(document).on('click','.uploadLampiran',function(){
        var laporan_id=$(this).data('laporan_id');
        fileModule.upload(laporan_id);        
    });

    function foto(id){
        let myModalUpload = new bootstrap.Modal(document.getElementById('modal-upload'), {
            backdrop: 'static',
            keyboard: false,
        });
        myModalUpload.toggle();
        fileModule.activateCamera(id);
    }

    $('#modal-upload').on('hidden.bs.modal', function () {
        fileModule.stopCamera();
    });

    function hapusUploadLaporan(id,upload_id){
        fileModule.deleteLink(id,upload_id);
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
        fileModule.init("/api/upload-laporan", "laporan_id", vUserId);
        // Load data default
        loadDataMasuk();
    });

</script>
@endsection