@section('navbar')
<nav class="navbar p-0 fixed-top d-flex flex-row">
    <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
        </button>
        <ul class="navbar-nav navbar-nav-right">
            <span class="badge badge-primary">{{
                Auth::user()->coin_balance }} Coins</span>
            @php
            $notifications = Auth::user()->notifications()->take(3)->get()
            @endphp
            <li class="nav-item dropdown">
                <a class="nav-link @if(sizeof($notifications) > 0) count-indicator @endif" id="notificationDropdown"
                    href="#" data-toggle="dropdown">
                    <i class="mdi mdi-bell"></i>
                    <span class="count bg-danger"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                    aria-labelledby="notificationDropdown">
                    <h6 class="p-3 mb-0">Notifications</h6>
                    <div class="dropdown-divider"></div>

                    @if(sizeof($notifications) < 1) <p class="p-3 mb-0 text-center">No new notifications</p>
                        @else @foreach ($notifications as $notification) <a
                            href="{{ route('notifications.view', $notification->id) }}"
                            class="dropdown-item preview-item">
                            <div class="preview-thumbnail">
                                <div class="preview-icon bg-dark rounded-circle">
                                    <i class="mdi mdi-alert-circle-outline text-success"></i>
                                </div>
                            </div>
                            <div class="preview-item-content">
                                <p class="preview-subject mb-1">{{ $notification->title }}</p>
                                <p class="text-muted ellipsis mb-1"> {{ $notification->message }}</p>
                                <p class="text-muted ellipsis mb-0 float-right">{{
                                    $notification->created_at->diffForHumans()
                                    }}</p>
                                </p>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                        @endforeach
                        <a href="{{ route('notifications') }}" class="text-white">
                            <p class="p-3 mb-0 text-center">Manage Notifications</p>
                        </a>
                        @endif


                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" style="float:right;" id="profileDropdown" href="#" data-toggle="dropdown">
                    <div class="navbar-profile">
                        <img class="img-xs rounded-circle" src={{ 'https://cdn.discordapp.com/avatars/' .
                            Session::get('user')->id . '/' . Session::get('user')->avatar . '.png' }} alt="">
                        <p class="mb-0 d-none d-sm-block navbar-profile-name">{{ Session::get('user')->username
                            }}</p>
                        <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                    aria-labelledby="profileDropdown">
                    <h6 class="p-3 mb-0">Profile</h6>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-settings text-success"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject mb-1">Settings</p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{  route('logout')  }}" class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-logout text-danger"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject mb-1">Logout</p>
                        </div>
                    </a>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
            data-toggle="offcanvas">
            <span class="mdi mdi-format-line-spacing"></span>
        </button>
    </div>
</nav>
@endsection