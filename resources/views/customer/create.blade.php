@extends('adminlte::page')

@section('title', 'Tambah Customer')

@section('content_header')
    <h1 class="font-weight-bold">Tambah Customer</h1>
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

    textarea.form-control {
        min-height: 90px;
        resize: none;
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
        background-color: #dbeafe;
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
    }

    .btn-save:hover {
        background-color: #1d4ed8;
        color: white;
    }
</style>

{{-- ================= CARD ================= --}}
<div class="card card-modern">

    {{-- HEADER --}}
    <div class="card-header bg-white" style="border-bottom:1px solid #eee;">
        <h5 class="mb-0 font-weight-bold">➕ Form Tambah Customer</h5>
    </div>

    {{-- BODY --}}
    <div class="card-body">

        <form action="{{ route('customer.store') }}" method="POST">
            @csrf 

            {{-- NAMA --}}
            <div class="form-group">
                <label for="nama_customer">Nama Customer</label>
                <input type="text" name="nama_customer" 
                    class="form-control @error('nama_customer') is-invalid @enderror" 
                    id="nama_customer"
                    value="{{ old('nama_customer') }}" required>

                @error('nama_customer')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- NO HP --}}
            <div class="form-group">
                <label for="no_hp">No HP</label>
                <input type="text" name="no_hp" 
                    class="form-control @error('no_hp') is-invalid @enderror" 
                    id="no_hp"
                    value="{{ old('no_hp') }}" required>

                @error('no_hp')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- ALAMAT --}}
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea name="alamat"
                    class="form-control @error('alamat') is-invalid @enderror"
                    id="alamat" required>{{ old('alamat') }}</textarea>

                @error('alamat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- BUTTON --}}
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('customer.index') }}" class="btn btn-modern btn-back">
                    ← Kembali
                </a>

                <button type="submit" class="btn btn-modern btn-save">
                    💾 Simpan
                </button>
            </div>

        </form>

    </div>
</div>

@stop