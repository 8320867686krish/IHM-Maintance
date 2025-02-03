<div class="nav-left-sidebar sidebar-dark" id="mainSidebar">
    <div class="menu-list">
        <nav class="navbar navbar-expand-lg navbar-light">

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav flex-column">
                    <li class="nav-item" style="text-align: center;">
                        <x-logo />

                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ @$isActive ? 'active' : '' }}" href="{{ route('dashboard') }}"><i class="fa fa-fw fa-user-circle"></i>Dashboard</a>
                    </li>
                    @if(@\Auth()->user()->roles()->first()->level == 1)
                    <li class="nav-item">
                        <a class="nav-link {{ @$isActive ? 'active' : '' }}" href="{{ route('configration') }}"><i class="fa fa-fw fa-user-circle"></i>Configration</a>
                    </li>
                    @endif
                    @php
                    if (request()->routeIs('dashboard') || request()->routeIs('configration')) {
                    $isActive = true;
                    }
                    @endphp

                    @foreach ($allPermissions as $permission)
                    @if ($permission['group_type'] === 'main' && $permission['is_show'] == 1)
                    @can($permission['name'])
                    <li class="nav-item">
                        @php
                        $isActive = false;

                        $newPermissionName = str_replace('_', ' ', $permission['name']);

                        // $endsWithS = Str::endsWith(Request::segment(1), 's');
                        $string = Request::segment(1);
                        $endsWithS = substr($string, -1) === 's';

                        if (!$endsWithS) {
                        if ($permission['name'] == $string) {
                        $string = $string;
                        } else {
                        $string = $string . 's';
                        }
                        }

                        if (request()->routeIs($permission['name'])) {
                        $isActive = true;
                        }

                        if ($string == $permission['name']) {
                        $isActive = true;
                        }



                        @endphp
                        <a class="nav-link {{ $isActive ? 'active' : '' }} "
                            href="{{ route($permission['name']) }}"><i class="fa fa-solid fa-ship"></i>{{ ucwords($permission['full_name']) }}<span
                                class="badge badge-success">6</span></a>
                    </li>
                    @endcan
                    @endif
                    @endforeach
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('portal.guide')}}"><i class="fa fa-fw fa-user-circle"></i>Portal User Guide</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('helpcenter.list') }}"><i class="fa fa-fw fa-user-circle"></i>Help Center</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>