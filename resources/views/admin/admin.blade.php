<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Flower Shop</title>
    <!-- Tải Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; }
    </style>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/flower.png') }}">
</head>

<body class="flex h-screen">

    <!-- Sidebar (Thanh điều hướng bên trái) -->
    <aside class="w-64 bg-gray-800 text-white flex flex-col shadow-lg">
        <div class="p-6 text-2xl font-bold text-pink-300 border-b border-gray-700">
            Flower Admin
        </div>
        <nav class="flex-grow p-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center p-3 rounded-lg bg-pink-700 text-white shadow-md transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
                Dashboard
            </a>
            <a href="{{ route('admin.products.indexProduct') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor"><path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2V5z"/><path d="M15 7v1a2 2 0 01-2 2h-1A2 2 0 0110 7V5a2 2 0 012-2h1a2 2 0 012 2v2zm-2 0h1V5h-1v2z"/></svg>
                Quản lý Sản phẩm
            </a>
            <a href="{{ route('admin.order.indexOrder') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 1 1 0 000 2.002H6a1 1 0 000 2.002h2a1 1 0 000 2.002h2a1 1 0 000 2.002h2a1 1 0 000 2.002h2a2 2 0 012 2v2a2 2 0 01-2 2H4a2 2 0 01-2-2V7a2 2 0 012-2zm2 2a1 1 0 00-1 1v4a1 1 0 002 0V8a1 1 0 00-1-1zm4 0a1 1 0 00-1 1v4a1 1 0 002 0V8a1 1 0 00-1-1zm4 0a1 1 0 00-1 1v4a1 1 0 002 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                Quản lý Đơn hàng
            </a>
            <a href="{{ route('admin.user.indexUser') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zm-7 9a1 1 0 100-2 1 1 0 000 2zm7 0a1 1 0 100-2 1 1 0 000 2zm-5 0a1 1 0 100-2 1 1 0 000 2z"/><path d="M14 19a1 1 0 01-1 1H7a1 1 0 01-1-1v-2a1 1 0 011-1h6a1 1 0 011 1v2z"/></svg>
                Quản lý tài khoản
            </a>
            <a href="{{ route('admin.payment.indexPayment') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zm-7 9a1 1 0 100-2 1 1 0 000 2zm7 0a1 1 0 100-2 1 1 0 000 2zm-5 0a1 1 0 100-2 1 1 0 000 2z"/><path d="M14 19a1 1 0 01-1 1H7a1 1 0 01-1-1v-2a1 1 0 011-1h6a1 1 0 011 1v2z"/></svg>
                Quản lý thanh toán
            </a>
            <a href="{{ route('admin.order.indexbill') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-700 transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zm-7 9a1 1 0 100-2 1 1 0 000 2zm7 0a1 1 0 100-2 1 1 0 000 2zm-5 0a1 1 0 100-2 1 1 0 000 2z"/><path d="M14 19a1 1 0 01-1 1H7a1 1 0 01-1-1v-2a1 1 0 011-1h6a1 1 0 011 1v2z"/></svg>
                Quản lý hóa đơn
            </a>
        </nav>

        <!-- Nút Đăng xuất -->
        <div class="p-4 border-t border-gray-700">
                        <form method="GET" action="{{ Route('home') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center p-3 text-red-400 bg-gray-700 rounded-lg hover:bg-gray-600 transition duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10 5a1 1 0 00-1 1v3a1 1 0 102 0V9a1 1 0 00-1-1zM9 9a1 1 0 000 2h7a1 1 0 100-2H9z" clip-rule="evenodd"/></svg>
                    Trang Chủ
                </button>
            </form>
            <hr>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center p-3 text-red-400 bg-gray-700 rounded-lg hover:bg-gray-600 transition duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10 5a1 1 0 00-1 1v3a1 1 0 102 0V9a1 1 0 00-1-1zM9 9a1 1 0 000 2h7a1 1 0 100-2H9z" clip-rule="evenodd"/></svg>
                    Đăng xuất
                </button>
            </form>
        </div>
    </aside>

    <!-- Content (Nội dung chính) -->
    <main class="flex-1 overflow-y-auto p-8">
    <div class="bg-white shadow px-8 py-4 flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-700">
            @yield('page_title', 'Dashboard')
        </h2>

        <div class="flex items-center gap-4">
            <span class="text-gray-600">
                Xin chào, <strong>{{ Auth::user()->username ?? 'Admin' }}</strong>
            </span>
            <img src="https://ui-avatars.com/api/?name=Admin&background=f472b6&color=fff"
                class="w-10 h-10 rounded-full shadow">
        </div>
    </div>
    

    {{-- Nội dung --}}
    <div class="p-8 bg-gray-100 flex-1">
        @yield('admin_content')
    </div>
    </main>

</body>
</html>