@extends('layout.app')
@include('layout.message')
@include('layout.footer')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        @yield('message')
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Users</h4>
                        </p>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="users-table">
                                <thead>
                                    <tr>
                                        <th> # </th>
                                        <th> Title </th>
                                        <th> Message </th>
                                        <th> Created at </th>
                                        <th> Remove </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(sizeof($users) < 1) <tr>
                                        <td colspan="5" align="center">No users</td>
                                        </tr>
                                        @else
                                        @foreach ($users as $notification)
                                        <tr>
                                            <td> {{ $notification->discord_id }} </td>
                                            <td> {{ $notification->username }} </td>
                                            <td> {{ $notification->coin_balance }} </td>
                                            <td> {{ $notification->created_at->diffForHumans() }} </td>
                                            <td> <a href=""><button class="btn btn-danger"><i
                                                            class="mdi mdi-delete"></i></button></a> </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready( function () {
        $('#users-table').DataTable();
    });
</script>
@endsection