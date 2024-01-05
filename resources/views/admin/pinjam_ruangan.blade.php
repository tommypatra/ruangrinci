@extends('admin.template')

@section('head')
<title>Peminjaman - AsetKita</title>
<link href="{{ asset('js/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet">
<link href="{{ asset('js/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('js/select2/dist/css/select2.custom.css') }}" rel="stylesheet">
<script src='{{ asset("js/fullcalendar/dist/index.global.js") }}'></script>
@endsection

@section('pageTitle')
<div class="pagetitle">
    <h1>Peminjaman</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('akun-dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Peminjaman Ruangan</li>
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
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="width:300px">
                    <li class="dropdown-header text-start">
                        <h6>Filter</h6>
                        <div>
                            <input type="text" id="cariData" name="cariData" class="form-control" oninput="cariData(this.value)">
                        </div>
                    </li>
                </ul>
            </div>

            <div class="card-body">
                <h5 class="card-title">Peminjaman <span>| ruangan</span></h5>
                
                <ul class="nav nav-tabs" id="myTabs">
                    <li class="nav-item">
                        <a class="nav-link active" id="tabKalender" data-bs-toggle="tab" href="#kontenKalender">Kalender</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tabTabel" data-bs-toggle="tab" href="#kontenTabel">Tabel</a>
                    </li>
                </ul>
                
                <div class="tab-content mt-2 table-responsive">
                    <div class="tab-pane fade show active" id="kontenKalender">
                        <div class="mt-3" id='calendar'></div>
                    </div>
        
                    <div class="tab-pane fade" id="kontenTabel">
                        <table class="table" >
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th style="width:30%">Nama/Lembaga/Detail</th>
                                    <th style="width:20%">Ruangan/ Gedung</th>
                                    <th style="width:20%">Keterangan</th>
                                    <th style="width:30%">Verifikasi</th>
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
</div>


<!-- MULAI MODAL -->
<div class="modal fade modal-lg" id="modal-form" role="dialog">
  <div class="modal-dialog">
      <form id="myForm" enctype="multipart/form-data">
          <input type="hidden" name="id" id="id" >
          <input type="hidden" name="biaya" id="biaya" value="0">
          <input type="hidden" name="user_id" class="user_id" value="{{ auth()->user()->id }}">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="modal-label">Form</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body ">
                  <div class="row">
                      <div class="col-lg-6 mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text"  name="peminjam_nama" id="peminjam_nama" class="form-control" required>
                      </div>
                      <div class="col-lg-6 mb-3">
                        <label class="form-label">Unit/ Lembaga</label>
                        <input type="text"  name="peminjam_lembaga" id="peminjam_lembaga" class="form-control">
                      </div>

                      <div class="col-lg-4 mb-3">
                        <label class="form-label">No. HP</label>
                        <input type="text"  name="no_hp" id="no_hp" class="form-control" required>
                      </div>

                      <div class="col-lg-4 mb-3">
                          <label class="form-label">Waktu Mulai</label>
                          <input type="text"  name="waktu_mulai" id="waktu_mulai" class="form-control datepicker" required>
                      </div>
          
                      <div class="col-lg-4 mb-3">
                          <label class="form-label">Waktu Selesai</label>
                          <input type="text"  name="waktu_selesai" id="waktu_selesai" class="form-control datepicker" required>
                      </div>

                      <div class="col-lg-8 mb-3">
                        <label class="form-label">Surat Permohonan</label>
                        <input type="file" name="file_upload" id="file_upload" class="form-control" accept=".pdf" required>
                    </div>

                    <div class="col-lg-12 mb-3">
                        <label class="form-label">Ketik dan Ruangan</label>
                        <select id="ruangan_id" class="form-control" multiple="multiple" name="ruangan_id[]" required></select>
                    </div>

                    <div class="col-lg-12 mb-3">
                          <label class="form-label">Keterangan</label>
                          <textarea rows="4" name="keterangan" id="keterangan" type="text" class="form-control" required></textarea>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="submit" class="btn btn-primary" id="btn-simpan">Ajukan</button>
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
<script>

    var vJudul='Pengajuan Peminjaman Ruangan';
    var apiEndPoint = 'pinjam-ruangan';

    $('.datepicker').bootstrapMaterialDatePicker({
        weekStart: 0,
        format: 'YYYY-MM-DD HH:mm:ss',
        time: true,
    });

    function formatTgl(tmp){
        const tgldef = tmp.toISOString().split('T')[0];
        var [tahun,bulan,tanggal] = tgldef.split('-');
        tahun=parseInt(tahun);
        bulan=parseInt(bulan)+1;
        if(bulan>12){
            bulan=1;
            tahun=tahun+1;
        }
        return tahun +'-'+bulan+'-1';
    }
    var calendar;

    document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');
      
  
      calendar = new FullCalendar.Calendar(calendarEl, {
        initialDate: '{{ date("Y-m-d") }}',
        headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        navLinks: true,
        editable: true,
        selectable: true,
        businessHours: true,
        dayMaxEvents: true, // allow "more" link when too many events
        events: function(info, successCallback, failureCallback) {

                var tgl = formatTgl(info.start);
                var kataKunci = document.getElementById('cariData').value;
                
                $.ajax({
                    url: '/api/'+apiEndPoint+'?tanggal='+tgl+'&keyword='+kataKunci,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        var events = [];
                        var bgClr;
                        var brdrClr;
                        $.each(response.data, function(index, dt) {
                            bgClr='#CEAC00';
                            brdrClr='#796500';
                            if(dt.is_diterima==1){
                                bgClr='#08FF00';
                                brdrClr='#2C8A29';
                            }else if(dt.is_diterima==0){
                                bgClr='#B90000';
                                brdrClr='#6A0000';
                            }

                            var eventItem = {
                                title: '['+dt.peminjam_nama+'] '+dt.ruangan.nama+' - '+dt.keterangan+' '+dt.verifikasi_catatan,
                                start: dt.waktu_mulai2,  
                                end: dt.waktu_selesai2,
                                backgroundColor: bgClr,
                                borderColor: brdrClr,  
                            };
                            events.push(eventItem);
                        });
                        successCallback(events);
                    },
                    error: function(error) {
                        console.error('Error fetching events:', error);
                        failureCallback(error);
                    }
                });
            }
      });
  
      calendar.render();
    });
