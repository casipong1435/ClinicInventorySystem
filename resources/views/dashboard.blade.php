@extends('layouts.app')

@section('page-title', 'Inventory')

@section('content')

<input type="checkbox" id="menu-toggle">
    <div class="sidebar">
        <div class="side-header">
            <h3><img src="{{url('/images/logo.jpg')}}" alt="" height="45" width="45" class="mt-2" style="border-radius: 50%"><span></span></h3>
        </div>
        
        <div class="side-content">
            <div class="profile">
                <i class="las la-user-circle profile-img bg-img" style="color: white; font-size: 80px"></i>
                <h4>Clinic Office</h4>
                <small>Admin</small>
            </div>

            <div class="side-menu">
                <ul>
                    <li>
                       <a href="{{ route('home') }}" class="{{ Route::currentRouteName() == 'home' ? 'active':''}}">
                            <span class="las la-home"></span>
                            <small>Inventory</small>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('storage') }}" class="{{ Route::currentRouteName() == 'storage' ? 'active':''}}">
                             <span class="las la-history"></span>
                             <small>Activity</small>
                         </a>
                     </li>
                     <li>
                        <a href="{{ route('account') }}" class="{{ Route::currentRouteName() == 'account' ? 'active':''}}">
                             <span class="las la-user"></span>
                             <small>Account</small>
                         </a>
                     </li>
                     <li>
                        <a href="{{ route('log') }}" class="{{ Route::currentRouteName() == 'log' ? 'active':''}}">
                             <span class="las la-scroll"></span>
                             <small>Logs</small>
                         </a>
                     </li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="main-content">
        
        <header>
            <div class="header-content">
                <label for="menu-toggle">
                    <span class="las la-bars"></span>
                </label>
                
                <div class="header-menu">
                    <div class="user text-danger">
                        <div class="bg-img" style="background-image: url(img/1.jpeg)"></div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <span class="las la-power-off"></span>
                            <input type="submit" value="Logout" class="border-0 bg-transparent text-danger">
                        </form>
                    </div>
                </div>
            </div>
        </header>
        
        
        @yield('dashboard-content')
        
    </div>

@endsection
