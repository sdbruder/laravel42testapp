@extends('layout')

@section('content')
    <div class="page-header">
        <h1 class="logo">Contacts <small class="pull-right">{{Auth::User()->email }}</small></h1>
    </div>

    <div class="panel panel-info">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">

                    <button id="addContact" class="btn btn-primary ">
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
                        <button type="submit" class="btn btn-primary search-btn" data-target="#search-form" name="q">
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
                                    <button data-id="{{ $c->id }}" class="btn btn-primary btn-sm btnEdit">
                                        <span class="glyphicon glyphicon-pencil"></span>
                                    </button>
                                    <button data-id="{{ $c->id }}" class="btn btn-danger btn-sm btnDelete">
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

@section('javascript')
    <script type="text/javascript">
        $(document).ready(function() {
            // /resources/assets/js/contact.js
            contactIndex_setup();
        });
    </script>
@stop
