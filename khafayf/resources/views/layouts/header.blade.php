<header id="header">
            <div class="header-top">
                <div class="container">
                    <ul class="menu-top-head clearfix">
                        <li>
                            <a href="#"><span><i class="fa fa-heart" aria-hidden="true"></i></span>Wishlist</a>
                        </li>
                        @guest
                        <li>

                            <a href="{{url('/login')}}"><span><i class="zmdi zmdi-sign-in"></i></span>Register/Login</a>
                        </li>
                        @else
                        <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest


                        @if(LaravelLocalization::setlocale() == 'ar')   
                        <li><a href="{{ LaravelLocalization::setlocale('en') }}">English <i class="zmdi zmdi-globe-alt"></i></a></li>
                        @elseif(LaravelLocalization::setlocale() == 'en') 
                        <li><a href="{{ LaravelLocalization::setlocale('ar') }}">عربي <i class="zmdi zmdi-globe-alt"></i></a></li>
                        @endif
                        

                        {{-- @if (Request::is('ar') or Request::is('ar/*'))

                        <li><a href="{{url('/en/'.Request::segment(2))}}">English <i class="zmdi zmdi-globe-alt"></i></a></li>
                        @endif

                        @if (Request::is('en') or Request::is('en/*')) 
                        <li><a href="{{url('/ar/'.Request::segment(2))}}">عربي <img src="{{url('front_end/images/flag.png')}}" alt=""></a></li>
                        @endif --}}
                        
                    </ul>
                </div>
            </div>
            <div class="header-bottom">
                <div class="container">
                    <div class="head-middle">
                        <div class="row">
                            <div class="col-md-3 col-sm-2">
                                <a href="{{url('/')}}" class="logo-site">
                                    <img src="{{url('front_end/images/logo-site.png')}}" alt="">
                                </a>
                            </div>
                            <div class="col-md-6 col-sm-7">
                                <form class="form-search" method="get" action="{{url(Request::segment(1).'/search')}}" >
                                    <input type="text" class="form-control" name="text" placeholder="Search ...">
                                    <button type="submit" class="btn btn-search"><i class="zmdi zmdi-search"></i></button>
                                </form>
                            </div>
                            <div class="col-md-3 col-sm-3">
                                <div class="cart-area clearfix">
                                    <div class="mini-cart">
                                        <a href="#" class="mini-cart-link">
                                            <span class="cart-icon"><i class="zmdi zmdi-shopping-cart"></i></span>
                                            <span class="cart-qty">12</span>
                                            <span class="cart-salary">30.00</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="head-nav">
                        <div class="icons-actions-xs clearfix">
                            <div class="mobile-nav-icon js-nav-icon">
                                <i></i>
                                <i></i>
                                <i></i>
                            </div>
                            <span>MENU</span>
                        </div>
                        <ul class="main-menu js-main-nav clearfix">
                            <li><a href="{{url('/')}}">Home</a></li>
                            <li><a href="{{url('/about-us')}}">About Us</a></li>
                            <li><a href="{{url('products')}}">Products</a></li>
                            @if(Auth::check())
                            <li><a href="{{url('/user_profile')}}">Profile</a></li>
                            @endif
                            <li><a href="{{url('/join-us')}}">Join Us</a></li>
                        </ul>
                    </div>
                </div>
            </div>
</header>