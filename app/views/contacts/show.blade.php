@extends('layout')

@section('content')
    <div class="page-header">
        <h1 class="logo">Contacts <small class="pull-right">{{Auth::User()->email }}</small></h1>
    </div>

    <div class="panel panel-info">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">

                    <button id="addContact" class="btn btn-primary" data-toggle="modal" data-target="#insertModal">
                        <span class="glyphicon glyphicon-plus"></span>
                        Add Contact
                    </button>
                    {{-- CSS styling inline in the HTML element:
                        UGLY AS HELL but I dont know why
                        that property isnt applying --}}
                    <form id="search-form" class="form-inline pull-right" role="form" style="display: inline; margin-bottom: 0px !important;">
                    <div class="input-group">
                    <input type="text" class="form-control search-form" id="searchInput" placeholder="Search">
                    <span class="input-group-btn">
                        <button class="btn btn-primary search-btn" name="q">
                        <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </span>
                    </div>
                    </form>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                &nbsp;
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">

                    <table class="table table-striped table-hover table-condensed">
                        <thead>
                            <tr>
                                <th style="width: 100px;"></th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                        @foreach($contacts as $c)
                            <tr>
                                <th>
                                    <span class="table-btns">
                                    <button
                                        {{-- data-toggle="modal"
                                        data-target="#editModal" --}}
                                        data-id="{{ $c->id }}"
                                        class="btn btn-primary btn-sm btnEdit">
                                        <span class="glyphicon glyphicon-pencil"></span>
                                    </button>
                                    <button
                                        data-toggle="modal"
                                        data-target="#deleteModal"
                                        data-id="{{ $c->id }}"
                                        class="btn btn-danger btn-sm btnDelete">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </button>
                                    </span>
                                </th>
                                <th>{{ $c->name }} {{ $c->surname }}</th>
                                <td>{{ $c->email }}</td>
                                <td>{{ $c->phone }}</td>
                                <td>{{ $c->extrafields }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
            @include('partials.message')
        </div>
    </div>
@stop

@section('after-content')
<div class="modal fade" id="insertModal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
    {{ Form::open([
        'id'     => 'formIM',
        'url'    => 'contact',
        'method' => 'post',
        'class'  => 'form-horizontal']) }}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Insert Contact</h4>
      </div>
      <div class="modal-body">
        <div id="insertMessage" class="alert alert-danger hidden" role="alert"></div>

                {{ Form::token() }}
                <fieldset>
                    {{ Form::label('name', 'Name'); }}
                    {{ Form::text('name', null, [
                        'id' => 'firstIM',
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
                        id="extraBtnsIM"
                        data-show="0" class="btn-group"
                        role="group" aria-label=""
                        style="margin-top: 5px; margin-bottom: 5px;">
                        <button id="plusBtnIM"  type="button" class="btn btn-success">+</button>
                        <button id="minusBtnIM" type="button" class="btn btn-danger" >-</button>
                    </div>
                    {{ Form::text('field1', null, [
                        'id' => 'fieldInsert1',
                        'placeholder' => 'Extra info',
                        'class' => 'form-control clear hidden']) }}
                    {{ Form::text('field2', null, [
                        'id' => 'fieldInsert2',
                        'placeholder' => 'Extra info',
                        'class' => 'form-control clear hidden']) }}
                    {{ Form::text('field3', null, [
                        'id' => 'fieldInsert3',
                        'placeholder' => 'Extra info',
                        'class' => 'form-control clear hidden']) }}
                    {{ Form::text('field4', null, [
                        'id' => 'fieldInsert4',
                        'placeholder' => 'Extra info',
                        'class' => 'form-control clear hidden']) }}
                    {{ Form::text('field5', null, [
                        'id' => 'fieldInsert5',
                        'placeholder' => 'Extra info',
                        'class' => 'form-control clear hidden']) }}

                    {{-- <div class="spacing"><br/></div> --}}
                </fieldset>

      </div>
      <div class="modal-footer">
        {{ Form::button('Close',  ['id' => 'closeBtnIM',  'class' => 'btn btn-default', 'data-dismiss' => 'modal']) }}
        {{ Form::submit('Insert', ['id' => 'insertBtnIM', 'class' => 'btn btn-primary'])                            }}
        {{-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Insert</button> --}}
      </div>
    {{ Form::close() }}
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" data-id="0">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Contact</h4>
      </div>
      <div class="modal-body">
        <p>One fine body&hellip;</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Update</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" data-id="0">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Delete Contact</h4>
      </div>
      <div class="modal-body">
        <p>One fine body&hellip;</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-danger">Delete</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@stop

@section('javascript')
    <script type="text/javascript">
        $(document).ready(function() {
            // /resources/assets/js/contact.js
            contactIndex_setup();
        });
    </script>
@stop
