<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="description" content="JC Realtors - Bootstrap Admin Template">
      <meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
      <meta name="author" content="JC Realtors">
      <title>Dashboard - Admin JC Realtors</title>
      <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/img/favicon.png')}}">
      
      @stack('css')
      
   </head>
   <body>
      <div class="main-wrapper">

      	@include('admin.partials.header')

        @include('admin.partials.navigation')
         
        @yield('content')

      </div>

      @yield('modal')

      @yield('scripts')

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
        <script>
          function readURL(input,id) {
                var url = input.value;
                var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
                if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg"|| ext == "webp"|| ext == "gif"|| ext == "svg"|| ext == "webp")) {
                    var reader = new FileReader();
                
                    reader.onload = function (e) {
                        $(id).attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
                else{
                    //  $(id).attr('src', '/assets/no_preview.png');
                  }
            }
        </script>
        
        <script>
            function clear_notification(){
                $.ajax({
                url:"{{route('admin.clear_notification')}}",
                    method:'post',
                    data:{
                        '_token': '{{csrf_token()}}',
                        'status': status
                    },
                    success:function(result)
                    {
                        $('#notfi-list').html('');
                        $('#notify-count').html('0');
                        // location.reload();
                    }
                });
            }
      </script>
   </body>
</html>