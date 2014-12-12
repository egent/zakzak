@extends('layouts.default')
@section('body')
<div class="row">
  <div class="col-md-4 col-md-offset-4">
    <h3>Авторизация пользователя</h3>
    {{ Form::open(array('url' => 'login', 'method' => 'post')) }}    
    @if($errors->all())
    <div class="alert alert-danger" role="alert"> @foreach ($errors->all() as $message)
      <p>{{$message}}</p>
      @endforeach </div>
    @endif
    <div class="form-group"> 
    {{Form::label('email','Email')}}    
    {{Form::text('email', null,array('class' => 'form-control'))}} 
    </div>
    <div class="form-group"> 
    {{Form::label('password','Пароль')}}    
    {{Form::password('password',array('class' => 'form-control'))}} 
    </div>
    {{Form::submit('Войти', array('class' => 'btn btn-primary'))}}    
    {{ Form::close() }} 
    </div>
</div>
@stop