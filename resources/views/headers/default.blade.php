<div class="top-menu">
    <div class="container">
        <div class="row">
            <div class="col-sm-2">
                <div id="fh5co-logo"><a href=""><i class="icon-study"></i> TClassroom</a></div>
            </div>
            @guest
                <div class="col-sm-10 text-right">
                    <ul>
                        <li class="btn btn-md btn-info"><a href="{{url('/login')}}">Login</li>
                        <li class="btn btn-md btn-success"><a href="{{url('/courses')}}">Create a Course</a></li>
                    </ul>
                </div>
            @else
                <div class="col-sm-10 text-right">
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                </div>
            @endguest
        </div>
    </div>
</div>