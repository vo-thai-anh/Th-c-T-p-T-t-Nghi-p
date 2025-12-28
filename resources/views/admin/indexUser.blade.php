@extends('admin.admin')
@section('page_title', 'Quản Lý Tài khoản')
@section('admin_content')

                @if(session('error'))
                        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                            {{ session('error') }}
                        </div>
                @endif
                @if (session('success'))
                    <div class="bg-green-100 text-green-800 p-3 mb-4 rounded">
                        {{ session('success') }}
                    </div>
                @endif
            

<h1 class="text-3xl font-bold mb-6">Quản lý Tài khoản</h1>
<a href="{{ route('admin.products.create') }}"
    class="px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-pink-700 transition">
    + Thêm Tài Khoản Mới
</a>

<table class="w-full border mt-6">
    <thead class="bg-gray-100">
        <tr>
            <th class="p-3">ID</th>
            <th class="p-3">Username</th>
            <th class="p-3">Email</th>
            <th class="p-3">Role</th>
            <th class="p-3">Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($user as $u)
        <tr class="border-b">
            <td class="p-3">{{ $u->user_id }}</td>
            <td class="p-3">{{ $u->username }}</td>
            <td class="p-3">{{ $u->email }}</td>
            <td class="p-3">{{ $u->phone_number }}</td>
            <td class="p-3">
                <span class="px-2 py-1 rounded
                    {{ $u->role == 'admin' ? 'bg-red-200 text-red-800' : 'bg-blue-200 text-blue-800' }}">
                    {{ $u->role }}
                </span>
            </td>
            <td class="p-3" style="display: flex; gap: 10px; align-items: center;height: 100%">
                <form action="{{ route('admin.user.deleteuser', $u->user_id) }}"
                        method="POST" class="inline-block"
                        onsubmit="return confirm('Xóa user này?')">
                    @csrf
                    @method('DELETE')
                    <button class="px-3 py-2 bg-red-600 text-white rounded">
                        Xóa
                    </button>
                </form>
                <a href="{{ route('admin.user.edit', $u->user_id) }}"
                    class="px-3 py-2 bg-yellow-500 text-white rounded">
                    Sửa
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-4">
    {{ $user->links() }}
</div>

@endsection
