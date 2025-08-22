<li class="icons dropdown">
    <div class="user-img c-pointer position-relative" data-toggle="dropdown">
        <span class="activity active"></span>
        <img src="{{asset('assets/images/user/1.png')}}" height="40" width="40" alt="">
    </div>
    <div class="drop-down dropdown-profile animated fadeIn dropdown-menu">
        <div class="dropdown-content-body">
            <ul>
                <li>
                    <b>{{ Auth::user()->name }}</b>
                </li>
                <hr class="my-2">
                <li>
                    <a href="{{ route('users.edit', Auth::user()->id) }}"><i class="icon-user"></i> <span>Edit Profile</span></a>
                </li>
                <li>
                    <a href="{{ route('users.password.edit') }}">
                        <i class="icon-lock"></i> <span>Password</span>
                    </a>
                </li>

                <hr class="my-2">
                <li>
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                        <i class="icon-lock"></i> <span>Lock Screen</span>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    <!-- <a href="{{url('login')}}"><i class="icon-lock"></i> <span>Lock Screen</span></a> -->
                </li>
                <li>
                <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                        <i class="icon-key"></i> <span>Logout</span>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    <!-- <a href="{{url('login')}}"><i class="icon-key"></i> <span>Logout</span></a></li> -->
            </ul>
        </div>
    </div>
</li>
