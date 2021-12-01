@extends('layout.app')
@include('layout.message')
@section('content')
<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        @yield('message')
        <div class="row">
            @if($pterodactyl_information != null)
            <div class="col-12 grid-margin stretch-card">
                <div class="card corona-gradient-card">
                    <div class="card-body py-0 px-0 px-sm-3">
                        <div class="row align-items-center">
                            <div class="col-4 col-sm-3 col-xl-2">
                                <img src={{ asset('images/dashboard/checklist.png') }}
                                    class="gradient-corona-img img-fluid" alt="">
                            </div>
                            <div class="col-5 col-sm-7 col-xl-8 p-0">
                                <p class="mb-0 font-weight-normal d-none d-sm-block"><strong>Here is your username and
                                        password for the panel, store it somewhere safe as it wont be shown
                                        again.</strong>
                                    <br>Username: <code>{{ $pterodactyl_information['username'] }}</code> <br>Password:
                                    <code>{{
                                    $pterodactyl_information['password'] }}</code>
                                </p>
                            </div>
                            <div class="col-3 col-sm-2 col-xl-2 pl-0 text-center">
                                <span>
                                    <a href="{{ " https://" . env('PTERODACTYL_FQDN') }}" target="_blank"
                                        class="btn btn-outline-light btn-rounded get-started-btn">Take me to panel</a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <div class="row">
            <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-9">
                                <div class="d-flex align-items-center align-self-start">
                                    <h3 class="mb-0">{{ Auth::user()->ram_balance }}</h3>
                                    <p class="text-success ml-2 mb-0 font-weight-medium">/ {{
                                        Auth::user()->total_ram_balance }}</p>
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
                                    <h3 class="mb-0">{{ Auth::user()->disk_balance }}</h3>
                                    <p class="text-success ml-2 mb-0 font-weight-medium">/ {{
                                        Auth::user()->total_disk_balance }}</p>
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
                                    <h3 class="mb-0">{{ Auth::user()->cpu_balance }}</h3>
                                    <p class="text-success ml-2 mb-0 font-weight-medium">/ {{
                                        Auth::user()->total_cpu_balance }}</p>
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
                                    <h3 class="mb-0">{{ Auth::user()->slot_balance }}</h3>
                                    <p class="text-success ml-2 mb-0 font-weight-medium">/ {{
                                        Auth::user()->total_slot_balance }}</p>
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
        </div>
    </div>
    <!-- content-wrapper ends -->
</div>
<!-- main-panel ends -->
@endsection