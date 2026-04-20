@extends('adminlte::page')

@section('title', 'Edit User')

@section('content_header')
    <h1 class="font-weight-bold">Edit User</h1>
@stop

@section('content')

{{-- ================= STYLE ================= --}}
<style>
    .card-modern {
        border: none;
        border-radius: 16px;
        box-shadow: 0 6px 18px rgba(0,0,0,0.08);
    }

    .form-control {
        border-radius: 10px;
        font-size: 14px;
    }

    .form-control:focus {
        box-shadow: none;
        border-color: #6366f1;
    }

    label {
        font-weight: 500;
        margin-bottom: 5px;
    }

    /* BUTTON */
    .btn-modern {
        border-radius: 10px;
        padding: 6px 16px;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.25s ease;
    }

    .btn-back {
        background-color: #f1f5f9;
        color: #334155;
        border: 1px solid #e2e8f0;
    }

    .btn-back:hover {
        background-color: #334155;
        color: white;
    }

    .btn-save {
        background-color: #fef3c7;
        color: #b45309;
        border: 1px solid #fde68a;
    }

    .btn-save:hover {
        background-color: #b45309;
        color: white;
    }
</style>

{{-- ================= CARD ================= --}}
<div class="card card-modern">

    {{-- HEADER --}}
    <div class="card-header bg-white" style="border-bottom:1px solid #eee;">
        <h5 class="mb-0 font-weight-bold">✏️ Form Edit User</h5>
    </div>

    {{-- BODY --}}
    <div class="card-body">

        <form action="{{ route('user.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- NAMA --}}
            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="name"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $user->name) }}" required>

                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- EMAIL --}}
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email"
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email', $user->email) }}" required>

                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- ROLE --}}
            <div class="form-group">
                <label>Role</label>
                <select name="role"
                    class="form-control @error('role') is-invalid @enderror" required>

                    <option value="superadmin" {{ $user->role == 'superadmin' ? 'selected' : '' }}>
                        Superadmin
                    </option>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>
                        Admin
                    </option>
                    <option value="customer" {{ $user->role == 'customer' ? 'selected' : '' }}>
                        Customer
                    </option>
                </select>

                @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- PASSWORD --}}
            <div class="form-group">
                <label>Password Baru 
                    <small class="text-muted">(opsional)</small>
                </label>

                <input type="password" name="password"
                    class="form-control @error('password') is-invalid @enderror">

                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- KONFIRMASI --}}
            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation"
                    class="form-control">
            </div>

            {{-- BUTTON --}}
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('user.index') }}" class="btn btn-modern btn-back">
                    ← Kembali
                </a>

                <button type="submit" class="btn btn-modern btn-save">
                    💾 Simpan Perubahan
                </button>
            </div>

        </form>

    </div>
</div>

@stop