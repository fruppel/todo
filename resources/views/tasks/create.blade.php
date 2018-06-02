@extends('layouts.app')

@section('content')
<div class="container">
    @include('tasks._errors')

    {!! Form::open(['method' => 'POST','route' => 'tasks.store']) !!}
    @include('tasks._form')
    {!! Form::close() !!}
</div>
@endsection
