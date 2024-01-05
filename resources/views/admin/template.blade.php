    <!DOCTYPE html>
    <html lang="en">
    
    <head>
      @include('head')
      @yield('head')
      <script type="text/javascript">
        var vBaseUrl = '{{ url("/") }}';
        var vUserId = {{ auth()->user()->id }};
        var vTahunApp = {{ env("APP_TAHUN") }};
        var vWebSocket = {{ cekPort(); }};
      </script>
    </head>
    
    <body>
    
      <!-- ======= Header ======= -->
      <header id="header" class="header fixed-top d-flex align-items-center">
    
        <div class="d-flex align-items-center justify-content-between">
          <a href="index.html" class="logo d-flex align-items-center">
            <img src="{{ asset('template/NiceAdmin/assets/img/logo.png') }}" alt="">
            <span class="d-none d-lg-block">AsetKita</span>
          </a>
          <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->
    
        <div class="search-bar">
          <form class="search-form d-flex align-items-center" method="POST" action="#">
            <input type="text" name="query" placeholder="Search" title="Enter search keyword">
            <button type="submit" title="Search"><i class="bi bi-search"></i></button>
          </form>
        </div><!-- End Search Bar -->
    
        <nav class="header-nav ms-auto">
          <ul class="d-flex align-items-center">
    
            <li class="nav-item d-block d-lg-none">
              <a class="nav-link nav-icon search-bar-toggle " href="#">
                <i class="bi bi-search"></i>
              </a>
            </li><!-- End Search Icon-->
    
            <li class="nav-item dropdown">
    
              <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                <i class="bi bi-bell"></i>
                <span class="badge bg-primary badge-number notif-belum-dibaca">0</span>
              </a><!-- End Notification Icon -->
    
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                <li class="dropdown-header">
                  You have <span class="notif-belum-dibaca">0</span> new notifications
                  <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                </li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <span id="daftar-item">
                </span>
    
  
                <li class="dropdown-footer">
                  <a href="#">Show all notifications</a>
                </li>    
              </ul><!-- End Notification Dropdown Items -->
            </li><!-- End Notification Nav -->
        
            <li class="nav-item dropdown pe-3">
    
              <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                <img src="{{ asset('template/NiceAdmin/assets/img/profile-img.jpg') }}" alt="Profile" class="rounded-circle">
                <span class="d-none d-md-block dropdown-toggle ps-2">{{ auth()->user()->name }}</span>
              </a><!-- End Profile Iamge Icon -->
    
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                <li class="dropdown-header">
                  <h6>{{ auth()->user()->name }}</h6>
                  <span>{{ auth()->user()->email }}</span>
                </li>
                <li>
                  <hr class="dropdown-divider">
                </li>
    
                <li>
                  <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                    <i class="bi bi-question-circle"></i>
                    <span>Need Help?</span>
                  </a>
                </li>
                <li>
                  <hr class="dropdown-divider">
                </li>
    
                <li>
                  <a class="dropdown-item d-flex align-items-center" href="javascript:;" onclick="keluar()">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Sign Out</span>
                  </a>
                </li>
    
              </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->
    
          </ul>
        </nav><!-- End Icons Navigation -->
    
      </header><!-- End Header -->
    
      @include('admin.partials.menu')
    
      <main id="main" class="main">
    
        @yield('pageTitle')
    
        <section class="section dashboard">
          <div class="row">
                @yield("container")
          </div>
    
      </main><!-- End #main -->
    
      @include('admin.partials.footer')
    
      <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    
      <!-- Vendor JS Files -->
      <script src="{{ asset('template/NiceAdmin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
      <script src="{{ asset('template/NiceAdmin/assets/vendor/quill/quill.min.js') }}"></script>
      <script src="{{ asset('template/NiceAdmin/assets/vendor/tinymce/tinymce.min.js') }}"></script>    
      <!-- Template Main JS File -->
      <script src="{{ asset('template/NiceAdmin/assets/js/main.js') }}"></script>
      
      <script src="{{ asset('js/jquery-3.6.3.min.js') }}"></script>
      <script>
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var authToken="{{ session()->get('access_token') }}";
        jQuery.ajaxSetup({
          headers: {
            // 'X-CSRF-TOKEN': csrfToken
            'Authorization': 'Bearer ' + authToken
          }
        })        
        function keluar(){
          if(confirm('apakah anda yakin?'))
            $.get('{{ route("akun-keluar-api") }}', function() {
                location.href = '{{ route("akun-masuk") }}';
            });      
        }  
      </script>


      <script src="{{ asset('js/jquery-validation-1.19.5/dist/jquery.validate.min.js') }}"></script>
      <script src="{{ asset('js/sweetalert2/dist/sweetalert2.min.js') }}"></script>
      <script src="{{ asset('js/myApp.js') }}"></script>
      <script src="{{ asset('js/loading/loading.js') }}"></script>

      

      {{-- websocket --}}
      @if(cekPort())
      <script src="{{ asset('js/app.js') }}"></script>
      <script>
          //untuk channel per user agar dapat notif
          joinChannelUserNotif(vUserId);
          function joinChannelUserNotif(user_id){
              let channelName='notif.user';
              Echo.join(channelName)
                  .here((users)=>{
                      // console.log('here');
                      // console.log(users);
                  })
                  .listen('NotificationEvent', (e) => {
                      // console.log('event');
                      // console.log(e);
                      if(e.user_id==vUserId){
                          switch(e.event) {
                              case 'notif':
                                  // alert('notif cek');
                                  loadNotif();
                                break;
                          }
                      }
                  });


              // Echo.private(tmpUserChannelName)
              //     .listen('NotificationEvent', (e) => {
              //         console.log(e);
              //         if(e.user_id==vUserId){
              //             switch(e.event) {
              //                 case 'notif':
              //                     showNotif(e.user_id);
              //                     break;
              //                 case 'grupbaru':
              //                     contactAppend(e.data);
              //                     break;
              //                 default:
              //                     alert('tidak ada aksi');
              //             }
              //         }
              //     });    
            }
      </script>
      @endif
      <script>
        loadNotif();
        var admins=@json(session()->get('admins', []));
        var adminIds = admins.map(admin => admin.id);

        function loadNotif(){
          var postData = {
                user_id: vUserId,
            };
            $.post(vBaseUrl+'/api/notifikasi-user', postData, function (response) {
                $(".notif-belum-dibaca").html(response.belumDibaca);
                $('#daftar-item').html("");

                $.each(response.data, function(index, dt) {
                  var baru=``;
                  var icon='<i class="bi bi-check2-circle text-primary"></i>';
                  if(!dt.is_dibaca){
                    baru=`<span class="badge bg-danger">baru</span>`;
                    icon='<i class="bi bi-exclamation-circle text-danger"></i>';
                  }
                  var judul = dt.judul;  
                  var slug = judul.toLowerCase().replace(/\s+/g, '-');
                  var link = '/detail-'+slug+'/'+dt.pk_id+'/'+dt.id;
                  if(dt.link!=='')
                    link='/'+dt.link;
                  var newItem = ` <li class="notification-item">
                                    
                                      ${icon}
                                      <div> 
                                        <a href="#" onclick="bacaPemberitahuan(${dt.id},${dt.is_dibaca},'${link}')" >
                                        <h5>${judul}</h5>
                                        <p>${dt.pesan}</p>
                                        <p>${dt.pengirim}</p>
                                        <p>${dt.waktu_lalu} ${baru}</p>                                      
                                        </a>
                                      </div>
                                  </li>
                                  <li>
                                    <hr class="dropdown-divider">
                                  </li>`;
                  $('#daftar-item').append(newItem);
                });
            })
            .fail(function (error) {
                console.error("Kesalahan:", error.responseText);
            });          
        }

        function statusPemberitahuan(id){
          $.ajax({
              type: 'GET',
              url: '/api/pemberitahuan/'+id,
              dataType: 'json',
              success: function(response) {
                  // console.log(response);
                  if(response.success){
                      if(response.data.is_dibaca!==1){
                          updatePemberitahuan(response.data.id);
                      }
                  }
              },
              error: function(xhr, status, error) {
                  appShowNotification(false, ['Something went wrong. Please try again later.']);
              }
          });
      }

      function postPemberitahuan(parameter){
          var pengirim = '{{ auth()->user()->name }}';
          var pk_id = parameter['pk_id'];
          var user_id = parameter['user_id'];
          var judul = parameter['judul'];
          var pesan = (parameter['pesan'])?parameter['pesan']:'';
          var link = (parameter['link'])?parameter['link']:'';
          var slug = judul.toLowerCase().replace(/\s+/g, '-');
          // var link = '/detail-'+slug+'/'+pk_id;
          
          judul = judul.toLowerCase().replace(/\b[a-z]/g, function(letter) {
              return letter.toUpperCase();
          });

          var dataForm={
            'pengirim':pengirim,
            'user_id':user_id,
            'judul':judul,
            'pk_id':pk_id,
            'is_dibaca':0,
            'pesan':pesan,
            'link':link,
          };
          $.ajax({
              type: 'POST',
              url: '/api/pemberitahuan',
              dataType: 'json',
              data:dataForm,
              success: function(response) {
                  console.log(response);                
              },
              error: function(xhr, status, error) {
                  appShowNotification(false, ['Something went wrong. Please try again later.']);
              }
          });
      }

      function bacaPemberitahuan(id,is_dibaca,url){
        if(is_dibaca==0)
          updatePemberitahuan(id,url);        
        else
          window.location.replace(url);        
      }

      function updatePemberitahuan(id,url=null){
          $.ajax({
              type: 'PUT',
              url: '/api/pemberitahuan/'+id,
              dataType: 'json',
              data:{'is_dibaca':1},
              success: function(response) {
                if(url)
                  window.location.replace(url)
              },
              error: function(xhr, status, error) {
                  appShowNotification(false, ['Something went wrong. Please try again later.']);
              }
          });
      }

      </script>

      @yield('body')  


    </body>
    </html>    
</body>
</html>