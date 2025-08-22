<div class="nk-sidebar">
    <div class="nk-nav-scroll" style="overflow: auto !important;">
        <ul class="metismenu" id="menu">
            <li class="nav-label">Dashboard</li>
            <li>
                <a
                    href="{{ route('home') }}"
                    class="{{ request()->routeIs('home') ? 'active' : '' }}"
                    aria-expanded="false"
                >
                    <i class="fa fa-home menu-icon"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li>
                <a
                    href="{{ route('my-cameras.index') }}"
                    class="{{ request()->routeIs('my-cameras.index') || request()->routeIs('my-cameras.view') ? 'active' : '' }}"
                    aria-expanded="false"
                >
                    <i class="fa fa-camera menu-icon"></i><span class="nav-text">My Cameras</span>
                </a>
            </li>
            <li>
                <a
                    href="{{ route('my-patrols.index') }}"
                    aria-expanded="false"
                    class="{{ request()->routeIs('my-patrols.index') || request()->routeIs('my-patrols.view') ? 'active' : '' }}"
                >
                    <i class="fa fa-video-camera menu-icon"></i><span class="nav-text">My Patrols</span>
                </a>
            </li>
            <li>
                <a
                    href="{{ route('my-mosaics.index') }}"
                    aria-expanded="false"
                    class="{{ request()->routeIs('my-mosaics.index') || request()->routeIs('my-mosaics.view') ? 'active' : '' }}"
                >
                    <i class="fa fa-list menu-icon"></i><span class="nav-text">My Mosaics</span>
                </a>
            </li>
            <li>
                <a
                    href="{{ route('my-alarms.index') }}"
                    aria-expanded="false"
                    class="{{ request()->routeIs('my-alarms.index') ? 'active' : '' }}"
                >
                    <i class="fa fa-bell menu-icon"></i><span class="nav-text">My Alarms</span>
                </a>
            </li>
            <li>
                <a
                    href="{{ route('my-videos.index') }}"
                    aria-expanded="false"
                    class="{{ request()->routeIs('my-videos.index') || request()->routeIs('my-videos.view') ? 'active' : '' }}"
                >
                    <i class="fa fa-play menu-icon"></i><span class="nav-text">My Videos</span>
                </a>
            </li>
            <li class="nav-label">Admin</li>
            @if (auth()->user()->can('view cameras'))
                <li class="{{ request()->routeIs('cameras.index') || request()->routeIs('cameras.create') || request()->routeIs('cameras.edit') || request()->routeIs('cameras.show') ? 'active' : '' }}">
                    <a class="has-arrow {{ request()->routeIs('cameras.index') || request()->routeIs('cameras.create') || request()->routeIs('cameras.edit') || request()->routeIs('cameras.show') ? 'active' : '' }}" href="javascript:void()" aria-expanded="false">
                        <i class="fa fa-camera menu-icon"></i><span class="nav-text">Cameras</span>
                    </a>
                    <ul aria-expanded="false">
                        <li>
                            <a
                                href="{{ route('cameras.index') }}"
                                class="{{ request()->routeIs('cameras.index') || request()->routeIs('cameras.edit') || request()->routeIs('cameras.show') ? 'active' : '' }}"
                            >
                                List
                            </a>
                        </li>
                        @if (auth()->user()->can('add cameras'))
                            <li>
                                <a
                                    class="{{ request()->routeIs('cameras.create') ? 'active' : '' }}"
                                    href="{{ route('cameras.create') }}"
                                >
                                    Add New
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (auth()->user()->can('view alarms'))
                <li class="{{ request()->routeIs('alarms.index') || request()->routeIs('alarms.create') || request()->routeIs('alarms.edit') || request()->routeIs('alarms.show') ? 'active' : '' }}">
                    <a class="has-arrow {{ request()->routeIs('alarms.index') || request()->routeIs('alarms.create') || request()->routeIs('alarms.edit') || request()->routeIs('alarms.show') ? 'active' : '' }}" href="javascript:void()" aria-expanded="false">
                        <i class="fas fa-bell menu-icon"></i><span class="nav-text">Alarms</span>
                    </a>
                    <ul aria-expanded="false">
                        <li>
                            <a
                                href="{{ route('alarms.index') }}"
                                class="{{ request()->routeIs('alarms.index') || request()->routeIs('alarms.edit') || request()->routeIs('alarms.show') ? 'active' : '' }}"
                            >
                                List
                            </a>
                        </li>
                        @if (auth()->user()->can('add alarms'))
                            <li>
                                <a
                                    href="{{ route('alarms.create') }}"
                                    class="{{ request()->routeIs('alarms.create') ? 'active' : '' }}"
                                >
                                    Add New
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (auth()->user()->can('view groups'))
                <li class="{{ request()->routeIs('groups.index') || request()->routeIs('groups.create') || request()->routeIs('groups.edit') || request()->routeIs('groups.show') ? 'active' : '' }}">
                    <a class="has-arrow {{ request()->routeIs('groups.index') || request()->routeIs('groups.create') || request()->routeIs('groups.edit') || request()->routeIs('groups.show') ? 'active' : '' }}" href="javascript:void()" aria-expanded="false">
                        <i class="fas fa-users menu-icon"></i><span class="nav-text">Groups</span>
                    </a>
                    <ul aria-expanded="false">
                        <li>
                            <a
                                href="{{ route('groups.index') }}"
                                class="{{ request()->routeIs('groups.index') || request()->routeIs('groups.edit') || request()->routeIs('groups.show') ? 'active' : '' }}"
                            >
                                List
                            </a>
                        </li>
                        @if (auth()->user()->can('add groups'))
                            <li>
                                <a
                                    href="{{ route('groups.create') }}"
                                    class="{{ request()->routeIs('groups.create') ? 'active' : '' }}"
                                >
                                    Add New
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (auth()->user()->can('view users'))
                <li class="{{ request()->routeIs('users.index') || request()->routeIs('users.create') || request()->routeIs('users.edit') ? 'active' : '' }}">
                    <a class="has-arrow {{ request()->routeIs('users.index') || request()->routeIs('users.create') || request()->routeIs('users.edit') ? 'active' : '' }}" href="javascript:void()" aria-expanded="false">
                        <i class="fas fa-user-friends menu-icon"></i><span class="nav-text">Users</span>
                    </a>
                    <ul aria-expanded="false">
                        <li>
                            <a
                                href="{{ route('users.index') }}"
                                class="{{ request()->routeIs('users.index') || request()->routeIs('users.edit') ? 'active' : '' }}"
                            >
                                List
                            </a>
                        </li>
                        @if (auth()->user()->can('add users'))
                            <li>
                                <a
                                    href="{{ route('users.create') }}"
                                    class="{{ request()->routeIs('users.create') ? 'active' : '' }}"
                                >
                                    Add New
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (auth()->user()->can('view roles'))
                <li class="{{ request()->routeIs('roles.index') || request()->routeIs('roles.create') || request()->routeIs('roles.edit') ? 'active' : '' }}">
                    <a class="has-arrow {{ request()->routeIs('roles.index') || request()->routeIs('roles.create') || request()->routeIs('roles.edit') ? 'active' : '' }}" href="javascript:void()" aria-expanded="false">
                        <i class="fas fa-user-secret menu-icon"></i><span class="nav-text">Roles</span>
                    </a>
                    <ul aria-expanded="false">
                        <li>
                            <a
                                href="{{ route('roles.index') }}"
                                class="{{ request()->routeIs('roles.index') || request()->routeIs('roles.edit') ? 'active' : '' }}"
                            >
                                List
                            </a>
                        </li>
                        @if (auth()->user()->can('add roles'))
                            <li>
                                <a
                                    href="{{ route('roles.create') }}"
                                    class="{{ request()->routeIs('roles.create') ? 'active' : '' }}"
                                >
                                    Add New
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (auth()->user()->can('view permissions'))
                <li class="{{ request()->routeIs('permissions.index') || request()->routeIs('permissions.create') || request()->routeIs('permissions.edit') ? 'active' : '' }}">
                    <a class="has-arrow {{ request()->routeIs('permissions.index') || request()->routeIs('permissions.create') || request()->routeIs('permissions.edit') ? 'active' : '' }}" href="javascript:void()" aria-expanded="false">
                        <i class="fas fa-lock menu-icon"></i><span class="nav-text">Permissions</span>
                    </a>
                    <ul aria-expanded="false">
                        <li>
                            <a
                                href="{{ route('permissions.index') }}"
                                class="{{ request()->routeIs('permissions.index') || request()->routeIs('permissions.edit') ? 'active' : '' }}"
                            >
                                List
                            </a>
                        </li>
                        @if (auth()->user()->can('add permissions'))
                            <li>
                                <a
                                    href="{{ route('permissions.create') }}"
                                    class="{{ request()->routeIs('permissions.create') ? 'active' : '' }}"
                                >
                                    Add New
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (auth()->user()->can('view mosaics'))
                <li class="{{ request()->routeIs('mosaics.index') || request()->routeIs('mosaics.create') || request()->routeIs('mosaics.edit') ? 'active' : '' }}">
                    <a class="has-arrow {{ request()->routeIs('mosaics.index') || request()->routeIs('mosaics.create') || request()->routeIs('mosaics.edit') ? 'active' : '' }}" href="javascript:void()" aria-expanded="false">
                        <i class="fas fa-list menu-icon"></i><span class="nav-text">Mosaics</span>
                    </a>
                    <ul aria-expanded="false">
                        <li>
                            <a
                                href="{{ route('mosaics.index') }}"
                                class="{{ request()->routeIs('mosaics.index') || request()->routeIs('mosaics.edit') ? 'active' : '' }}"
                            >
                                List
                            </a>
                        </li>
                        @if (auth()->user()->can('add mosaics'))
                            <li>
                                <a
                                    href="{{ route('mosaics.create') }}"
                                    class="{{ request()->routeIs('mosaics.create') ? 'active' : '' }}"
                                >
                                    Add New
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (auth()->user()->can('view patrols'))
                <li class="{{ request()->routeIs('patrols.index') || request()->routeIs('patrols.create') || request()->routeIs('patrols.edit') ? 'active' : '' }}">
                    <a class="has-arrow {{ request()->routeIs('patrols.index') || request()->routeIs('patrols.create') || request()->routeIs('patrols.edit') ? 'active' : '' }}" href="javascript:void()" aria-expanded="false">
                        <i class="fas fa-video menu-icon"></i><span class="nav-text">Patrols</span>
                    </a>
                    <ul aria-expanded="false">
                        <li>
                            <a
                                href="{{ route('patrols.index') }}"
                                class="{{ request()->routeIs('patrols.index') || request()->routeIs('patrols.edit') ? 'active' : '' }}"
                            >
                                List
                            </a>
                        </li>
                        @if (auth()->user()->can('add patrols'))
                            <li>
                                <a
                                    href="{{ route('patrols.create') }}"
                                    class="{{ request()->routeIs('patrols.create') ? 'active' : '' }}"
                                >
                                    Add New
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            <li class="nav-label">Contols</li>
            @if (auth()->user()->can('view access'))
                <li>
                    <a href="{{url('access')}}" aria-expanded="false">
                        <i class="fa fa-desktop menu-icon"></i><span class="nav-text">Access</span>
                    </a>
                </li>
            @endif
            @if (auth()->user()->can('view reports'))
                <li>
                    <a
                        href="{{ route('reports.index') }}"
                        aria-expanded="false"
                        class="{{ request()->routeIs('reports.index') ? 'active' : '' }}"
                    >
                        <i class="fa fa-file menu-icon"></i><span class="nav-text">Reports</span>
                    </a>
                </li>
            @endif
            @if (auth()->user()->can('view server'))
                <li>
                    <a
                        href="{{ route('server.index') }}"
                        class="{{ request()->routeIs('server.index') ? 'active' : '' }}"
                        aria-expanded="false"
                    >
                        <i class="fa fa-server menu-icon"></i><span class="nav-text">Server</span>
                    </a>
                </li>
            @endif

            <!-- <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="fas fa-server menu-icon"></i><span class="nav-text">Servers</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{url('list-group')}}">List</a></li>
                    <li><a href="{{url('group/create')}}">Add New</a></li>
                    <li><a href="{{url('group/view')}}">View</a></li>
                </ul>
            </li> -->
            @if (auth()->user()->can('view customers'))
                <li class="{{ request()->routeIs('customers.index') || request()->routeIs('customers.create') || request()->routeIs('customers.edit') ? 'active' : '' }}">
                    <a class="has-arrow {{ request()->routeIs('customers.index') || request()->routeIs('customers.create') || request()->routeIs('customers.edit') ? 'active' : '' }}" href="javascript:void()" aria-expanded="false">
                        <i class="fas fa-user menu-icon"></i><span class="nav-text">Customers</span>
                    </a>
                    <ul aria-expanded="false">
                        <li>
                            <a href="{{ route('customers.index') }}" class="{{ request()->routeIs('customers.index') || request()->routeIs('customers.edit') ? 'active' : '' }}">List</a>
                        </li>
                        @if (auth()->user()->can('add customers'))
                            <li>
                                <a href="{{ route('customers.create') }}" class="{{ request()->routeIs('customers.create') ? 'active' : '' }}">Add New</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (auth()->user()->can('view activity-logs'))
                <li>
                    <a
                        href="{{ route('activity-log.index') }}"
                        aria-expanded="false"
                        class="{{ request()->routeIs('activity-log.index') ? 'active' : '' }}"
                    >
                        <i class="fa fa-clipboard-list menu-icon"></i><span class="nav-text">Activity Logs</span>
                    </a>
                </li>
            @endif
            @if (auth()->user()->can('view notifications'))
                <li class="{{ request()->routeIs('notifications.index') || request()->routeIs('notifications.create') ? 'active' : '' }}">
                    <a class="has-arrow {{ request()->routeIs('notifications.index') || request()->routeIs('notifications.create') ? 'active' : '' }}" href="javascript:void()" aria-expanded="false">
                        <i class="fas fa-bell menu-icon"></i><span class="nav-text">Notifications</span>
                    </a>
                    <ul aria-expanded="false">
                        <li>
                            <a
                                href="{{ route('notifications.index') }}"
                                class="{{ request()->routeIs('notifications.index') ? 'active' : '' }}"
                            >
                                List
                            </a>
                        </li>
                        @if (auth()->user()->can('add notifications'))
                            <li>
                                <a
                                    href="{{ route('notifications.create') }}"
                                    class="{{ request()->routeIs('notifications.create') ? 'active' : '' }}"
                                >
                                    Add New
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            <li class="nav-label">Other</li>
            @if (auth()->user()->can('view consumption-calculator'))
                <li>
                    <a
                        href="{{ route('calculator.index') }}"
                        aria-expanded="false"
                        class="{{ request()->routeIs('calculator.index') ? 'active' : '' }}"
                    >
                        <i class="fas fa-calculator menu-icon"></i><span class="nav-text">Consumption Calculator</span>
                    </a>
                </li>
            @endif
            @if (auth()->user()->can('view address-list'))
                <li>
                    <a
                        href="{{ route('addresses.index') }}"
                        class="{{ request()->routeIs('addresses.index') ? 'active' : '' }}"
                        aria-expanded="false"
                    >
                        <i class="fas fa-list menu-icon"></i><span class="nav-text">RTSPs Address List</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</div>
