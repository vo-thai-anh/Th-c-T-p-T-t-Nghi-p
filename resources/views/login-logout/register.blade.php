<link rel="stylesheet" href="{{ asset('css/register.css') }}">
    @if ($errors->any())
            <div class="bg-red-100 text-red-800 p-3 mb-4 rounded">
                <ul>
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif
<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100">
            
            {{-- Form POST đến Route xử lý đăng ký (register.store) --}}
            <form class="login100-form validate-form" method="POST" action="{{ route('acpregister') }}">
                @csrf
                
                <span class="login100-form-title">
                    TẠO TÀI KHOẢN MỚI
                </span>

                {{-- 1. USERNAME --}}
                @error('username')
                    <span class="text-danger" style="font-size: 14px;">{{ $message }}</span>
                @enderror
                <div class="wrap-input100 validate-input" data-validate="Tên đăng nhập là bắt buộc">
                    <input class="input100" type="text" name="username" placeholder="Tên đăng nhập (Username)" value="{{ old('username') }}" required autofocus>
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <i class="fa fa-user"></i>
                    </span>
                </div>
                

                {{-- 2. EMAIL --}}
                 @error('email')
                    <span class="text-danger" style="font-size: 14px;">{{ $message }}</span>
                @enderror
                <div class="wrap-input100 validate-input " data-validate="Email hợp lệ là bắt buộc">
                    <input class="input100" type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <i class="fa fa-envelope"></i>
                    </span>
                </div>
               

                {{-- 3. PASSWORD --}}
                @error('password')
                    <span class="text-danger" style="font-size: 14px;">{{ $message }}</span>
                @enderror
                <div class="wrap-input100 validate-input " data-validate="Mật khẩu là bắt buộc">
                    <input class="input100" type="password" name="password" placeholder="Mật khẩu" required>
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <i class="fa fa-lock" aria-hidden="true"></i>
                    </span>
                </div>
                

                {{-- 4. PASSWORD CONFIRMATION --}}
                <div class="wrap-input100 validate-input" data-validate="Xác nhận mật khẩu">
                    <input class="input100" type="password" name="password_confirmation" placeholder="Xác nhận mật khẩu" required>
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <i class="fa fa-lock" aria-hidden="true"></i>
                    </span>
                </div>

                {{-- 5. FULL NAME (Tùy chọn) --}}
                @error('fullname')
                    <span class="text-danger" style="font-size: 14px;">{{ $message }}</span>
                @enderror
                <div class="wrap-input100 validate-input ">
                    <input class="input100" type="text" name="fullname" placeholder="Họ và tên" value="{{ old('fullname') }}">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <i class="fa fa-id-badge"></i>
                    </span>
                </div>
                
                
                {{-- 6. PHONE NUMBER (Tùy chọn) --}}
                @error('phone_number')
                    <span class="text-danger" style="font-size: 14px;">{{ $message }}</span>
                @enderror
                <div class="wrap-input100 validate-input ">
                    <input class="input100" type="text" name="phone_number" placeholder="Số điện thoại" value="{{ old('phone_number') }}">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <i class="fa fa-phone"></i>
                    </span>
                </div>
                {{-- 7. ADDRESS (Tùy chọn) --}}
                @error('address')
                    <span class="text-danger" style="font-size: 14px;">{{ $message }}</span>
                @enderror
                <div class="wrap-input100 validate-input ">
                    <input class="input100" type="text" name="address" placeholder="Địa chỉ" value="{{ old('address') }}">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
                        <i class="fa fa-map-marker"></i>
                    </span>
                </div>
                

                <div class="container-login100-form-btn">
                    <button class="login100-form-btn" type="submit">
                        ĐĂNG KÝ
                    </button>
                </div>

                <div class="text-center p-t-136">
                    <a class="txt2" href="{{ route('login') }}">
                        Bạn đã có tài khoản? Đăng nhập ngay
                        <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>