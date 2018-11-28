<?php
/** @var $errors \Illuminate\Support\MessageBag */
?>
<div id="systemMessages">
    @if ($errors->any() || Session::has('error'))
        <div class="callout callout-danger ajaxMsg" id="errorDiv">
            <p>
                @if (Session::has('error'))
                    <?php
                    if (is_array(Session::get('error'))) {
                        echo implode('<br/>', Session::get('error'));
                        Session::forget('error');
                    } else {
                        echo Session::get('error');
                        Session::forget('error');
                    }
                    ?>
                @endif

                {{-- Shows validation errors when passed with withError($validator) --}}
                {!! implode('<br/>', $errors->all()) !!}

                {{-- Shows validation from session --}}
                @if (Session::has('validation_errors'))
                    <?php
                    if (is_array(Session::get('validation_errors'))) {
                        foreach (Session::get('validation_errors') as $k => $v) {
                            foreach ($v as $k => $v) {
                                echo "<br/>" . $v;
                            }
                        }
                    } else {
                        echo Session::get('validation_errors');
                    }
                    Session::forget('validation_errors');
                    ?>
                @endif
            </p>
        </div>
    @endif
    @if (Session::has('message'))
        <div class="callout callout-warning ajaxMsg" id="messageDiv">
            <p>
                <?php
                if (is_array(Session::get('message'))) {
                    echo implode('<br/>', Session::get('message'));
                } else {
                    echo Session::get('message');
                }
                Session::forget('message');
                ?>
            </p>
        </div>
    @endif
    @if (Session::has('success'))
        <div class="callout callout-info ajaxMsg" id="successDiv">
            <p>
                <?php
                if (is_array(Session::get('success'))) {
                    echo implode('<br/>', Session::get('success'));
                } else {
                    echo Session::get('success');
                }
                Session::forget('success');
                ?>
            </p>
        </div>
    @endif
</div>