
<a class="navbar-brand" href="{{ route('dashboard') }}"><img src="{{ asset($logo1) }}" style="height: 47px !important;"/></a>
@if($currentUserRoleLevel == 5)
<li class="nav-item">
                        <a class="nav-link {{ @$isActive ? 'active' : '' }}" href="{{ route('dashboard') }}" ><i class="fa fa-fw fa-user-circle"></i>Dashboard</a>
                    </li>
            @endif