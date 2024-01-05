@extends('admin.template')

@section('head')
<title>Perawatan</title>
<link href="{{ asset('js/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet">
<link href="{{ asset('js/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('js/select2/dist/css/select2.custom.css') }}" rel="stylesheet">
<link href="{{ asset('js/img-viewer/viewer.min.css') }}" rel="stylesheet">
@endsection

@section('pageTitle')
<div class="pagetitle">
    <h1>Perawatan</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('akun-dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Perawatan</li>
        </ol>
    </nav>
</div><!-- End Page Title -->
@endsection


@section('container')
<div class="col-lg-12">
    <div class="row">
        <div class="card info-card customers-card">
            <div class="filter">
                <a class="icon" href="javascript:;" onclick="tambah()"><i class="bi bi-plus-circle"></i></a>
                <a class="icon" href="javascript:;" onclick="refresh()"><i class="bi bi-arrow-clockwise"></i></a>
                <a class="icon" href="javascript:;" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                        <h6>Filter</h6>
                    </li>
                </ul>
            </div>

            <div class="card-body">
                <h5 class="card-title">Perawatan <span>| Barang</span></h5>
                <div class="table-responsive">
                    <table class="table" >
                        <thead>
                            <tr>
                                <th>No</th>
                                <th style="width:15%">Waktu Masuk</th>
                                <th style="width:15%">Waktu Selesai</th>
                                <th style="width:15%">Toko/ Perusahaan</th>
                                <th style="width:50%">Barang</th>
                                <th style="width:25%">Lampiran</th>
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
            <input type="hidden" name="user_id" class="user_id" >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-label">Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <div class="row">
						<div class="col-lg-8 mb-3">
                            <label class="form-label">Kode Laporan</label>
                            <select name="laporan_id" id="laporan_id" class="form-control"></select>
                        </div>
						<div class="col-lg-12 mb-3">
                            <label class="form-label">Toko/ Perusahaan</label>
                            <input type="text" name="tempat" id="tempat" class="form-control" required>
                        </div>

						<div class="col-lg-4 mb-3">
                            <label class="form-label">Tanggal Masuk</label>
                            <input type="text" name="tgl_masuk" id="tgl_masuk" class="form-control datepicker" required>
                        </div>
						
                        <div class="col-lg-4 mb-3">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="text" name="tgl_selesai" id="tgl_selesai" class="form-control datepicker">
                        </div>

                        <div class="col-lg-12 mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea rows="4" name="keterangan" id="keterangan" type="text" class="form-control" required></textarea>
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

<!-- MULAI MODAL -->
<div class="modal fade modal" id="modal-aset-perawatan" role="dialog">
    <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-label">Perawatan Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <form id="formAsetPerawatan">
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <label class="form-label">Ketik dan Pilih Barang</label>
                                <select id="data_aset_id" class="form-control" multiple="multiple" name="data_aset_id[]" required></select>
                            </div>
                            <div class="col-lg-12 mb-3">
                                <button type="submit" class="btn btn-primary" id="btn-simpan">Simpan</button>
                            </div>
                        </div>
                    </form>


                    <h5 class="card-title">Daftar Barang</h5>
                    <div class="table-responsive">
                        <table class="table" >
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th style="width:10%">Jenis</th>
                                    <th style="width:10%">Kode</th>
                                    <th style="width:60%">Nama</th>
                                    <th style="width:10%">Kondisi</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="dataTableBodyAset">
                                <!-- Data will be dynamically populated here -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary " data-bs-dismiss="modal">Tutup</button>
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
    var vPerawatan_id; 
    var vApi='/api/perawatan';
    var vJudul='Perawatan';
    var fieldInit={
        'id': { action: 'val' },
        'tgl_masuk': { action: 'val' },
        'tgl_keluar': { action: 'val' },
        'tempat': { action: 'val' },
        'keterangan': { action: 'val' },
        'perawatan_id': { action: 'select2' },
    };
    $(".user_id").val(vUserId);

    $("#perawatan_id").select2({
        dropdownParent: $("#modal-form  .modal-content"),
        minimumInputLength: 3,
        cache: true,
        placeholder: 'cari laporan',        
        ajax: {
            url: vBaseUrl+'/api/laporan',
            data: function (params) {
                var queryParameters = {
                    page: 'all',
                    keyword: params.term,
                }
                return queryParameters;
            },            
            processResults: function (respon) {
                var dataResults = respon.data.map(function (item) {
                    return {
                        id: item.id,
                        text: item.nama
                    };
                });
                return {
                    results: dataResults
                };            
            },
            
        }
    });

    $('.datepicker').bootstrapMaterialDatePicker({
        weekStart: 0,
        format: 'YYYY-MM-DD HH:mm:ss',
        time: true,
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

                
                var labelApp=labelSetupVerifikasi(dt.is_disetujui,dt.catatan_verifikasi,dt.verifikator);
                var catatan_verifikasi=labelApp.catatan;
                var is_disetujui=labelApp.label;

                var uploads='';
                if(dt.upload_perawatan.length>0){
                    uploads="<ul>";
                    $.each(dt.upload_perawatan, function(index, dt) {
                        if(is_image(dt.upload.type))
                            uploads +=`<li><span class="fa-li"><i class="fa-solid fa-arrow-up-right-from-square"></i></span><a href="javascript:;" data-url="${dt.upload.path}" class="imgprev" target="_self">${dt.upload.name}</a> <a href="javascript:;" onclick="hapusUploadLaporan(${dt.id},${dt.upload_id})"><i class="bi bi-trash"></i></a></li>`;
                        else
                            uploads +=`<li><span class="fa-li"><i class="fa-solid fa-arrow-up-right-from-square"></i></span><a href="${dt.upload.path}" target="_blank">${dt.upload.name}</a> <a href="javascript:;" onclick="hapusUploadLaporan(${dt.id},${dt.upload_id})"><i class="bi bi-trash"></i></a></li>`;
                    });
                    uploads+="<ul>";
                }

                var rincians='';
                if(dt.rincian_perawatan.length>0){
                    rincians="<ul>";
                    $.each(dt.rincian_perawatan, function(index, dt) {
                        rincians +=`<li><span class="fa-li"><i class="fa-solid fa-arrow-up-right-from-square"></i> ${dt.data_aset.nama} </li>`;
                    });
                    rincians+="<ul>";
                }
                var tgl_selesai=(dt.tgl_selesai)?dt.tgl_selesai:"";
                var row = `
                    <tr>
                        <td>${nomor++}</td>
                        <td><span style="font-style:italic">${dt.tgl_masuk}</span></td>
                        <td><span style="font-style:italic">${tgl_selesai}</span></td>
                        <td>${dt.tempat}</td>
                        <td>${rincians}</td>
                        <td>
                            <div class="btn-group-sm">
                                <a href="javascript:;" class="btn btn-primary uploadLampiran" data-perawatan_id="${dt.id}"><i class="bi bi-upload"></i></a>
                                <a href="javascript:;" class="btn btn-primary fotoLampiran" onclick="foto(${dt.id})"><i class="bi bi-camera"></i></a>
                            </div>                            
                            ${uploads}
                        </td>
                        <td>          
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></button>
                                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                    <li><a class="dropdown-item" href="javascript:;" onclick="aset(${dt.id})"><i class="bi bi-collection"></i> Rincian Aset</a></li>
                                    <li><a class="dropdown-item" href="javascript:;" onclick="ganti(${dt.id})"><i class="bi bi-pencil-square"></i> Ganti</a></li>
                                    <li><a class="dropdown-item" href="javascript:;" onclick="hapus(${dt.id})"><i class="bi bi-trash"></i> Hapus</a></li>
                                </ul>
                            </div>                 
                        </td>
                    </tr>
                `;
                tableBody.append(row);
            });
        else{
            var row = `
                    <tr>
                        <td colspan="7">Tidak ditemukan</td>
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

                //untuk select2 pakai ajax
                // if(dt.data_aset_id){                    
                //     let option_add = new Option(dt.data_aset.nama, dt.data_aset.id, true, true);
                //     $("#data_aset_id").append(option_add).trigger('change');
                // }                    

            }
        });
    }

    //validasi form dan submit handler untuk simpan atau ganti
    $("#myForm").validate({
        messages: {
            data_aset_id: "harus cari dan pilih",
            keterangan: "tidak boleh kosong",
        },
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
        formData.append("is_pengajuan", true);
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
                        loadData();
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
        var perawatan_id=$(this).data('perawatan_id');
        fileModule.upload(perawatan_id);        
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

    function loadData(page = 1) {
        CrudModule.fRead(page, displayData);
    }

    // --------------------- PENGELOLAAN ASET RUANGAN -----------------

    // untuk aset ruangan, set id vPerawatan_id dan tampilkan modal
    function aset(id) {
        vPerawatan_id=id;
        showModalAset();
    }

    //untuk tampilkan modal 
    function showModalAset(){
        $('#formAsetPerawatan')[0].reset();
        $('#data_aset_id').val("").trigger("change");
        CrudModule.resetForm(fieldInit);
        let myModalForm = new bootstrap.Modal(document.getElementById('modal-aset-perawatan'), {
            backdrop: 'static',
            keyboard: false,
        });
        myModalForm.toggle();
        loadDataAset();
    }

    $("#data_aset_id").select2({
        dropdownParent: $("#modal-aset-perawatan  .modal-content"),
        minimumInputLength: 3,
        cache: true,
        placeholder: 'cari data aset',
        ajax: {
            url: vBaseUrl+'/api/data-aset',
            data: function (params) {
                var queryParameters = {
                    page: 'all',
                    keyword: params.term,
                }
                return queryParameters;
            },            
            processResults: function (respon) {
                var dataResults = respon.data.map(function (item) {
                    return {
                        id: item.id,
                        text: item.nama
                    };
                });
                return {
                    results: dataResults
                };            
            }
        }
    });
    
    function loadDataAset(){
        $.ajax({
            url: '/api/rincian-perawatan?per_page=all&filter={"perawatan_id":'+vPerawatan_id+'}',
            method: 'GET',
            dataType: 'json',
            success: function (response){
                displayDataAset(response);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }    

    //read showdata aset
    function displayDataAset(response) {
        var data = response.data;
        var tableBody = $('#dataTableBodyAset');
        tableBody.empty();
        // console.log(response);
        if(data.length>0)
            $.each(data, function(index, dt) {
                var row = `
                    <tr>
                        <td>${index+1}</td>
                        <td>${dt.data_aset.jenis_aset.nama}</td>
                        <td>${dt.data_aset.kode_barang}</td>
                        <td>${dt.data_aset.nama}</td>
                        <td>${dt.data_aset.kondisi}</td>
                        <td>
                            <a class="dropdown-item" href="javascript:;" onclick="hapusAsetRuangan(${dt.id})"><i class="bi bi-trash"></i></i></a>
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

    function hapusAsetRuangan(id){
        if(confirm("apakah anda yakin?")){
            $.ajax({
                url: '/api/rincian-perawatan/'+id,
                method: 'DELETE',
                dataType: 'json',
                success: function (response){
                    loadDataAset();
                    refresh();
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });            
        }
    }

    //validasi form dan submit handler untuk simpan atau ganti
    $("#formAsetPerawatan").validate({
        messages: {
            data_aset_id: "tidak boleh kosong",
        },
        submitHandler: function() {
            event.preventDefault();
            simpanAsetRuangan()
        }
    });    

    //simpan baru aset ruangan
    function simpanAsetRuangan() {
        let user_id = {{ auth()->user()->id }};
        let dataAset = $("#data_aset_id").val();
        if (dataAset) {
            // console.log('user_id : ' + user_id +' perawatan_id : '+vPerawatan_id);
            let promises = [];
            $.each(dataAset, function(index, value) {
                let dataForm={
                    'user_id':user_id,
                    'data_aset_id':value,
                    'perawatan_id':vPerawatan_id,
                };
                let promise = $.ajax({
                    url: '/api/rincian-perawatan',
                    method: 'post',
                    data: dataForm,
                    dataType: 'json'
                });
                promises.push(promise);                
            });
            Promise.all(promises)
                .then(function(responses) {
                    $('#data_aset_id').val("").trigger("change");
                    loadDataAset();
                    refresh();
                    appShowNotification(true, ['Simpan data selesai dilakukan']);
                })
                .catch(function(error) {
                    console.error(error);
                    appShowNotification(false, ['Terjadi kesalahan saat menyimpan data']);
                });
        }
    }	       

    // ------------- document ready ---------------

    $(document).ready(function() {
        CrudModule.setApi(vApi);
        fileModule.init("/api/upload-perawatan", "perawatan_id", vUserId);
        // Load data default
        loadData();
    });

</script>
@endsection