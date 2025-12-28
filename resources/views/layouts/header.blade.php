<style>
    .search-box {
        position: relative;
    }

    .search-btn {
        position: absolute;
        right: 0;
        top: 0;
        height: 100%;
        background: none;
        border: none;
        cursor: pointer;
        padding: 0 10px;
        pointer-events: none;
    }
</style>

<header class="header">
        <div class="container">
            <nav class="navbar">
                <div class="logo">
                    <a href="#">FIORELLO</a>
                </div>
                <ul class="nav-menu">
                    <li><a href="{{ url('/') }}" class="active">HOME</a></li>
                    <li><a href="{{ url('https://www.facebook.com/anhthai.141693') }}" target="_blank">FB</a></li>
                    <li><a href="{{ url('https://www.instagram.com/4_th6_04/') }}">Instagram</a></li>
                    <li><a href="{{ url('https://www.threads.com/@4_th6_04') }}">Threads</a></li>
                    {{-- <li class="dropdown">
                        <a href="#">Danh Mục</a>
                        <ul class="dropdown-menu">
                            @foreach($cate as $cat)
                                <li><a href="{{ url('/DanhMuc/'.$cat->id) }}">{{ $cat->name }}</a></li>
                            @endforeach
                        </ul>
                    </li> --}}
                </ul>

        <div class="nav-icons">
            <form action="{{ route('search') }}" method="GET" class="hidden sm:block">
                <div class="search-box" border="1">
                    <input class="btn btn-danger"
                        type="text"
                        name="search"
                        placeholder="Tìm hoa..."
                        value="{{ request('search') }}">
                    <button type="submit" class="search-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25px" height="25px" viewBox="0 0 512 512"><title>ionicons-v5-f</title><path d="M221.09,64A157.09,157.09,0,1,0,378.18,221.09,157.1,157.1,0,0,0,221.09,64Z" style="fill:none;stroke:#000000;stroke-miterlimit:10;stroke-width:32px"/><line x1="338.29" y1="338.29" x2="448" y2="448" style="fill:none;stroke:#000000;stroke-linecap:round;stroke-miterlimit:10;stroke-width:32px"/></svg>
                    </button>
                </div>
            </form>
                <div class="cart-info">
                    <a href="{{ route('cartitems') }}" > <span>&#x1F6D2;</span> CART </a>
                </div>
        </div>

                @guest
                    <div class="nav-icons">
                    <div class="cart-info">
                        <a href="{{ route('login') }}"> đăng nhập </a>
                    </div>
                </div>
                    <div class="nav-icons">
                    <div class="cart-info">
                        <a href="{{ route('register') }}"> đăng ký </a>
                    </div>
                </div>
                @endguest

                @auth
                <span>Xin chào, {{ Auth::user()->username }}</span>
                    @if(Auth::user()->isuser())
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">Đăng xuất</button>
                        </form>
                    @endif
                    @if(Auth::user()->isadmin())
                        <form method="GET" action="{{ route('admin.dashboard') }}">
                            @csrf
                            <button type="submit"> DASHBOARD </button>
                        </form>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">Đăng xuất</button>
                        </form>
                    @endif
                @endauth
            </nav>
        </div>
</header>