<ul class="sidebar-menu">
    @if(user())
        @if(!user()->isSuperUser())
            {{--<li><a href="{{route('users.edit',user()->id)}}"><i class="fa fa-user"></i> <span>Profile</span></a></li>--}}
            {{--<li><a href="{{route('userdetails.edit',user()->userdetail->id)}}"><i class="fa fa-edit"></i> <span>User details</span></a>--}}
            {{--</li>--}}



        @else
            {{--<li class="header">MENU</li>--}}
            <?php
            /****************************************************************************************************
             * Renders the left menu of the application
             * $current_module_name and $breadcrumbs are passed to render function to expand the currently active
             * tree items. render function checks if $current_module_name is available in $breadcrumb.
             ****************************************************************************************************/
            $current_module_name = '';
            $breadcrumbs = [];
            if (isset($mod)) {
                $current_module_name = $mod->name;
                $breadcrumbs = breadcrumb($mod);
            }
            renderMenuTree(\App\Modulegroup::tree(), $current_module_name, $breadcrumbs);
            ?>

            {{--<li class="header">LABELS</li>--}}
            {{--<li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>--}}
            {{--<li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>--}}
            {{--<li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>--}}
        @endif
    @endif
</ul>