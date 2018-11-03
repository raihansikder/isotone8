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
    <link rel="stylesheet" href="{{asset('assets/templates/admin-lte/plugins/iCheck/all.css')}}">
    <link rel="stylesheet" href="{{asset('assets/templates/admin-lte/css/combined.css')}}">
    <link rel="stylesheet" href="{{asset('assets/templates/admin-lte/css/project.css')}}">
    <link rel="stylesheet" href="{{asset('assets/templates/admin-lte/plugins/datepicker/datepicker3.css')}}">
    {{--<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->--}}
    {{--<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->--}}
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <script src="{{asset('assets/templates/admin-lte/js/vue.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/templates/admin-lte/js/axios.min.js')}}" type="text/javascript"></script>

    <script src="{{ asset('assets/templates/admin-lte/plugins/datepicker/bootstrap-datepicker.js')}}"
            type="text/javascript"></script>

    <![endif]-->
    @section('head')
        {{-- ++++++++++++ --}}
        {{-- head section --}}
        {{-- ++++++++++++ --}}
    @show
</head>
<body class="hold-transition skin-black-light sidebar-mini fixed">
<!-- Site wrapper -->
<div id="root" class="wrapper">
    <header class="main-header">
        <!-- Logo -->
        <a href="{{route('shop.home')}}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <img style="height: 60%" src="{{asset("assets/images/logo-hr.png")}}" alt="{{setting('app-name')}}"
                 title="{{setting('app-name')}}"/>
            <span class="logo-mini">{{setting('app-name')}}</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg">{{setting('app-name')}}</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    {{--@include('template.include.top-menu.message-menu')--}}
                    {{--@include('template.include.top-menu.message-menu')--}}
                    {{--@include('template.include.top-menu.task-menu')--}}
                    <li><a href="{{route('shop.search')}}">Find art</a></li>
                    @if(user())
                        <li><a href="{{route('home')}}">Manage Account</a></li>

                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="{{asset(user()->profilePic())}}"
                                     class="user-image" alt="User Image">
                                <span class="hidden-xs">{{user()->name}}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="user-header">
                                    <img src="{{asset(user()->profilePic())}}"
                                         class="img-circle" alt="User Image">
                                    <p>
                                        {{user()->name}}
                                        <small>{{cleanCsv(user()->groups_title_csv)}}</small>
                                    </p>
                                </li>
                                {{--<!-- Menu Body -->--}}
                                <li class="user-body">
                                    {{--<div class="row">--}}
                                    {{--<div class="col-xs-4 text-center">--}}
                                    {{--<a href="#">Followers</a>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-xs-4 text-center">--}}
                                    {{--<a href="#">Sales</a>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-xs-4 text-center">--}}
                                    {{--<a href="#">Friends</a>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                    {{--<!-- /.row -->--}}
                                </li>
                                {{--<!-- Menu Footer-->--}}
                                <li class="user-footer">
                                    {{--<div class="pull-left">--}}
                                    {{--<a href="#" class="btn btn-default btn-flat">Profile</a>--}}
                                    {{--</div>--}}
                                    <div class="pull-right">
                                        <a href="{{route('signout')}}" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li>
                            <a href="{{route('get.signin')}}">Sign in</a>
                        </li>
                    @endif
                    {{--<li><a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a></li>--}}
                </ul>
            </div>
        </nav>
    </header>
    <!-- =============================================== -->
    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            @if(user())
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="{{asset(user()->profilePic())}}" class="img-circle"
                             alt="User Image">
                    </div>
                    <div class="pull-left info">
                        <p>{{ user()->name}}</p>
                        <a href="#"><i class="fa fa-circle text-success"></i> {{trim(user()->group_titles_csv,',')}}</a>
                    </div>
                </div>
            @endif
            @section('sidebar-left')
                @include('modules.base.include.sidebar-left')
            @show
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- =============================================== -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h4>
                @section('title')
                    {{-- +++++++++++++++++++ --}}
                    {{-- title section       --}}
                    {{-- +++++++++++++++++++ --}}
                    Blank page
                    <small>it all starts here</small>
                @show
            </h4>
            @section('breadcrumb')
                {{-- +++++++++++++++++++ --}}
                {{-- breadcrumb section  --}}
                {{-- +++++++++++++++++++ --}}
                @include('template.include.breadcrumb')
            @show
        </section>

        <!-- Main content -->
        <section class="content col-md-12">
            <div class="col-md-12 no-padding">
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
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Title</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"
                                        data-toggle="tooltip"
                                        title="Collapse">
                                    <i class="fa fa-minus"></i></button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"
                                        data-toggle="tooltip"
                                        title="Remove">
                                    <i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            Start creating your amazing application!
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            Footer
                        </div>
                        <!-- /.box-footer-->
                    </div>
                    <!-- /.box -->
                @show
                <div class="clearfix"></div>
                @section('content-bottom')
                    {{-- ++++++++++++++++++++++ --}}
                    {{-- content-bottom section --}}
                    {{-- ++++++++++++++++++++++ --}}
                @show
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
            <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>

            <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <!-- Home tab content -->
            <div class="tab-pane" id="control-sidebar-home-tab">
                <h3 class="control-sidebar-heading">Recent Activity</h3>
                <ul class="control-sidebar-menu">
                    <li>
                        <a href="javascript:void(0)">
                            <i class="menu-icon fa fa-birthday-cake bg-red"></i>

                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                                <p>Will be 23 on April 24th</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <i class="menu-icon fa fa-user bg-yellow"></i>

                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                                <p>New phone +1(800)555-1234</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>


                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <i class="menu-icon fa fa-file-code-o bg-green"></i>

                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                                <p>Execution time 5 seconds</p>
                            </div>
                        </a>
                    </li>
                </ul>
                <!-- /.control-sidebar-menu -->

                <h3 class="control-sidebar-heading">Tasks Progress</h3>
                <ul class="control-sidebar-menu">
                    <li>
                        <a href="javascript:void(0)">
                            <h4 class="control-sidebar-subheading">
                                Custom Template Design
                                <span class="label label-danger pull-right">70%</span>
                            </h4>

                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <h4 class="control-sidebar-subheading">
                                Update Resume
                                <span class="label label-success pull-right">95%</span>
                            </h4>

                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <h4 class="control-sidebar-subheading">
                                Laravel Integration
                                <span class="label label-warning pull-right">50%</span>
                            </h4>

                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <h4 class="control-sidebar-subheading">
                                Back End Framework
                                <span class="label label-primary pull-right">68%</span>
                            </h4>

                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                            </div>
                        </a>
                    </li>
                </ul>
                <!-- /.control-sidebar-menu -->

            </div>
            <!-- /.tab-pane -->
            <!-- Stats tab content -->
            <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
            <!-- /.tab-pane -->
            <!-- Settings tab content -->
            <div class="tab-pane" id="control-sidebar-settings-tab">
                <form method="post">
                    <h3 class="control-sidebar-heading">General Settings</h3>

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Report panel usage
                            <input type="checkbox" class="pull-right" checked>
                        </label>

                        <p>
                            Some information about this general settings option
                        </p>
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Allow mail redirect
                            <input type="checkbox" class="pull-right" checked>
                        </label>

                        <p>
                            Other sets of options are available
                        </p>
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Expose author name in posts
                            <input type="checkbox" class="pull-right" checked>
                        </label>

                        <p>
                            Allow the user to show his name in blog posts
                        </p>
                    </div>
                    <!-- /.form-group -->

                    <h3 class="control-sidebar-heading">Chat Settings</h3>

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Show me as online
                            <input type="checkbox" class="pull-right" checked>
                        </label>
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Turn off notifications
                            <input type="checkbox" class="pull-right">
                        </label>
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Delete chat history
                            <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                        </label>
                    </div>
                    <!-- /.form-group -->
                </form>
            </div>
            <!-- /.tab-pane -->
        </div>
    </aside>
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
    @include('template.include.modal-messages')
    @include('template.include.modal-delete')
</div>
<!-- ./wrapper -->

<script src="{{asset('assets/templates/admin-lte/plugins/ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('assets/templates/admin-lte/js/combined.js')}}"></script>
<script src="{{ asset('assets/templates/js/jquery-ui-1.10.3.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('assets/templates/js/plugins/datatables.1.9.4/jquery.dataTables.js')}}"
        type="text/javascript"></script>
<script src="{{ asset('assets/templates/js/plugins/datatables.1.9.4/dataTables.bootstrap.js')}}"
        type="text/javascript"></script>
@section('js')
    {{-- ++++++++++++ --}}
    {{-- js section   --}}
    {{-- ++++++++++++ --}}
@show
</body>
</html>
