@extends('layouts.app')

@section('content')
    <div class="container">
        @include('tasks._errors')

        {!! Form::model($task, ['method' => 'PATCH','route' => ['tasks.update', $task->id]]) !!}
        @include('tasks._form')
        {!! Form::close() !!}
    </div>
@endsection
