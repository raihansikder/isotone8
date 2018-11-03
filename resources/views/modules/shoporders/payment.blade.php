<?php
/** @var Shoporder $shoporder */
$payable_statuses = ['Payment pending'];
?>

@if(in_array($shoporder->status,$payable_statuses))
    <form action="{{route('shop.orders.make-payment',$shoporder->id)}}" id="paymentForm" method="post">
        <!-- all other fields you want to collect, e.g. name and shipping address -->
        <div id='paymentSection'></div>
        <div>
            <input class="btn btn-primary" type="submit" value="Make payment" onclick="Worldpay.submitTemplateForm()"/>
        </div>
    </form>
@else
    Payment for this order has been confirmed (Code : {{$shoporder->payment_gateway_transaction_id}})<br/>
    {{--Payment details {{$shoporder->payment_gateway_response}}--}}
@endif

@section('js')
    @parent
    @if(in_array($shoporder->status,$payable_statuses))
        <script src="https://cdn.worldpay.com/v1/worldpay.js"></script>
        <!--suppress SpellCheckingInspection -->
        <script type='text/javascript'>
            window.onload = function () {
                Worldpay.useTemplateForm({
                    'clientKey': '{{conf('payment.client_key')}}',
                    'saveButton': false, // Hide the save card button
                    'form': 'paymentForm',
                    'paymentSection': 'paymentSection',
                    'display': 'inline',
                    'reusable': true,
                    'callback': function (obj) {
                        if (obj && obj.token) {
                            var _el = document.createElement('input');
                            _el.value = obj.token;
                            _el.type = 'hidden';
                            _el.name = 'token';
                            document.getElementById('paymentForm').appendChild(_el);
                            document.getElementById('paymentForm').submit();
                        }
                    }
                });
            }
        </script>
    @endif
@stop