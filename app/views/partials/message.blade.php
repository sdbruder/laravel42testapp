@if(Session::get('message'))
    <div class="spacing">&nbsp;</div>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger" role="alert">
            <b>{{ Session::get('message') }}</b>
            </div>
        </div>
    </div>
@endif
