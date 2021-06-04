<div class="iq-sidebar  sidebar-default ">
    <div class="iq-sidebar-logo d-flex align-items-center justify-content-between">
        <a href="{{url('/home')}}" class="header-logo">
            <img src="{{ asset('web_assets/images/logo.png') }}" class="img-fluid rounded-normal light-logo"
                 alt="logo">
            <img src="{{ asset('web_assets/images/logo-white.png') }}"
                 class="img-fluid rounded-normal darkmode-logo" alt="logo">
        </a>
        <div class="iq-menu-bt-sidebar">
            <i class="las la-bars wrapper-menu"></i>
        </div>
    </div>
    <div class="data-scrollbar" data-scroll="1">
        <nav class="iq-sidebar-menu">
            <ul id="iq-sidebar-toggle" class="iq-menu">
                <li class=" ">
                    <a href="{{url('/home')}}" class="collapsed">
                        <i class="las la-home"></i><span>Home</span>
                    </a>
                </li>
            </ul>
        </nav>
        {{--        <div id="sidebar-bottom" class="position-relative sidebar-bottom">--}}
        {{--            <div class="card bg-primary rounded">--}}
        {{--                <div class="card-body">--}}
        {{--                    <div class="sidebarbottom-content">--}}
        {{--                        <div class="image"><img src="{{ asset('web_assets/images/layouts/side-bkg.png') }}"--}}
        {{--                                                class="img-fluid" alt="side-bkg"></div>--}}
        {{--                        <h5 class="mb-3 text-white mt-3">Did you Know ?</h5>--}}
        {{--                        <p class="mb-0 text-white">You can add additional user in your Account's Settings</p>--}}
        {{--                        <button type="button" class="btn bg-light  mt-3"><i class="fas fa-plus-square"></i> New--}}
        {{--                            Program--}}
        {{--                        </button>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>--}}
        <div class="p-3"></div>
    </div>
</div>
