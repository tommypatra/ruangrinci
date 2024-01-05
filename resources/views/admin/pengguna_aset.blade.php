@extends('admin.template')

@section('head')
<title>Pengguna Barang</title>
<link href="{{ asset('js/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet">
<link href="{{ asset('js/select2/dist/css/select2.min.css') }}" rel="stylesheet">
{{-- <link href="{{ asset('js/select2/dist/css/select2.custom.css') }}" rel="stylesheet"> --}}
@endsection

@section('pageTitle')
<div class="pagetitle">
    <h1>Pengguna Barang</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('akun-dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Pengguna Barang</li>
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
                <h5 class="card-title">Pengguna <span>| Barang</span></h5>
                <div class="table-responsive">
                    <table class="table" >
                        <thead>
                            <tr>
                                <th>No</th>
                                <th style="width:15%">Tanggal</th>
                                <th style="width:25%">Barang</th>
                                <th style="width:20%">Pengguna</th>
                                <th style="width:20%">Pengembalian</th>
                                <th style="width:15%">Keterangan</th>
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
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-label">Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <div class="row">
						<div class="col-lg-4 mb-3">
                            <label class="form-label">Tanggal</label>
                            <input name="tgl_masuk" id="tgl_masuk" type="text" class="form-control datepicker" required>
                        </div>
						<div class="col-lg-8 mb-3">
                            <label class="form-label">Pengguna</label>
                            <select name="user_id" id="user_id" class="form-control" required></select>
                        </div>

						<div class="col-lg-12 mb-3">
                            <label class="form-label">Barang</label>
                            <select name="data_aset_id" id="data_aset_id" class="form-control" required></select>
                        </div>

                        <div class="col-lg-12 mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea rows="4" name="keterangan" id="keterangan" type="text" class="form-control"></textarea>
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

<!-- MULAI MODAL -->
<div class="modal fade modal" id="modal-pengembalian-aset" role="dialog">
    <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-label">Pengembalian Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formPengembalianAset">
                    <input type="hidden" name="pengguna_aset_id" id="pengguna_aset_id" >
                    <input type="hidden" name="id" id="id" >
                    <div class="modal-body ">
                        <div class="row">
                            <div class="col-lg-4 mb-3">
                                <label class="form-label">Tanggal</label>
                                <input name="tgl_kembali" id="tgl_kembali" type="text" class="form-control datepicker" required>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <label class="form-label">Kondisi</label>
                                <select name="kondisi" id="kondisi" class="form-control" required></select>
                            </div>
                            <div class="col-lg-12 mb-3">
                                <label class="form-label">Keterangan</label>
                                <textarea rows="4" name="keterangan" id="keterangan" type="text" class="form-control"></textarea>
                            </div>
        
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="btn-simpan">Simpan</button>
                        <button type="button" class="btn btn-outline-primary " data-bs-dismiss="modal">Tutup</button>
                    </div>
                </form>
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

<script type="text/javascript">
    var vRuangan_id; 
    var vApi='/api/pengguna-aset';
    var vJudul='Pengguna Aset';
    var fieldInit={
        'id': { action: 'val' },
        'tgl_masuk': { action: 'val' },
        'nama': { action: 'val' },
        'keterangan': { action: 'val' },
        'user_id': { action: 'select2' },
        'data_aset_id': { action: 'select2' },
    };

    $("#data_aset_id").select2({
        dropdownParent: $("#modal-form  .modal-content"),
        minimumInputLength: 3,
        cache: true,
        placeholder: 'cari data aset',        
        ajax: {
            url: vBaseUrl+'/api/data-aset',
            data: function (params) {
                var queryParameters = {
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

    $("#user_id").select2({
        dropdownParent: $("#modal-form  .modal-content"),
        minimumInputLength: 3,
        cache: true,
        placeholder: 'cari data pengguna',
        ajax: {
            url: vBaseUrl+'/api/pengguna',
            data: function (params) {
                var queryParameters = {
                    keyword: params.term,
                }
                return queryParameters;
            },            
            processResults: function (respon) {
                var dataResults = respon.data.map(function (item) {
                    return {
                        id: item.id,
                        text: item.name
                    };
                });         
                // console.log(dataResults);       
                return {
                    results: dataResults
                };            
            }
        }
    });            

    $('.datepicker').bootstrapMaterialDatePicker({
        weekStart: 0,
        format: 'YYYY-MM-DD HH:mm:ss',
        // time: false,
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
                var lblaktif=(!dt.is_aktif)?`<span class="badge bg-danger">Tidak Aktif</span>`:`<span class="badge bg-success">Aktif</span>`;
                var dataSerahTerima="";
                if(dt.serah_terima_aset.length>0){
                    let vkondisi=dt.serah_terima_aset[0].kondisi.toUpperCase();
                    let vclr1='primary';
                    if(vkondisi!='BAIK')
                        vclr1='danger';    
                    dataSerahTerima=`<span class="badge bg-${vclr1}">${vkondisi}</span> <p style="font-style:italic">${dt.serah_terima_aset[0].tgl_kembali}</p>`;
                }
                var row = `
                    <tr>
                        <td>${nomor++}</td>
                        <td>${dt.tgl_masuk}</td>
                        <td><span style="font-style:italic">${dt.data_aset.jenis_aset.nama}</span> <p>${dt.data_aset.nama}</p></td>
                        <td>${dt.user.name} <p style="font-style:italic">${dt.user.email}</p></td>
                        <td>${dataSerahTerima}</p></td>
                        <td>${dt.keterangan}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></button>
                                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                    <li><a class="dropdown-item" href="javascript:;" onclick="pengembalian(${dt.id})"><i class="bi bi-arrow-bar-left"></i> Pengembalian</a></li>
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


                //untuk select2 pakai ajax
                if(dt.user_id){                    
                    let option_add = new Option(dt.user.name, dt.user.id, true, true);
                    $("#user_id").append(option_add).trigger('change');
                }                    

                if(dt.data_aset_id){                    
                    option_add = new Option(dt.data_aset.nama, dt.data_aset.id, true, true);
                    $("#data_aset_id").append(option_add).trigger('change');
                }                    
                //akhir select2 pakai ajax



            }
        });
    }

    //validasi form dan submit handler untuk simpan atau ganti
    $("#myForm").validate({
        messages: {
            tgl_masuk: "tidak boleh kosong",
            user_id: "harus cari dan pilih",
            data_aset_id: "harus cari dan pilih",
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

    // --------------------- PENGELOLAAN PENGEMBALIAN ASET -----------------

    sel2_kondisi("#kondisi","#modal-pengembalian-aset .modal-content");

    function pengembalian(id){
        resetFormPengembalian()
        showModalPengembalian(id);
        dataPengembalian(id);
    } 

    function resetFormPengembalian(){
        let formPengembalian = $("#formPengembalianAset");
        formPengembalian.find("#id").val("");
        formPengembalian.find("#tgl_kembali").val("");
        formPengembalian.find("#kondisi").val("").trigger("change");        
    }

    function dataPengembalian(id){
        let formPengembalian = $("#formPengembalianAset");                
        formPengembalian.find("#pengguna_aset_id").val(id);
        $.ajax({
            url: '/api/serah-terima-aset?per_page=all&filter={"pengguna_aset_id":'+id+'}',
            method: 'GET',
            dataType: 'json',
            success: function (response){
                if(response.data.length>0){
                    let tmp=response.data[0];
                    formPengembalian.find("#id").val(tmp.id);
                    formPengembalian.find("#tgl_kembali").val(tmp.tgl_kembali);
                    formPengembalian.find("#keterangan").val(tmp.keterangan);
                    formPengembalian.find("#kondisi").val(tmp.kondisi).trigger("change");        
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    function showModalPengembalian(id){
        $('#formPengembalianAset')[0].reset();
        let myModalForm = new bootstrap.Modal(document.getElementById('modal-pengembalian-aset'), {
            backdrop: 'static',
            keyboard: false,
        });
        myModalForm.toggle();
    }

    //validasi form dan submit handler untuk simpan atau ganti
    $("#formPengembalianAset").validate({
        messages: {
            tgl_kembali: "tidak boleh kosong",
            kondisi: "pilih salah satu",
        },
        submitHandler: function() {
            event.preventDefault();
            simpanPengembalianAset()
        }
    });    

    //simpan baru aset ruangan
    function simpanPengembalianAset() {
        let user_id = {{ auth()->user()->id }};
        let formData = $("#formPengembalianAset").serialize();
        let id=$("#formPengembalianAset").find("#id").val();

        //untuk url ganti atau tambah
        let setup_ajax={type:'POST',url:vBaseUrl+'/api/serah-terima-aset'};
        if (id !== "")
            setup_ajax={type:'PUT',url:vBaseUrl+'/api/serah-terima-aset/'+id};

        $.ajax({
            url: setup_ajax.url,
            method: setup_ajax.type,
            dataType: 'json',
            data:formData,
            success: function (response){
                appShowNotification(response.success,[response.message]);
                refresh();
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
        
    }	       

    $(document).ready(function() {
        CrudModule.setApi(vApi);
        // Load data default
        loadData();
        function loadData(page = 1) {
            CrudModule.fRead(page, displayData);
        }

    });

</script>
@endsection