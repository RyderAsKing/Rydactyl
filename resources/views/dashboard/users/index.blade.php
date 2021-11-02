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
                        <h4 class="card-title">Users</h4>
                        </p>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="users-table" style="margin-bottom: 15px">
                                <thead>
                                    <tr>
                                        <th> Username</th>
                                        <th> Coin balance</th>
                                        <th> RAM Balance</th>
                                        <th> CPU Balance</th>
                                        <th> DISK Balance</th>
                                        <th> Slots Balance</th>
                                        <th> RAM Used </th>
                                        <th> Actions </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(sizeof($users) < 1) <tr>
                                        <td colspan="5" align="center">No users</td>
                                        </tr>
                                        @else
                                        @foreach ($users as $user)
                                        <tr>
                                            <td @if($user->type == 1) style="color: #00D25B" @endif> {{ $user->username
                                                }}
                                                ({{ $user->discord_id }}) </td>
                                            <td> {{ $user->coin_balance }} </td>
                                            <td> {{ $user->ram_balance }} </td>
                                            <td> {{ $user->disk_balance }} </td>
                                            <td> {{ $user->cpu_balance }} </td>
                                            <td> {{ $user->slot_balance }} </td>
                                            <td> {{ $user->total_ram_balance - $user->ram_balance }}
                                            </td>
                                            <td> @if($user->id == Auth::user()->id) @else <a
                                                    href="{{ route('dashboard.users.delete', $user->id) }}"><button
                                                        class="btn btn-danger"><i
                                                            class="mdi mdi-delete"></i></button></a> @endif <a
                                                    href="{{ route('dashboard.users.manage', $user->id) }}"><button
                                                        class="btn btn-warning"><i
                                                            class="mdi mdi-table-edit"></i></button></a></td>
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