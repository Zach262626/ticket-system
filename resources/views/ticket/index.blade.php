@extends('layouts.app')
@section('content')
    <div class="container py-5" style="height: 10000px">
        <div class="row">
            <h1 class="col">My Support Tickets</h1>
        </div>
        <div class="row bg-dark px-3 py-2 rounded-1">
            <div class="col text-light">Ticket List</div>
        </div>
        <div class="row">
            <div class="px-4 pt-3 pb-2 bg-light">
                <a href="{{ route('ticket-create') }}" class="btn btn btn-primary">Create new Ticket</a>
                <table class="table mt-2 w-100">
                    <thead>
                        <tr>
                            <th class="col-1" scope="col">Ticket #</th>
                            <th class="col-5" scope="col">Description</th>
                            <th class="col-2" scope="col">Type</th>
                            <th class="col-2" scope="col">Status</th>
                            <th class="col-2" scope="col">View</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">10001</th>
                            <td>This is a description</td>
                            <td>Feature</td>
                            <td>In Progress</td>
                            <td><a href="{{ route('ticket-show') }}">Here</a></td>
                        </tr>
                        <tr>
                            <th scope="row">10002</th>
                            <td>This is a description</td>
                            <td>Feature</td>
                            <td>In Progress</td>
                            <td><a href="{{ route('ticket-show') }}">Here</a></td>
                        </tr>
                    </tbody>
                </table>
                <div class="mt-3">
                    <nav aria-label="Page navigation example ">
                        <ul class="pagination">
                            <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                    </nav>
                </div>

            </div>
        </div>
    </div>
@endsection