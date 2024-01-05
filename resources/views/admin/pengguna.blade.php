@extends('admin.template')

@section('head')
<title>Pengguna</title>
<link href="{{ asset('js/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('js/select2/dist/css/select2.custom.css') }}" rel="stylesheet">
@endsection

@section('pageTitle')
<div class="pagetitle">
    <h1>Pengguna</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('akun-dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Pengguna</li>
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
                <h5 class="card-title">Pengguna <span>| aplikasi</span></h5>
                <div class="table-responsive">
                    <table class="table" >
                        <thead>
                            <tr>
                                <th>No</th>
                                <th width="25%">Nama/ Email</th>
                                <th width="10%">Jenis Kelamin</th>
                                <th width="25%">Alamat</th>
                                <th width="15%">HP</th>
                                <th width="25%">Grup Akses</th>
                                <th>Pendaftaran/ Perubahan</th>
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
<div class="modal fade modal-lg" id="modal-form" role="dialog">
    <div class="modal-dialog">
        <form id="myForm">
            <input type="hidden" name="user_id" id="user_id" value="{{ auth()->user()->id }}">
            <input type="hidden" name="id" id="id" >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-label">Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <div class="row">
						<div class="col-lg-9 mb-3">
                            <label class="form-label">Nama</label>
                            <input name="name" id="name" type="text" class="form-control" placeholder="" required>
                        </div>
						<div class="col-lg-9 mb-3">
                            <label class="form-label">Email</label>
                            <input name="email" id="email" type="email" class="form-control" placeholder="" required>
                        </div>
						<div class="col-lg-9 mb-3">
                            <label class="form-label">Password</label>
                            <input name="password" id="password" type="password" class="form-control" placeholder="" required minlength="8">
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
<div class="modal fade modal" id="modal-form-grup" role="dialog">
    <div class="modal-dialog">
        <form id="myFormGrup">
            <input type="hidden" name="user_id" id="user_id">
            <input type="hidden" name="is_aktif" id="is_aktif" value="1">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-label-grup">Grup Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ">
                    <div class="row">
						<div class="col-lg-12 mb-3">
                            <label class="form-label">Nama Grup</label>
                            <select name="grup_id" id="grup_id" type="text" class="form-control" placeholder="" required></select>
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
<script src="{{ asset('js/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/select2lib.js') }}"></script>
<script src="{{ asset('js/crud.js') }}"></script>


<script type="text/javascript">
    var vApi='/api/pengguna';
    var vJudul='Pengguna App';
    var fieldInit={
        'id': { action: 'val' },
        'name': { action: 'val' },
        'email': { action: 'val' },
    };

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
                var grupakun=``;
                if(dt.grup.length>0){
                    grupakun=`<ul>`;
                    $.each(dt.grup, function(index, dtgrp) {
                        badge='danger';
                        if(dtgrp.is_aktif){
                            badge='success';
                        }
                        grupakun+=`<li><span class="badge bg-${badge}">${dtgrp.grup.grup}</span> <a href="javascript:;" onclick="hapus(${dtgrp.id},0)"><i class="fa-regular fa-trash-can"></i></a> </li>`;
                    });
                    grupakun+=`</ul>`;
                }
                
                var jk=(dt.profil.length>0)?dt.profil[0].jenis_kelamin:'';
                var alamat=(dt.profil.length>0)?dt.profil[0].alamat:'';
                var hp=(dt.profil.length>0)?dt.profil[0].hp:'';
                var row = `
                    <tr>
                        <td>${nomor++}</td>
                        <td>${dt.name} <i>${dt.email}</i></td>
                        <td>${jk}</td>
                        <td>${alamat}</td>
                        <td>${hp}</td>
                        <td>${grupakun}</td>
                        <td>${dt.created_at}</div></td>
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></button>
                                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                    <li><a class="dropdown-item" href="javascript:;" onclick="tambahGrup(${dt.id})"><i class="bi bi-key"></i> Grup Akses</a></li>
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
                        <td colspan="8">Tidak ditemukan</td>
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
    function showModalForm(elForm='#myForm',elModal='modal-form'){
        let myModalForm = new bootstrap.Modal(document.getElementById(elModal), {
            backdrop: 'static',
            keyboard: false,
        });
        myModalForm.toggle();
    }

    // tambah data
    function tambah() {
        CrudModule.resetForm(fieldInit);
        showModalForm('#myForm','modal-form');
        $('#modal-label').text('Tambah '+vJudul);
        $('#btn-simpan').text('Simpan');
    };

    // ganti dan populasi data
    function ganti(id) {
        CrudModule.fEdit(id, function(response) {
            if(response.success){
                CrudModule.resetForm(fieldInit);
                showModalForm('#myForm','modal-form');
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
            name: "Nama tidak boleh kosong",
            email: {
                required: "Email tidak boleh kosong",
                email: "Masukkan alamat email yang valid"
            },
            password: {
                required: "Password tidak boleh kosong",
                minlength: "Password harus minimal 8 karakter"
            }        
        },
        submitHandler: function(form) {
            let setup_ajax={type:'POST',url:vApi};
            let id=$("#id").val();
            if (id !== "")
                setup_ajax={type:'PUT',url:vApi+'/'+id};
            simpan(setup_ajax,form,'#modal-form');
        }
    });    

    //simpan baru atau simpan perubahan
    function simpan(setup_ajax,form,myModal='#modal-form') {
        let dataForm = $(form).serialize();
        CrudModule.fSave(setup_ajax, dataForm, function(response) {
            if (response.success) {
                refresh();
                $(myModal).modal('hide');
            } 
            appShowNotification(response.success,[response.message]);
        });
    }		    

    // hapus
    function hapus(id,akun=true) {
        if(!akun)
            CrudModule.setApi('/api/grup-user');

        CrudModule.fDelete(id, function(response) {
            CrudModule.setApi(vApi);
            appShowNotification(response.success, [response.message]);
            if (response.success) {
                refresh();
            }
        });
    }

    //tambah grup user
    function tambahGrup(user_id){
        $('#myFormGrup').find('[id="user_id"]').val(user_id);   
        $('#grup_id').val("").trigger("change");
        showModalForm('#myFormGrup','modal-form-grup');
    }

    //load grup user
    initData();
    function initData(){
        //load grup
        $.ajax({
            url: '/api/grup?per_page=all',
            method: 'GET',
            dataType: 'json',
            success: function (response){
                let vdata=[];
                if(response.data.length>0){
                    $.each(response.data, function(index, dt) {
                        vdata.push({id:dt.id,text:dt.grup});
                    });
                }
                sel2_datalokal('#grup_id',vdata,false,'#myFormGrup .modal-content');
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    //validasi form dan submit handler untuk simpan atau ganti
    $("#myFormGrup").validate({
        messages: {
            grup: "grup tidak boleh kosong",
        },
        submitHandler: function(form) {
            let setup_ajax={type:'POST',url:'/api/grup-user'};
            simpan(setup_ajax,form,'#modal-form-grup');
        }
    });    

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