@extends('layouts.app')
@section('content')


    <x-forms.auth :type="'User'" :login="true" />

@endsection