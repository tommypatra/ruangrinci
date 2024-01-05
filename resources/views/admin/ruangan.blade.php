@extends('admin.template')

@section('head')
<title>Ruangan</title>
<link href="{{ asset('js/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('js/select2/dist/css/select2.custom.css') }}" rel="stylesheet">
@endsection

@section('pageTitle')
<div class="pagetitle">
    <h1>Ruangan</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('akun-dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Ruangan</li>
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
                <h5 class="card-title">Ruangan</h5>
                <div class="table-responsive">
                    <table class="table" >
                        <thead>
                            <tr>
                                <th>No</th>
                                <th style="width:35%">Gedung/Nama Ruangan</th>
                                <th style="width:10%">Luas</th>
                                <th style="width:10%">Kapasitas</th>
                                <th style="width:10%">Lantai</th>
                                <th style="width:10%">Jumlah Barang</th>
                                <th style="width:25%">Deskripsi</th>
                                <th style="width:10%">Aktif</th>
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
            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-label">Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <div class="row">
						<div class="col-lg-12 mb-3">
                            <label class="form-label">Gedung</label>
                            <select name="gedung_id" id="gedung_id" class="form-control" required></select>
                        </div>

						<div class="col-lg-8 mb-3">
                            <label class="form-label">Nama Ruangan</label>
                            <input name="nama" id="nama" type="text" class="form-control" required>
                        </div>

						<div class="col-lg-4 mb-3">
                            <label class="form-label">Luas</label>
                            <input name="luas" id="luas" type="text" class="form-control" required>
                        </div>
						<div class="col-lg-4 mb-3">
                            <label class="form-label">Kapasitas</label>
                            <input name="kapasitas" id="kapasitas" type="number" class="form-control" required>
                        </div>
						<div class="col-lg-4 mb-3">
                            <label class="form-label">Lantai</label>
                            <input name="lantai" id="lantai" type="number" class="form-control" required>
                        </div>

                        <div class="col-lg-12 mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea rows="4" name="deskripsi" id="deskripsi" type="text" class="form-control"></textarea>
                        </div>
						<div class="col-lg-6 mb-3">
                            <label class="form-label">Aktif</label>
                            <select name="is_aktif" id="is_aktif" class="form-control" required></select>
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
<div class="modal fade modal" id="modal-aset-ruangan" role="dialog">
    <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-label">Barang Ruangan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <form id="formAsetRuangan">
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
<script src="{{ asset('js/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/select2lib.js') }}"></script>
<script src="{{ asset('js/crud.js') }}"></script>

<script type="text/javascript">
    var vRuangan_id; 
    var vApi='/api/ruangan';
    var vJudul='Ruangan';
    var fieldInit={
        'id': { action: 'val' },
        'nama': { action: 'val' },
        'deskripsi': { action: 'val' },
        'luas': { action: 'val' },
        'kapasitas': { action: 'val' },
        'lantai': { action: 'val' },
        'gedung_id': { action: 'select2' },
        'is_aktif': { action: 'select2' },
    };
    sel2_publish("#is_aktif","#myForm .modal-content");

    initGedung();
    function initGedung(){
        $.ajax({
            url: '/api/gedung?per_page=all&filter={"is_aktif":1}',
            method: 'GET',
            dataType: 'json',
            success: function (response){
                let vdata=[];
                vdata.push({id:'',text:'-pilih-'});
                if(response.data.length>0){
                    $.each(response.data, function(index, dt) {
                        vdata.push(
                            {
                                id:dt.id,
                                text:dt.nama,
                            }
                        );
                    });
                }
                sel2_datalokal('#gedung_id',vdata,false,'#myForm .modal-content');
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }    

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
                var row = `
                    <tr>
                        <td>${nomor++}</td>
                        <td><span class="badge bg-primary">${dt.gedung.nama}</span><p>${dt.nama}</p></td>
                        <td>${dt.luas} m2</td>
                        <td>${dt.kapasitas} orang</td>
                        <td>${dt.lantai}</td>
                        <td>${dt.jumlah_aset} buah</td>
                        <td>${dt.deskripsi}</td>
                        <td>${lblaktif}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></button>
                                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                    <li><a class="dropdown-item" href="javascript:;" onclick="aset(${dt.id})"><i class="bi bi-collection"></i> Aset Ruangan</a></li>
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
        messages: {
            is_aktif: "pilihan status tidak boleh kosong",
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

    // --------------------- PENGELOLAAN ASET RUANGAN -----------------

    // untuk aset ruangan, set id vRuangan_id dan tampilkan modal
    function aset(id) {
        vRuangan_id=id;
        showModalAset();
    }

    //untuk tampilkan modal 
    function showModalAset(){
        $('#formAsetRuangan')[0].reset();
        $('#data_aset_id').val("").trigger("change");
        CrudModule.resetForm(fieldInit);
        let myModalForm = new bootstrap.Modal(document.getElementById('modal-aset-ruangan'), {
            backdrop: 'static',
            keyboard: false,
        });
        myModalForm.toggle();
        loadDataAset();
    }

    $("#data_aset_id").select2({
        dropdownParent: $("#modal-aset-ruangan  .modal-content"),
        minimumInputLength: 3,
        cache: true,
        placeholder: 'cari data aset',
        ajax: {
            url: vBaseUrl+'/api/asetBelumTerdistribusi',
            data: function (params) {
                var queryParameters = {
                    // ruang_id: vRuangan_id,
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
                // console.log(dataResults);       
                return {
                    results: dataResults
                };            
            }
        }
    });

    
    function loadDataAset(){
        $.ajax({
            url: '/api/aset-ruangan?per_page=all&filter={"ruangan_id":'+vRuangan_id+'}',
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
                url: '/api/aset-ruangan/'+id,
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
    $("#formAsetRuangan").validate({
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
            // console.log('user_id : ' + user_id +' ruangan_id : '+vRuangan_id);
            let promises = [];
            $.each(dataAset, function(index, value) {
                let dataForm={
                    'user_id':user_id,
                    'data_aset_id':value,
                    'ruangan_id':vRuangan_id,
                };
                let promise = $.ajax({
                    url: '/api/aset-ruangan',
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
        // Load data default
        loadData();
        function loadData(page = 1) {
            CrudModule.fRead(page, displayData);
        }
    });

</script>
@endsection