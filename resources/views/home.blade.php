@extends('layouts.master')

@section('content')
    <div class="text-center" id="app">
        <h1>Welcome to Laravel ToDo App</h1>
        <example-component items-source="tasks"></example-component>
    </div>
@endsection
