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
                    <p>Nullam quis risus eget urna mollis ornare vel eu leo. Nulla vitae elit libero, a pharetra augue. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Maecenas faucibus mollis interdum. Etiam porta sem malesuada magna mollis euismod.</p>
                    <h4><a href="/auth/login">Login page</a></h4>
                    <h4><a href="/auth/logout">Logout page</a></h4>
                    <h4><a href="/contact">Contacts page</a></h4>
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
