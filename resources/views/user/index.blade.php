@extends('adminlte::page')

@section('title', 'Kelola User')

@section('content_header')
    <h1 class="font-weight-bold">Kelola User</h1>
@stop

@section('content')

{{-- ================= STYLE ================= --}}
<style>
    .card-modern {
        border: none;
        border-radius: 16px;
        box-shadow: 0 6px 18px rgba(0,0,0,0.08);
    }

    .table-modern thead {
        background-color: #f8f9fa;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table-modern tbody tr:hover {
        background-color: #f1f5f9;
        transition: 0.2s;
    }

    /* BUTTON STYLE */
    .btn-modern {
        border-radius: 10px;
        padding: 6px 14px;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.25s ease;
    }

    .btn-add {
        background-color: #f0fdf4;
        color: #16a34a;
        border: 1px solid #bbf7d0;
    }

    .btn-add:hover {
        background-color: #16a34a;
        color: white;
    }

    .btn-edit {
        background-color: #fff7ed;
        color: #ea580c;
        border: 1px solid #fed7aa;
    }

    .btn-edit:hover {
        background-color: #ea580c;
        color: white;
    }

    .btn-delete {
        background-color: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
    }

    .btn-delete:hover {
        background-color: #dc2626;
        color: white;
    }

    .badge-modern {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
    }

    .badge-admin {
        background-color: #fef3c7;
        color: #b45309;
    }

    .badge-superadmin {
        background-color: #fee2e2;
        color: #b91c1c;
    }

    .badge-customer {
        background-color: #e0f2fe;
        color: #0369a1;
    }
</style>

{{-- ================= ALERT ================= --}}
@if(session('success'))
    <div class="alert alert-success rounded shadow-sm">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger rounded shadow-sm">
        {{ session('error') }}
    </div>
@endif

{{-- ================= CARD ================= --}}
<div class="card card-modern">

    {{-- HEADER --}}
    <div class="card-header bg-white d-flex justify-content-between align-items-center" style="border-bottom:1px solid #eee;">
        <h5 class="mb-0 font-weight-bold">👤 Daftar User</h5>

        <a href="{{ route('user.create') }}" class="btn btn-modern btn-add">
            + Tambah User
        </a>
    </div>

    {{-- BODY --}}
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-modern align-middle">

                <thead class="text-center">
                    <tr>
                        <th>No</th>
                        <th class="text-left">Nama</th>
                        <th class="text-left">Email</th>
                        <th>Role</th>
                        <th>Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($users as $i => $user)
                        <tr class="text-center">

                            <td>{{ $users->firstItem() + $i }}</td>

                            <td class="text-left font-weight-semibold">
                                {{ $user->name }}
                            </td>

                            <td class="text-left text-muted">
                                {{ $user->email }}
                            </td>

                            {{-- ROLE --}}
                            <td>
                                @if($user->role === 'superadmin')
                                    <span class="badge-modern badge-superadmin">Superadmin</span>
                                @elseif($user->role === 'admin')
                                    <span class="badge-modern badge-admin">Admin</span>
                                @else
                                    <span class="badge-modern badge-customer">Customer</span>
                                @endif
                            </td>

                            <td>
                                <small class="text-muted">
                                    {{ $user->created_at->format('d M Y') }}
                                </small>
                            </td>

                            {{-- ACTION --}}
                            <td>
                                <a href="{{ route('user.edit', $user) }}"
                                   class="btn btn-modern btn-edit btn-sm">
                                    Edit
                                </a>

                                <form action="{{ route('user.destroy', $user) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin hapus user ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-modern btn-delete btn-sm">
                                        Hapus
                                    </button>
                                </form>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Belum ada user
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>

    {{-- FOOTER --}}
    <div class="card-footer d-flex justify-content-between align-items-center bg-white">
        <small class="text-muted">
            Total: {{ $users->count() }} user
        </small>

        {{ $users->links() }}
    </div>

</div>

@stop