@extends('layouts.app')
@section('content')
    <x-forms.auth :type="'Tenant'" :login="false" />

@endsection