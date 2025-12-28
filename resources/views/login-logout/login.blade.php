    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
<form class="logincss" method="POST" action="{{ route('checklogin') }}">
    @csrf
    {{-- HIỂN THỊ LỖI ĐĂNG NHẬP (msg) --}}
    @if(session('msg'))
        <div class="alert alert-danger">
            {{ session('msg') }}
        </div>
    @endif
    @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 mb-4 rounded">
                {{ session('success') }}
            </div>
    @endif

    <span class="member">
        Member Login
    </span>

    {{-- EMAIL --}}
    <div class="email" data-validate="Email is required">
        <input class="input100"
                type="email"
                name="email"
                placeholder="Email..."
                value="{{ old('email') }}">

        <span class="focus-input100"></span>
        <span class="symbol-input100">
            <i class="fa fa-envelope"></i>
        </span>
    </div>

    {{-- HIỂN THỊ LỖI EMAIL --}}
    @error('email')
        <span class="text-danger">{{ $message }}</span>
    @enderror


    {{-- PASSWORD --}}
    <div class="password" data-validate="Password is required">
        <input class="input100" type="password" name="password" placeholder="Password">
        <span class="focus-input100"></span>
        <span class="symbol-input100">
            <i class="fa fa-lock" aria-hidden="true"></i>
        </span>
    </div>

    {{-- HIỂN THỊ LỖI PASSWORD --}}
    @error('password')
        <span class="text-danger">{{ $message }}</span>
    @enderror


    {{-- SUBMIT BUTTON --}}
    <div class="btn-submit">
        <button class="btn btn-primary" type="submit">
            Login
        </button>
    </div>

    {{-- <div class="text-center p-t-12">
        <span class="txt1">
            Forgot
        </span>
        <a class="txt2" href="#">
            Username / Password?
        </a>
    </div> --}}

    <div class="btn-back">
        <a class="txt2" href="{{ url('/') }}">
            Trang Chủ
            <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
        </a>
    </div>
</form>
