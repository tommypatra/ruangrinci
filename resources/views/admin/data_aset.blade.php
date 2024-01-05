@extends('admin.template')

@section('head')
<title>Data Barang</title>
<link href="{{ asset('js/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet">
<link href="{{ asset('js/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('js/select2/dist/css/select2.custom.css') }}" rel="stylesheet">
@endsection

@section('pageTitle')
<div class="pagetitle">
    <h1>Data Barang</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('akun-dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Data Barang</li>
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
                <h5 class="card-title">Data <span>| Barang</span></h5>
                <div class="table-responsive">
                    <table class="table" >
                        <thead>
                            <tr>
                                <th>No</th>
                                <th style="width:35%">Jenis/ Nama/ Kondisi</th>
                                <th style="width:15%">Kode Barang/ NUP</th>
                                <th style="width:15%">Tanggal Masuk</th>
                                <th style="width:25%">Deskripsi</th>
                                <th style="width:25%">Barang</th>
                                <th style="width:25%">Sudah Dilabel</th>
                                <th style="width:25%">Bisa Dipinjam</th>
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
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MULAI MODAL -->
<div class="modal fade modal" id="modal-form" role="dialog">
    <div class="modal-dialog modal-lg">
        <form id="myForm">
            <input type="hidden" name="id" id="id" >
            <input type="hidden" name="user_id" id="user_id" value="{{ auth()->user()->id }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-label">Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <div class="row">
						<div class="col-lg-8 mb-3">
                            <label class="form-label">Jenis Barang</label>
                            <select name="jenis_aset_id" id="jenis_aset_id" class="form-control" required></select>
                        </div>

                        <div class="col-lg-4 mb-3">
                            <label class="form-label">Tahun Perolehan</label>
                            <input name="tgl_masuk" id="tgl_masuk" value="<?=date('Y-m-d')?>" type="text" class="form-control datepicker" required>
                        </div>


						<div class="col-lg-12 mb-3">
                            <label class="form-label">Nama</label>
                            <input name="nama" id="nama" type="text" class="form-control" required>
                        </div>

						<div class="col-lg-4 mb-3">
                            <label class="form-label">Kode Barang</label>
                            <input name="kode_barang" id="kode_barang" type="text" class="form-control" >
                        </div>

						<div class="col-lg-4 mb-3">
                            <label class="form-label">NUP</label>
                            <input name="nup" id="nup" type="text" class="form-control" >
                        </div>

                        <div class="col-lg-4 mb-3">
                            <label class="form-label">Kondisi</label>
                            <select name="kondisi" id="kondisi" class="form-control" required></select>
                        </div>

                        <div class="col-lg-12 mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea rows="4" name="deskripsi" id="deskripsi" type="text" class="form-control"></textarea>
                        </div>
						<div class="col-lg-3 mb-3">
                            <label class="form-label">Termasuk Aset</label>
                            <select name="is_aset" id="is_aset" class="form-control" required></select>
                        </div>
						<div class="col-lg-3 mb-3">
                            <label class="form-label">Sudah dilabel</label>
                            <select name="status_label" id="status_label" class="form-control" required></select>
                        </div>
						<div class="col-lg-3 mb-3">
                            <label class="form-label">Bisa Dipinjam</label>
                            <select name="bisa_dipinjam" id="bisa_dipinjam" class="form-control" required></select>
                        </div>
						<div class="col-lg-3 mb-3">
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

@endsection

@section('body')
<script src="{{ asset('js/bootstrap-material-moment/moment.js') }}"></script>
<script src="{{ asset('js/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>
<script src="{{ asset('js/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/select2lib.js') }}"></script>
<script src="{{ asset('js/crud.js') }}"></script>

<script type="text/javascript">
    var vApi='/api/data-aset';
    var vJudul='Data Aset';
    var fieldInit={
        'id': { action: 'val' },
        'nama': { action: 'val' },
        'kode_barang': { action: 'val' },
        'nup': { action: 'val' },
        'deskripsi': { action: 'val' },
        'tgl_masuk': { action: 'val' },
        'jenis_aset_id': { action: 'select2' },
        'kondisi': { action: 'select2' },
        'is_aktif': { action: 'select2' },
        'is_aset': { action: 'select2' },
        'status_label': { action: 'select2' },
        'bisa_dipinjam': { action: 'select2' },
    };

    $('.datepicker').bootstrapMaterialDatePicker({
        weekStart: 0,
        format: 'YYYY-MM-DD',
        time: false,
    });

    sel2_publish("#is_aktif","#myForm .modal-content");
    sel2_publish("#is_aset","#myForm .modal-content");
    sel2_publish("#bisa_dipinjam","#myForm .modal-content");
    sel2_publish("#status_label","#myForm .modal-content");
    sel2_kondisi("#kondisi","#myForm .modal-content");

    initJenisAset();
    function initJenisAset(){
        $.ajax({
            url: '/api/jenis-aset?per_page=all&filter={"is_aktif":1}',
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
                sel2_datalokal('#jenis_aset_id',vdata,false,'#myForm .modal-content');
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
                var lblaset=(!dt.is_aset)?`<span class="badge bg-danger">Tidak</span>`:`<span class="badge bg-success">Ya</span>`;
                var lbstatuslabel=(!dt.status_label)?`<span class="badge bg-danger">Tidak</span>`:`<span class="badge bg-success">Ya</span>`;
                var lblbisadipinjam=(!dt.bisa_dipinjam)?`<span class="badge bg-danger">Tidak</span>`:`<span class="badge bg-success">Ya</span>`;
                var lblkondisi=(dt.kondisi=='baik')?`<span class="badge bg-success">Baik</span>`:`<span class="badge bg-danger">Rusak</span>`;
                var row = `
                    <tr>
                        <td>${nomor++}</td>
                        <td>
                            <span class="badge bg-primary">${dt.jenis_aset.nama}</span>
                            <p>${dt.nama}<br>${lblkondisi}</p>
                            
                        </td>
                        <td>${dt.kode_barang}<p>${dt.nup}</p></td>
                        <td>${dt.tgl_masuk}</td>
                        <td>${dt.deskripsi}</td>
                        <td>${lblaset}</td>
                        <td>${lbstatuslabel}</td>
                        <td>${lblbisadipinjam}</td>
                        <td>${lblaktif}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></button>
                                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
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


    //untuk tampilkan modal 
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
            nama: "nama gedung tidak boleh kosong",
            tgl_masuk: "tanggal tidak boleh kosong",
            kondisi: "kondisi tidak boleh kosong",
            jenis_aset_id: "harus dipilih",
            is_aktif: "harus dipilih",
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