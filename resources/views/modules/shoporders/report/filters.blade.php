<form method="get">
    <div class="nav-tabs-custom">
        {{-- lists the tab titles and make the first one active --}}
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_minimize" data-toggle="tab"><i class="fa fa-minus"></i></a></li>
            <li><a href="#tab_basic" data-toggle="tab">Basic</a></li>
            <li><a href="#tab_custom" data-toggle="tab">Custom Filters</a></li>
            <li><a href="#tab_advanced" data-toggle="tab">Advanced</a></li>
            {{-- button group for data viewing --}}
            <li class="pull-right">
                @include('modules.base.report.blocks.block-run-excel')
            </li>
        </ul>
        {{-- tab contents--}}
        <div class="tab-content">
            {{-- empty tab --}}
            <div class="tab-pane active " id="tab_minimize">{{-- empty tab --}}</div>
            {{-- tab_basic--}}
            <div class="tab-pane" id="tab_basic">
                @include('form.input-text',['var'=>['name'=>'report_name','label'=>'Report name', 'container_class'=>'col-sm-6']])
                <div class="clearfix"></div>
            </div>
            {{--Custom filter--}}
            <?php
            $buyer_ids = ((Request::has('buyer_id'))) ? Request::get('buyer_id') : [];
            $status = ((Request::has('status'))) ? Request::get('status') : [];
            $sql_extension = (tenantUser()) ? " AND name !='superuser'" : '';
            ?>
            <div class="tab-pane" id="tab_custom">
                @include('form.select-array',['var'=>['name'=>'status','label'=>'Status','value'=>$status,'container_class'=>'col-sm-3','options'=>array_merge(['' => 'Select'],kv(Shoporder::$statuses)),'params'=>['multiple']]])

                @include('form.select-model',['var'=>['name'=>'buyer_id','label'=>'Buyer','value'=>$buyer_ids,'table'=>'users','container_class'=>'col-sm-3','sql_extension'=>'AND group_ids_csv=3','params'=>['multiple']]])

                <div class="clearfix"></div>
            </div>
            {{-- advanced --}}
            <div class="tab-pane" id="tab_advanced">
                @include('modules.base.report.blocks.block-sql-api-url')
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</form>

@section('js')
    @parent
    {{-- write your JS here --}}
@stop