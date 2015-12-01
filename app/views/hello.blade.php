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
                    <a href="#" id="github" class="btn btn-info btn-lg btn-block btn-github">Login with Github</a>
                    <div class="spacing">&nbsp;</div>
                    <a href="#" id="github" class="btn btn-info btn-lg btn-block  btn-fb">Login with Facebook</a>
                </div>
                <div class="col-md-7" style="border-left:1px solid #ccc;height:190px">
                <form class="form-horizontal">
                <fieldset>
                    <input id="email" name="email" type="text" placeholder="Enter Email" class="form-control input-lg">
                    <div class="spacing">&nbsp;</div>
                    <input id="pass" name="password" type="password" placeholder="Enter Password" class="form-control input-lg">
                    <div class="spacing"><br/></div>
                    <button id="createaccount" name="createaccount" class="btn btn-success">Create your account</button>
                    <button id="login" name="login" class="btn btn-info pull-right">Login</button>
                </fieldset>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('javascript')
@stop
