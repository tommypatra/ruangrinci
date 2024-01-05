
<!DOCTYPE html>
<html lang="en">

<head>
	@include('head')
  <title>Login - System</title>
	@yield('scriptHead')
	<script type="text/javascript">
		var vBaseUrl = '{{ url("/") }}';
    var vTahunApp = {{ env("APP_TAHUN") }};
	</script>
</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <img src="template/NiceAdmin/assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">AsetKita</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                    <p class="text-center small">Enter your username & password to login</p>
                  </div>

                  <form class="row" id="myForm">
                    @csrf
                    <div class="col-12">
                      <label for="email" class="form-label">Username</label>
                      <div class="input-group">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="email" name="email" class="form-control" id="email" required data-rule-email="true">
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="password" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="password" required>
                    </div>  

                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                      </div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Login</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Don't have account? <a href="pages-register.html">Create an account</a></p>
                    </div>
                  </form>

                </div>
              </div>

              <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->


<!-- MULAI MODAL -->
<div class="modal fade" id="modal-pilih-akses" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">PILIH AKSES AKUN</h5>
            </div>
            <div class="modal-body" id="daftar-hakakses">
            </div>
        </div>
    </div>
</div>
<!-- AKHIR MODAL -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="template/NiceAdmin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="template/NiceAdmin/assets/vendor/tinymce/tinymce.min.js"></script>

  <!-- Template Main JS File -->
  <script src="template/NiceAdmin/assets/js/main.js"></script>

  <script src="js/jquery-3.6.3.min.js"></script>
  <script src="js/jquery-validation-1.19.5/dist/jquery.validate.min.js"></script>
  <script src="js/sweetalert2/dist/sweetalert2.min.js"></script>
  <script src="js/myApp.js"></script>
  <script src="js/loading/loading.js"></script>

  <script>
      var csrfToken = $('meta[name="csrf-token"]').attr('content');
      $(document).ready(function() {

          function pilihAkses(hakakses){
              $('#daftar-hakakses').html(hakakses);
              var myModal1 = new bootstrap.Modal(document.getElementById('modal-pilih-akses'), {
                  backdrop: 'static',
                  keyboard: false,
              });
              myModal1.toggle();                
          }

          $('#modal-pilih-akses').on('hidden.bs.modal', function(e) {
              // location.href = '{{ route("akun-dashboard") }}';
          });

          $("#myForm").validate({
              messages: {
                  email: "Please enter a valid email address.",
                  password: {
                      required: "Password cannot be empty.",
                      minlength: "Password must be at least 8 characters."
                  }
              },
              submitHandler: function(form) {
                  disableForm();
                  login(form)
              }
          });

          // $("#email").val('admin@thisapp.com');
          // $("#password").val('00000000');

          function setSession(param){
              let postData={
                  access_token: param.access_token,
                  email: param.data.email,
                  hakakses: param.hakakses,
                  akses: param.akses,
                  admins: param.admins,
              };
              $.ajax({
                  url: '{{ route("akun-set-session") }}',
                  type: 'POST',
                  data: postData,
                  headers: {
                      'X-CSRF-TOKEN': csrfToken
                  },
                  success: function (response) {
                      if (response.success) {
                          if(response.hakakses.length>1){
                              pilihAkses(response.hakakses_html);
                          }else{
                              location.href = '{{ route("akun-dashboard") }}';
                          }
                      }else {
                          appShowNotification(false,['session tidak tersimpan hubungi admin web']);
                      }
                  },
                  error: function (error) {
                      console.error(error);
                  }
              });
          }

          function login(form) {
              $('#daftar-hakakses').html('');
              $.ajax({
                  type: 'POST',
                  url: '{{ route("auth-login") }}',
                  data: $(form).serialize(),
                  success: function(response) {
                      if (response.success) {
                          setSession(response);				
                      } else {
                          disableForm(false);
                          appShowNotification(false,[response.message]);
                      }
                  },
                  error: function(xhr, status, error) {
                      disableForm(false);
                      appShowNotification(false,['Something went wrong. Please try again later.']);
                  }
              });
          }
                      
          function goDashboard(){
              let timerInterval;
              Swal.fire({
              title: 'Login Berhasil!',
              html: 'Anda akan di arahkan secara otomatis dalam <b></b> milliseconds, silahkan menunggu',
              timer: 2000,
              icon: 'success',
              allowOutsideClick: false,
              timerProgressBar: true,
              didOpen: () => {
                  Swal.showLoading()
                  const b = Swal.getHtmlContainer().querySelector('b')
                  timerInterval = setInterval(() => {
                  b.textContent = Swal.getTimerLeft()
                  }, 100)
              },
              willClose: () => {
                  clearInterval(timerInterval)
              }
              }).then((result) => {
                  if (result.dismiss === Swal.DismissReason.timer) {
                      if(response.hakakses.length>1){
                          pilihAkses(response.hakakses_html);
                      }else{
                          location.href = '{{ route("akun-dashboard") }}';
                      }
                  }
              })

          }
      });
  </script>  

</body>

</html>
