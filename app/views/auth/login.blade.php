@extends('layout')

@section('content')
<div class="middlePage">
    <div class="page-header">
        <h1 class="logo">Test <small>Welcome!</small></h1>
    </div>

    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">Please Login</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-5">
                    <a href="/auth/GitHub" class="btn btn-info btn-lg btn-block btn-github">Login with Github</a>
                    <div class="spacing">&nbsp;</div>
                    <a href="/auth/Facebook" class="btn btn-info btn-lg btn-block btn-fb">Login with Facebook</a>
                </div>
                <div class="col-md-7" style="border-left:1px solid #ccc;height:190px">
                {{ Form::open([
                    'url'    => 'auth/login',
                    'method' => 'post',
                    'class'  => 'form-horizontal']) }}
                {{ Form::token() }}
                <fieldset>
                    {{ Form::text('email', null, ['placeholder' => 'Enter Email', 'class' => 'form-control input-lg']) }}
                    <div class="spacing">&nbsp;</div>
                    {{ Form::password('password', ['placeholder' => 'Enter Password', 'class' => 'form-control input-lg']) }}
                    <div class="spacing"><br/></div>
                    {{ Form::submit('Login', ['name' => 'login', 'class' => 'btn btn-info pull-right']) }}
                    {{ Form::submit('Create your account', ['name' => 'create', 'class' => 'btn btn-success']) }}
                </fieldset>
                {{ Form::close() }}
                </div>
            </div>
            @include('partials.message')
        </div>
    </div>
</div>
@stop

@section('javascript')
@stop
