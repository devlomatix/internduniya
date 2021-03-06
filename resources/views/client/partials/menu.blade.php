<div class="responsive-header">

    <div class="responsive-menubar">
        <div class="res-logo mt-2"><a href="index.html" title=""><img src="{{setting('app_icon')}}" alt="" /></a></div>
        <div class="menu-resaction">
            <div class="res-openmenu">
                <img src="" alt="" /> Menu
            </div>
            <div class="res-closemenu">
                <img src="" alt="" /> Close
            </div>
        </div>
    </div>


    <div class="responsive-opensec">
        <div class="btn-extars">
        @if(Auth::user())
            @if(Auth::user()->role == 'student')
                <a href="#" title="" class="post-job-btn"><i class="la la-plus"></i>Get Internship</a>
            @else
                <a href="{{route('company.internship.new')}}" title="" class="post-job-btn"><i class="la la-plus"></i>Post Internship</a>
            @endif
            
        @else
            <a href="{{route('app.internships',['category'=>'all'])}}" title="" class="post-job-btn"><i class="la la-plus"></i>Get Internship</a>
        @endif
            
        </div><!-- Btn Extras -->
       
        <div class="responsivemenu">
            <ul>
                <li class="">
                    <a href="{{route('app.home')}}" title="">Home</a>
                </li>
                <li class="">
                    <a href="{{route('app.blogs')}}" title="">News</a>
                </li>

                @if(!Auth::user()) 
                    <li class="">
                        <a href="{{route('register')}}" title=""><i class="la la-key"></i> Sign Up</a>
                    </li>
                    <li class="">
                        <a href="{{route('login')}}" title=""><i class="la la-external-link-square"></i> Login</a>
                    </li>
                @endif

                @if(Auth::user())
                    
                    <li class="">
                        <a href="{{route('app.user.dashboard')}}" title=""></i>Dashboard</a>
                    </li>

                    <!-- <li class="">
                        <a title=""></i>{{auth()->user()->firstName}}, {{auth()->user()->lastName}}</a>
                    </li> -->

                    <li class="">
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout').submit();"><i class="la la-external-link-square"></i> Logout</a>
                        <form id="logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                @endif
                
            </ul>
        </div>
    </div>

</div>
	
<header class="stick-top forsticky">
    <div class="menu-sec">
        <div class="container">
            <div class="logo">
                <a href="{{route('app.home')}}" title="">
                    <img class="showsticky" src="{{setting('app_icon')}}" alt="" height="30"/>
                    <img class="hidesticky" src="{{setting('app_icon')}}" alt="" height="30" />
                </a>
            </div><!-- Logo -->
            <div class="btn-extars">

                @if(Auth::user())
                    @if(Auth::user()->role == 'student')
                        <a href="{{route('app.internships',['category'=>'all'])}}" title="" class="post-job-btn"><i class="la la-plus"></i>Get Internship</a>
                    @else
                        <a href="{{route('company.internship.new')}}" title="" class="post-job-btn"><i class="la la-plus"></i>Post Internship</a>
                    @endif
                    
                @else
                    <a href="#" title="" class="post-job-btn"><i class="la la-plus"></i>Get Internship</a>
                @endif

                <ul class="account-btns">
                    @if(!Auth::user()) 
                    <li class="">
                        <a href="{{route('register')}}" title=""><i class="la la-key"></i> Sign Up</a>
                    </li>
                    <li class="">
                        <a href="{{route('login')}}" title=""><i class="la la-external-link-square"></i> Login</a>
                    </li>
                    @endif

                    @if(Auth::user())
                    
                    <li class="">
                        <a href="{{route('app.user.dashboard')}}" title=""></i>Dashboard</a>
                    </li>

                    <li class="">
                        <a title=""></i>{{auth()->user()->firstName ? auth()->user()->firstName : ""}} {{auth()->user()->lastName ? auth()->user()->lastName : ""}}</a>
                    </li>

                    <li class="">
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout').submit();"><i class="la la-external-link-square"></i> Logout</a>
                        <form id="logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                    @endif
                </ul>

            </div><!-- Btn Extras -->
            <nav>
                <ul>
                <li class="">
                        <a href="{{route('app.home')}}" title="">Home</a>
                    </li>

                    <li class="">
                        <a href="{{route('app.blogs')}}" title="">News</a>
                    </li>

                    <!-- <li class="">
                        <a href="{{route('app.subscriptions')}}" title="">Pricing</a>
                    </li> -->
                </ul>
            </nav><!-- Menus -->
        </div>
    </div>
</header>