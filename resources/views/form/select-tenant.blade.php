@if(tenantUser())
    <input name="tenant_id" type="hidden" value="{{userTenantId()}}"/>
@else
    @include("form.select-model",['var'=>['name'=>'tenant_id','label'=>'Artist/Seller', 'table'=>'tenants', 'container_class'=>'col-sm-6']])
@endif