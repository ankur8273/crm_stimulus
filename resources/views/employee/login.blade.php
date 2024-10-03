<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="description" content="CRM">
      <meta name="keywords" content=" CRM, Projects">
      <meta name="author" content="CRM">
      <title>Login - CRM</title>
      <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/img/favicon.png')}}">
      <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
      <link rel="stylesheet" href="{{asset('assets/plugins/fontawesome/css/fontawesome.min.css')}}">
      <link rel="stylesheet" href="{{asset('assets/plugins/fontawesome/css/all.min.css')}}">
      <link rel="stylesheet" href="{{asset('assets/css/line-awesome.min.css')}}">
      <link rel="stylesheet" href="{{asset('assets/css/material.css')}}">
      <link rel="stylesheet" href="{{asset('assets/css/line-awesome.min.css')}}">
      <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
   </head>
   <body class="account-page">
      <div class="main-wrapper">
         <div class="account-content">
            <div class="container">
               <div class="account-logo">
                  <a href="{{route('employee.dashboard')}}"><img src="{{asset('assets/logo/jclogo.webp')}}" alt="Employee CRM"></a>
               </div>
               <div class="account-box">
                  <div class="account-wrapper">
                     <h3 class="account-title">Login</h3>
                     <p class="account-subtitle">Access to our dashboard</p>
                     <form method="POST" action="{{ route('employee.authenticate') }}">
                        @csrf
                        <div class="input-block mb-4">
                           <label class="col-form-label">Email Address</label>
                           <input class="form-control" type="text" name="email" value="">
                        </div>
                        <div class="input-block mb-4">
                           <div class="row align-items-center">
                              <div class="col">
                                 <label class="col-form-label">Password</label>
                              </div>
                              <div class="col-auto">
                                 <!-- <a class="text-muted" href="#">
                                 Forgot password?
                                 </a -->>
                              </div>
                           </div>
                           <div class="position-relative">
                              <input class="form-control" type="password" value="" name="password" id="password">
                              <span class="fa-solid fa-eye-slash" id="toggle-password"></span>
                           </div>
                        </div>
                        <div class="input-block mb-4 text-center">
                           <button class="btn btn-primary account-btn" type="submit">Login</button>
                        </div>
                        <div class="account-footer">
                           <!-- <p>Don't have an account yet? <a href="#">Register</a></p> -->
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <script src="{{asset('assets/js/jquery-3.7.1.min.js')}}" type="3817960d5d4b9c0b7b04e36e-text/javascript"></script>
      <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}" type="3817960d5d4b9c0b7b04e36e-text/javascript"></script>
      <script src="{{asset('assets/js/app.js')}}" type="3817960d5d4b9c0b7b04e36e-text/javascript"></script>
      <script src="{{asset('assets/cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js')}}" data-cf-settings="3817960d5d4b9c0b7b04e36e-|49" defer></script>

      <script src="{{asset('assets/js/sweetalert2.all.min.js')}}"></script>

      <script type="text/javascript">
            
            function tost_fire(msg,typ){

                    $message = msg;

                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })
                    
                    Toast.fire({
                        icon: typ,
                        title: $message
                    })
            }

        </script>

        @if (session()->has('success'))
            <script>
                tost_fire('{{session('success')}}','success');
            </script>
        @endif

        @if (session()->has('warning'))
           <script>
                tost_fire('{{session('warning')}}','warning');
            </script>
        @endif

        @if (session()->has('error'))
            <script>
                tost_fire('{{session('error')}}','error');
            </script>
        @endif

        @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                tost_fire('{{$error}}','error');
            </script>
            @endforeach
        @endif
       
   </body>
</html>