</script>

<script src="{{ asset('js/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/select2lib.js') }}"></script>
<script src="{{ asset('js/crud.js') }}"></script>

<script type="text/javascript">
    var vApi='/api/'+apiEndPoint;
    var fieldInit={
        'id': { action: 'val' },
        'peminjam_nama': { action: 'val' },
        'peminjam_lembaga': { action: 'val' },
        'no_hp': { action: 'val' },
        'waktu_mulai': { action: 'val' },
        'waktu_selesai': { action: 'val' },
        'ruangan_id':{ action:'select2' },
        'keterangan': { action: 'val' },
    };

    $("#ruangan_id").select2({
        dropdownParent: $("#modal-form  .modal-content"),
        minimumInputLength: 3,
        cache: true,
        placeholder: 'cari data aset',
        ajax: {
            url: vBaseUrl+'/api/ruangan',
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
                return {
                    results: dataResults
                };            
            }
        }
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
                var lembaga=(dt.peminjam_lembaga)?`( ${dt.peminjam_lembaga} )`:``;
                var lampiran=`<a href="${dt.file_upload}" target="_blank">Surat Permohonan</a>`;

                var ajukan='';
                var menu=``;
                if(!dt.is_pengajuan){
                    menu=`  <div class="btn-group" role="group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></button>
                                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                    <li><a class="dropdown-item" href="javascript:;" onclick="ajukan(${dt.id})"><i class="bi bi-box-arrow-right"></i> Ajukan Sekarang</a></li>
                                    <li><a class="dropdown-item" href="javascript:;" onclick="ganti(${dt.id})"><i class="bi bi-pencil-square"></i> Ganti</a></li>
                                    <li><a class="dropdown-item" href="javascript:;" onclick="hapus(${dt.id})"><i class="bi bi-trash"></i> Hapus</a></li>
                                </ul>
                            </div>                    
                    `;
                }
                var labelApp=labelSetupVerifikasi(dt.is_pengajuan,dt.is_diterima,dt.verifikasi_catatan,dt.verifikator);
                var verifikasi=labelApp.label+labelApp.catatan;

                                                
                var row = `
                    <tr>
                        <td>${nomor++}</td>
                        <td>
                            ${dt.peminjam_nama} ${lembaga}
                            <div style="font-size:12px;">
                                <i class="bi bi-phone"></i> ${dt.no_hp}
                            </div>
                            <div style="font-size:12px;">
                                <i class="bi bi-calendar4-range"></i> 
                                    ${dt.waktu_mulai}
                                    sd
                                    ${dt.waktu_selesai}
                            </div>
                            <div>
                                <span class="badge rounded-pill bg-primary">Rp. ${dt.biaya}</span>
                            </div>
                        </td>
                        <td>${dt.ruangan.nama} <div style="font-size:11px;">[${dt.ruangan.gedung.nama}]</div></td>
                        <td>${dt.keterangan}</td>
                        <td>
                            ${verifikasi}
                            <div style="font-size:12px;">${lampiran}</div>
                        </td>
                        <td>${menu}</td>
                    </tr>
                `;
                tableBody.append(row);
            });
        else{
            var row = `
                    <tr>
                        <td colspan="6">Tidak ditemukan</td>
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
        $('#file_upload').attr('required', true);
        $('#ruangan_id').prop('disabled', false);
    };

    // ganti dan populasi data
    function ganti(id) {

        $('#file_upload').removeAttr('required');
        $('#ruangan_id').prop('disabled', true);

        CrudModule.fEdit(id, function(response) {
            if(response.success){
                showModalForm();
                var dt = response.data;
                //populasi data secara dinamis
                CrudModule.populateEditForm(dt,fieldInit);
                //ubah form
                $('#modal-label').text('Ganti '+vJudul);
                $('#btn-simpan').text('Ubah Sekarang');

                if(dt.ruangan_id){ 
                    $("#ruangan_id").val("").trigger('change');

                    var option_add = new Option(dt.ruangan.nama, dt.ruangan.id, true, true);
                    $("#ruangan_id").append(option_add).trigger('change');
                }                    

            }
        });
    }

    //validasi form dan submit handler untuk simpan atau ganti
    $("#myForm").validate({
        submitHandler: function(form) {
            let setup_ajax={type:'POST',url:vApi};
            let id=$("#id").val();
            if (id !== ""){
                setup_ajax={type:'PUT',url:vApi+'/'+id};
                simpan(setup_ajax,form);
            }else
                simpan(setup_ajax,form);
        }
    });    

    //simpan baru atau simpan perubahan
    function simpan(setup_ajax,form) {
        var dataAsetId = $("#ruangan_id").val();
        var requests = [];

        function sendRequest(dt) {
            var dataForm = new FormData($(form)[0]);
            dataForm.append('_method', setup_ajax.type);
            dataForm.delete('ruangan_id[]');
            dataForm.set('ruangan_id', dt);
            return new Promise(function(resolve, reject) {
                CrudModule.fSaveUpload(setup_ajax, dataForm, function(response) {
                    resolve(response);
                });
            });
        }

        for (var i = 0; i < dataAsetId.length; i++) {
            requests.push(sendRequest(dataAsetId[i]));
        }

        Promise.all(requests).then(function(responses) {
            var status=true;
            $.each(responses, function(index, dt) {
                if(dt=='Unprocessable Content')
                    status=false;
            });          
            
            var pesan='semua permintaan berhasil diproses';
            if(!status)
                pesan='ada proses yang tidak berhasil ';
            else{
                refresh();
                calendar.refetchEvents();
                $('#modal-form').modal('hide');
            }
            appShowNotification(status, [pesan]);
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
                url: 'api/pinjam-ruangan-ajukan',
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.success) {
                        refresh();
                        // calendar.refetchEvents();
                        appShowNotification(response.success,[response.message]);


                        // ----- pemberitahuan -----
                        // pemberitahuan kepada para admin
                        if(response.data.is_pengajuan){
                            $.each(adminIds, function(index, admin_id) {
                                var parameter={
                                    'pk_id':response.data.id,
                                    'user_id':admin_id,
                                    'link':'pinjam-ruangan-validasi',
                                    'judul':'Peminjaman Ruangan',
                                    'pesan':'Permisi, ada pengajuan peminjaman ruangan',
                                };
                                postPemberitahuan(parameter);
                            });
                        }
                        //----- end pemberitahuan -----

                    } else {
                        appShowNotification(false, ["Something went wrong. Please try again later."]);
                    }
                },
                error: function (xhr, status, error) {
                    appShowNotification(false, ["Something went wrong. Please try again later."]);
                }
            });        
    }

    // --------------- pencarian ----------------

    function cariData(vCari) {
        if (vCari.length >= 3) {
            CrudModule.setKeyword(vCari);
            refresh();
            calendar.refetchEvents();
        } else if(vCari.length < 1) {
            CrudModule.setKeyword("");
            refresh();
            calendar.refetchEvents();
        }
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