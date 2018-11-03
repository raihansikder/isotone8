<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{setting('app-name')}}</title>
    {{--<!-- Tell the browser to be responsive to screen width -->--}}
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    {{--<!-- Font Awesome -->--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    {{--<!-- Ionicons -->--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    {{-- Text fonts --}}
    <link href="https://fonts.googleapis.com/css?family=Roboto|Ubuntu|Comfortaa" rel="stylesheet">
    {{--font awesome--}}
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css"
          integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    {{-- combined css --}}
    <link rel="stylesheet" href="{{asset('assets/templates/admin-lte/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/templates/admin-lte/plugins/iCheck/square/blue.css')}}">
    <link rel="stylesheet" href="{{asset('assets/templates/admin-lte/css/combined.css')}}">
    <link rel="stylesheet" href="{{asset('assets/templates/admin-lte/css/project.css')}}">
    {{--<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->--}}
    {{--<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->--}}
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    @section('head')
        {{-- ++++++++++++ --}}
        {{-- head section --}}
        {{-- ++++++++++++ --}}
    @show

</head>
<body class="hold-transition login-page">
<div class="login-box" style="background-color: black; opacity: .9">
    <div class="login-logo">
        <img style="width: 150px; padding-top: 30px;" src="{{asset("assets/images/logo.png")}}"
             alt="{{setting('app-name')}}" title="{{setting('app-name')}}"/>
        {{--<a href="../../index2.html">{{setting('app.name')}}</a>--}}
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        @include('template.include.messages-top')
        @section('content-top')
            {{-- +++++++++++++++++++ --}}
            {{-- content-top section --}}
            {{-- +++++++++++++++++++ --}}
        @show
        @section('content')
            {{-- +++++++++++++++ --}}
            {{-- content section --}}
            {{-- +++++++++++++++ --}}
            <p class="login-box-msg">Sign in to start your session</p>

            <form action="../../index2.html" method="post">
                <div class="form-group has-feedback">
                    <input type="email" class="form-control" placeholder="Email">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
                            <label>
                                <input type="checkbox"> Remember Me
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            {{--<div class="social-auth-links text-center">--}}
            {{--<p>- OR -</p>--}}
            {{--<a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign--}}
            {{--in using--}}
            {{--Facebook</a>--}}
            {{--<a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign--}}
            {{--in using--}}
            {{--Google+</a>--}}
            {{--</div>--}}
        <!-- /.social-auth-links -->

            <a href="#">I forgot my password</a><br>
            <a href="register.html" class="text-center">Register a new membership</a>
        @show
        @section('content-bottom')
            {{-- ++++++++++++++++++++++ --}}
            {{-- content-bottom section --}}
            {{-- ++++++++++++++++++++++ --}}
        @show
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
<script src="{{asset('assets/templates/admin-lte/plugins/ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('assets/templates/admin-lte/js/combined.js')}}"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>
@section('js')
    {{-- ++++++++++++++++++++++ --}}
    {{-- js section             --}}
    {{-- ++++++++++++++++++++++ --}}
@show
</body>
</html>
