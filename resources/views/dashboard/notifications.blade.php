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
                            <table class="table table-bordered">
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
                                    @foreach ($notifications as $notification)
                                    <tr>
                                        <td> {{ $notification->id }} </td>
                                        <td> {{ $notification->title }} </td>
                                        <td> {{ $notification->message }} </td>
                                        <td> {{ $notification->created_at->diffForHumans() }} </td>
                                        <td> <a href="{{ route('notifications.delete', $notification->id) }}"><button
                                                    class="btn btn-danger btn-rounded btn-icon"><i
                                                        class="mdi mdi-delete"></i></button></a> </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="float-right" style="margin-top: 10px;">
                            {{ $notifications->onEachSide(5)->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection