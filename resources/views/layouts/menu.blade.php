<ul id="menu" class="page-sidebar-menu">
    <li {!! (Request::is('home') ? 'class="active"' : '') !!}>
        <a href="{{ route('home') }}">
            <i class="livicon" data-name="dashboard" data-size="25" data-c="#01bc8c" data-hc="#01bc8c"
               data-loop="true"></i>
            <span class="title">Dashboard</span>
        </a>
    </li>
    @if(Auth::user()->hasAnyPermission(['Club list']))
    <li {!! (Request::is('clubs') ? 'class="active"' : '') !!} {!! (Request::is('clubs/create') ? 'class="active"' : '') !!}>
        <a href="{{ route('clubs.index') }}">
            <i class="livicon" data-name="users" title="Users List" data-size="25" data-c="#01bc8c" data-hc="#01bc8c" data-loop="true"></i>
            <span class="title">Clubs</span>
        </a>
    </li>
    @endif
    @if(Auth::user()->hasAnyPermission(['Team list']))
        <li {!! (Request::is('clubs') ? 'class="active"' : '') !!} {!! (Request::is('clubs/create') ? 'class="active"' : '') !!}>
            <a href="{{ route('teams.index') }}">
                <i class="livicon" data-name="users" title="Users List" data-size="25" data-c="#01bc8c" data-hc="#01bc8c" data-loop="true"></i>
                <span class="title">Teams</span>
            </a>
        </li>
    @endif
    @if(Auth::user()->hasAnyPermission(['Player group list']))
        <li {!! (Request::is('player-groups') ? 'class="active"' : '') !!} {!! (Request::is('player-groups/create') ? 'class="active"' : '') !!}>
            <a href="{{ route('player-groups.index') }}">
                <i class="livicon" data-name="users" title="Users List" data-size="25" data-c="#01bc8c" data-hc="#01bc8c" data-loop="true"></i>
                <span class="title">Player groups</span>
            </a>
        </li>
    @endif
    @if(Auth::user()->hasAnyPermission(['Player list']))
        <li {!! (Request::is('players') ? 'class="active"' : '') !!} {!! (Request::is('players/create') ? 'class="active"' : '') !!}>
            <a href="{{ route('players.index') }}">
                <i class="livicon" data-name="users" title="Users List" data-size="25" data-c="#01bc8c" data-hc="#01bc8c" data-loop="true"></i>
                <span class="title">Players</span>
            </a>
        </li>
    @endif
    @if(Auth::user()->hasAnyPermission(['User list']))
        <li {!! (Request::is('users') ? 'class="active"' : '') !!} {!! (Request::is('users/create') ? 'class="active"' : '') !!}>
            <a href="{{ route('users.index') }}">
                <i class="livicon" data-name="users" title="Users List" data-size="25" data-c="#01bc8c" data-hc="#01bc8c" data-loop="true"></i>
                <span class="title">Super admins</span>
            </a>
        </li>
    @endif
</ul>