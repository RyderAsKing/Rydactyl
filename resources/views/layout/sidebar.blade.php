@section('sidebar')
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
        <a class="sidebar-brand brand-logo text-white" href="{{ route('dashboard') }}">
            <h3>{{ env('APP_NAME') }}</h3>
        </a>
        <a class="sidebar-brand brand-logo-mini text-white" href="{{ route('dashboard') }}">
            <h3>{{substr(env('APP_NAME'), 0, 2) }}</h3>
        </a>
    </div>
    <ul class="nav">
        <li class="nav-item profile">
            <div class="profile-desc">
                <div class="profile-pic">
                    <div class="count-indicator">
                        <img class="img-xs rounded-circle " src={{ 'https://cdn.discordapp.com/avatars/' .
                            Session::get('user')->id . '/' . Session::get('user')->avatar . '.png' }} alt="">
                        <span class="count bg-success"></span>
                    </div>
                    <div class="profile-name">
                        <h5 class="mb-0 font-weight-normal">{{ Session::get('user')->username }}</h5>
                        <span>#{{ Session::get('user')->discriminator }}</span>
                    </div>
                </div>
            </div>
        </li>
        <li class="nav-item nav-category">
            <span class="nav-link">Navigation</span>
        </li>
        <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <span class="menu-icon">
                    <i class="mdi mdi-speedometer"></i>
                </span>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        @can('admin-content')
        <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('dashboard.users') }}">
                <span class="menu-icon">
                    <i class="mdi mdi-account-multiple"></i>
                </span>
                <span class="menu-title">Users</span>
            </a>
        </li>

        <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('dashboard.nodes') }}">
                <span class="menu-icon">
                    <i class="mdi mdi-server"></i>
                </span>
                <span class="menu-title">Nodes</span>
            </a>
        </li>

        <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('dashboard.nests') }}">
                <span class="menu-icon">
                    <i class="mdi mdi-animation"></i>
                </span>
                <span class="menu-title">Nests</span>
            </a>
        </li>
        @endcan
    </ul>
</nav>
@endsection