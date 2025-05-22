@extends('layouts.app')
@section('content')

    <a href="{{ route('home') }}" class="btn btn-secondary">Home</a>

    <x-forms.auth :type="'User'" :login="false" />

@endsection