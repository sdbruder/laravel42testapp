{{ Form::open([
    'id'     => "form{$modal}",
    'url'    => 'contact',
    'method' => 'post',
    'class'  => 'form-horizontal']) }}
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">{{ $title }}</h4>
  </div>
  <div class="modal-body">
    <div id="message{{$modal}}" class="alert alert-danger hidden" role="alert"></div>
            {{ Form::token() }}
            <fieldset>
                {{ Form::label('name', 'Name'); }}
                {{ Form::text('name', null, [
                    'id' => "first{$modal}",
                    'placeholder' => 'Enter Contact\'s Name',
                    'class' => 'form-control clear']) }}
                {{ Form::label('surname', 'Surname'); }}
                {{ Form::text('surname', null, ['placeholder' => 'Enter Contact\'s Surname',
                    'class' => 'form-control clear']) }}
                {{ Form::label('email', 'E-Mail Address'); }}
                {{ Form::text('email', null, ['placeholder' => 'Enter Contact\'s Email', 'class' => 'form-control clear']) }}
                {{ Form::label('phone', 'Phone'); }}
                {{ Form::text('phone', null, ['placeholder' => 'Enter Contact\'s Phone', 'class' => 'form-control clear']) }}
                {{ Form::label('extrabuttons', 'Extra Info'); }}
                <div
                    id="extraBtns{{$modal}}"
                    data-show="0" class="btn-group"
                    role="group" aria-label=""
                    style="margin-top: 5px; margin-bottom: 5px;">
                    <button id="plusBtn{{$modal}}"  type="button" class="btn btn-success">+</button>
                    <button id="minusBtn{{$modal}}" type="button" class="btn btn-danger" >-</button>
                </div>
                {{ Form::text('field1', null, [
                    'id' => "field{$modal}1",
                    'placeholder' => 'Extra info',
                    'class' => 'form-control clear hidden']) }}
                {{ Form::text('field2', null, [
                    'id' => "field{$modal}2",
                    'placeholder' => 'Extra info',
                    'class' => 'form-control clear hidden']) }}
                {{ Form::text('field3', null, [
                    'id' => "field{$modal}3",
                    'placeholder' => 'Extra info',
                    'class' => 'form-control clear hidden']) }}
                {{ Form::text('field4', null, [
                    'id' => "field{$modal}4",
                    'placeholder' => 'Extra info',
                    'class' => 'form-control clear hidden']) }}
                {{ Form::text('field5', null, [
                    'id' => "field{$modal}5",
                    'placeholder' => 'Extra info',
                    'class' => 'form-control clear hidden']) }}

                {{-- <div class="spacing"><br/></div> --}}
            </fieldset>

  </div>
  <div class="modal-footer">
    {{ Form::button('Close', ['id' => "closeBtn$modal",  'class' => 'btn btn-default', 'data-dismiss' => 'modal']) }}
    {{ Form::submit($submit, ['id' => "submitBtn$modal", 'class' => 'btn btn-primary'])                            }}
    {{-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary">Insert</button> --}}
  </div>
{{ Form::close() }}
