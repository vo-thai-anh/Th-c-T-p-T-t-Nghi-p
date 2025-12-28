@extends('admin.admin')

@section('admin_content')
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
    <a href="{{ url()->previous() }}"
        class="inline-flex items-center text-black-600 hover:text-gray-800 mb-4">
        ← Quay lại
    </a>
<h1 class="text-3xl font-bold mb-6 text-gray-800">Sửa thông tài khoản</h1>

<div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-2xl">

    <form action="{{ route('admin.user.updateuser', $user->user_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <label class="block mb-2 font-semibold">Tên Tài Khoản </label>
        <input type="text" name="username" value="{{ $user->username }}"
                class="w-full p-3 border rounded-lg mb-4">

        <label class="block mb-2 font-semibold">Email</label>
        <input type="email" name="email" value="{{ $user->email }}"
                class="w-full p-3 border rounded-lg mb-4">

        <label class="block mb-2 font-semibold">Fullname</label>
        <input type="text" name="fullname" value="{{ $user->fullname }}"
                class="w-full p-3 border rounded-lg mb-4">

        <label class="block mb-2 font-semibold">Số Điện Thoại</label>
        <input type="number" name="phone_number" value="{{ $user->phone_number }}"
                class="w-full p-3 border rounded-lg mb-4">

        <label class="block mb-2 font-semibold">Địa Chỉ</label>
        <input type="text" name="address" value="{{ $user->address }}"
                class="w-full p-3 border rounded-lg mb-4">

        <label class="block mb-2 font-semibold">Vai Trò</label>
        <input type="text" name="role" value="{{ $user->role }}"
                class="w-full p-3 border rounded-lg mb-4">

        <button class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Cập nhật
        </button>
        
    </form>
    <form action="{{ route('admin.user.reset', $user->user_id) }}"
        method="POST"
        class="mt-4"
        onsubmit="return confirm('Reset mật khẩu user này?')">
        @csrf
        @method('PUT')
        <button class="px-6 py-3 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
            Reset password
        </button>
    </form>
</div>

@endsection
