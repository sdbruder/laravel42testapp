@extends('layout')

@section('content')
<div class="middlePage">
    <div class="page-header">
        <h1 class="logo">Test App</h1>
    </div>

    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">Welcome</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <p>Lorem ipsum.</p>
                    @if (Auth::check())
                        <p>
                            <b>Authenticated user:</b> {{ Auth::user()->email }}
                        </p>
                    @else
                        <p>
                            <b>No user logged in.</b>
                        </p>
                    @endif
                </div>
            </div>
            @include('partials.message')
        </div>
    </div>
</div>
@stop

@section('javascript')
@stop
