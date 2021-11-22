@extends('layout.app')
@include('layout.message')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        @yield('message')
        <div class="row">
            <div class="col-12 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h3>Managing user {{ $user['username'] }}#{{ $user['discriminator'] }}
                            <code>(Created {{
                            $user['created_at']->diffForHumans() }} and was last logged in {{ $user['last_login']->diffForHumans() }})</code>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-9">
                                <div class="d-flex align-items-center align-self-start">
                                    <h3 class="mb-0">{{ $user['ram_balance'] }}</h3>
                                    <p class="text-success ml-2 mb-0 font-weight-medium">/ {{
                                        $user['total_ram_balance'] }}</p>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="icon icon-box-success ">
                                    <span class="mdi mdi-rocket icon-item"></span>
                                </div>
                            </div>
                        </div>
                        <h6 class="text-muted font-weight-normal">RAM Balance (mb)</h6>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-9">
                                <div class="d-flex align-items-center align-self-start">
                                    <h3 class="mb-0">{{ $user['disk_balance'] }}</h3>
                                    <p class="text-success ml-2 mb-0 font-weight-medium">/ {{
                                        $user['total_disk_balance'] }}</p>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="icon icon-box-success">
                                    <span class="mdi mdi-harddisk icon-item"></span>
                                </div>
                            </div>
                        </div>
                        <h6 class="text-muted font-weight-normal">Disk Balance (mb)</h6>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-9">
                                <div class="d-flex align-items-center align-self-start">
                                    <h3 class="mb-0">{{ $user['cpu_balance'] }}</h3>
                                    <p class="text-success ml-2 mb-0 font-weight-medium">/ {{
                                        $user['total_cpu_balance'] }}</p>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="icon icon-box-success">
                                    <span class="mdi mdi-memory icon-item"></span>
                                </div>
                            </div>
                        </div>
                        <h6 class="text-muted font-weight-normal">CPU Balance (%)</h6>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-9">
                                <div class="d-flex align-items-center align-self-start">
                                    <h3 class="mb-0">{{ $user['slot_balance'] }}</h3>
                                    <p class="text-success ml-2 mb-0 font-weight-medium">/ {{
                                        $user['total_slot_balance'] }}</p>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="icon icon-box-success ">
                                    <span class="mdi mdi-account-plus icon-item"></span>
                                </div>
                            </div>
                        </div>
                        <h6 class="text-muted font-weight-normal">Slots</h6>
                    </div>
                </div>
            </div>
            <div class="col-3 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                @if($user->suspended == false)
                                <h4 class="card-title">Suspend user account</h4>
                                <p class="card-description"> This will suspend the user. Including all the servers the
                                    user owns.
                                </p>
                                <a href="{{ route('dashboard.users.id.toggle', $user->id) }}"><button type="submit"
                                        class="btn btn-warning mb-2">Suspend</button></a>
                                @else
                                <h4 class="card-title">Un-Suspend user account <br>(Suspended {{
                                    $user->suspended_on->diffForHumans() }})</h4>
                                <p class="card-description">
                                    This will
                                    un-suspend the user. Including all the servers
                                    the
                                    user owns.
                                </p>
                                <a href="{{ route('dashboard.users.id.toggle', $user->id) }}"><button type="submit"
                                        class="btn btn-success mb-2">Un-Suspend</button></a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    </script>
    @endsection