@extends('admin.template')

@section('head')
<title>Profil</title>
<link href="{{ asset('js/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('js/select2/dist/css/select2.custom.css') }}" rel="stylesheet">
@endsection

@section('pageTitle')
<div class="pagetitle">
    <h1>Profil</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('akun-dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Profil</li>
        </ol>
    </nav>
</div><!-- End Page Title -->
@endsection


@section('container')
<div class="col-lg-12">
    <div class="row">
        <div class="card info-card customers-card">
            <div class="filter">
                <a class="icon" href="javascript:;" onclick="loadProfil()"><i class="bi bi-arrow-clockwise"></i></a>
            </div>

            <div class="card-body">
                <h5 class="card-title">Profil Akun</h5>
                    <form id="myForm">
                        <input type="hidden" name="profil_id" id="profil_id" >
                        <input type="hidden" name="user_id" id="user_id" value="{{ auth()->user()->id }}">
                        <div class="row">
                            <div class="col-lg-12 mb-3">

                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <h4 class="alert-heading">Hak Akses</h4>
                                    <p id="akses-akun">gunakan dengan bijak</p>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>

                                <div class="form-label">Email : <span class="label-email">admin@mail.com</span></div>
                            </div>

                            <div class="col-lg-8 mb-3">
                                <label class="form-label">Nama Pengguna</label>
                                <input name="name" id="name" type="text" class="form-control" required>
                                
                            </div>

                            <div class="col-lg-4 mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required></select>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <label class="form-label">HP</label>
                                <input name="hp" id="hp" type="text" class="form-control" required>
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label class="form-label">Alamat</label>
                                <textarea rows="4" name="alamat" id="alamat" type="text" class="form-control"></textarea>
                            </div>
                            <hr>
                            <h5>Reset Password</h5>

                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">Password Lama</label>
                                <div class="col-sm-6">
                                    <input name="password_lama" id="password_lama" type="password" class="form-control mb-2" minlength="8">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">Password Baru</label>
                                <div class="col-sm-6">
                                    <input name="password" id="password" type="password" class="form-control mb-2" minlength="8">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">Ulangi Password Baru</label>
                                <div class="col-sm-6">
                                    <input name="password_ulangi" id="password_ulangi" type="password" class="form-control" minlength="8">
                                </div>
                            </div>
                            
                        </div>
    
                        <button type="submit" class="btn btn-primary" id="btn-simpan">Simpan</button>
                    </form>
            </div>
        </div>
    </div>
</div>


@endsection

@section('body')
<script src="{{ asset('js/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/select2lib.js') }}"></script>
<script src="{{ asset('js/crud.js') }}"></script>

<script type="text/javascript">
    var vUserId='{{ auth()->user()->id }}'; 

    sel2_jeniskelamin("#jenis_kelamin");
    loadProfil();
    function loadProfil(){
        $.ajax({
            url: '/api/pengguna?per_page=1&filter={"id":'+vUserId+'}',
            method: 'GET',
            dataType: 'json',
            success: function (response){
                if(response.data.length>0){
                    var profil=response.data[0];
                    var detailProfil=profil.profil[0];
                    var aksesAkun='<ul>';
                    // console.log(profil);
                    $("#id").val(profil.id);
                    $("#profil_id").val(detailProfil.id);
                    $("#name").val(profil.name);
                    $("#label-email").html(profil.email);
                    $("#hp").val(detailProfil.hp);
                    $("#alamat").val(detailProfil.alamat);
                    $("#jenis_kelamin").val(detailProfil.jenis_kelamin).trigger("change");

                    $.each(profil.grup, function(index, dt) {
                        aksesAkun+=`<li>${dt.grup.grup}</li>`;
                    }); 
                    aksesAkun+='</ul>';
                    $("#akses-akun").html(aksesAkun);
                    
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    };

    // $("#password_lama").on("input", function () {
    //     $("#password, #password_ulangi").prop("required", $(this).val() !== '');
    // });

    //validasi form dan submit handler untuk simpan atau ganti
    $("#myForm").validate({
        rules: {
            password_lama: {
                required: function() {
                    return $("#password").val().length > 0 || $("#password_ulangi").val().length > 0;
                }
            },
            password: {
                required: "#password_lama:filled",
            },
            password_ulangi: {
                required: "#password_lama:filled",
                equalTo: "#password"
            }
        },        
        messages: {
            data_aset_id: "harus cari dan pilih",
            keterangan: "tidak boleh kosong",
        },
        submitHandler: function(form) {
            simpan(form)
        }
    });  

    function simpan(form){
        let user_id = $(form).find("#user_id").val();
        let profil_id = $(form).find("#profil_id").val();

        let dataUser = {
            id:user_id,
            name:$(form).find("#name").val(),
            password:$(form).find("#password").val(),
            password_lama:$(form).find("#password_lama").val(),
            password_ulangi:$(form).find("#password_ulangi").val(),
        }
        $.ajax({
            url: '/api/pengguna/'+user_id,
            data : dataUser,
            method: 'PUT',
            dataType: 'json',
            success: function (response){
                simpanProfil(form)
            },
            error: function(xhr, status, error) {
                // console.error(error);
                appShowNotification(false,[error]);
            }
        });    
    }

    function simpanProfil(form){
        let profil_id = $(form).find("#profil_id").val();

        let dataUser = {
            id:profil_id,
            alamat:$(form).find("#alamat").val(),
            hp:$(form).find("#hp").val(),
            jenis_kelamin:$(form).find("#jenis_kelamin").val(),
        }
        $.ajax({
            url: '/api/profil/'+profil_id,
            data : dataUser,
            method: 'PUT',
            dataType: 'json',
            success: function (response){
                appShowNotification(response.success,[response.message]);
            },
            error: function(xhr, status, error) {
                // console.error(error);
                appShowNotification(false,[error]);
            }
        });    
    }    

</script>
@endsection