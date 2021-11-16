@extends('layout.app')
@include('layout.message')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        @yield('message')
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Notifications</h4>
                        </p>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="notifications-table">
                                <thead>
                                    <tr>
                                        <th> # </th>
                                        <th> Title </th>
                                        <th> Message </th>
                                        <th> Received </th>
                                        <th> Remove </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(sizeof($notifications) < 1) <tr>
                                        <td colspan="5" align="center">No new notifications</td>
                                        </tr>
                                        @else
                                        @foreach ($notifications as $notification)
                                        <tr>
                                            <td> {{ $notification->id }} </td>
                                            <td>
                                                {{ $notification->title }} </td>
                                            <td> {{ Str::limit($notification->message, $limit = 64, $end = '...') }}
                                            </td>
                                            <td> {{ $notification->created_at->diffForHumans() }} </td>
                                            <td> <a href="{{ route('notifications.delete', $notification->id) }}"><button
                                                        class="btn btn-danger"><i
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
        $('#notifications-table').DataTable();
        });
</script>
@endsection