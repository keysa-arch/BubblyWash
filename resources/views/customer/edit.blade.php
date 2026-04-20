@extends('adminlte::page')

@section('title', 'Edit Customer')

@section('content_header')
    <h1 class="font-weight-bold">Edit Customer</h1>
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
        <h5 class="mb-0 font-weight-bold">✏️ Form Edit Customer</h5>
    </div>

    {{-- BODY --}}
    <div class="card-body">

        <form action="{{ route('customer.update', $customer->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- NAMA --}}
            <div class="form-group">
                <label for="name">Nama Customer</label>
                <input type="text" name="name"
                    class="form-control @error('name') is-invalid @enderror"
                    id="name"
                    value="{{ old('name', $customer->name) }}" required>

                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- NO HP --}}
            <div class="form-group">
                <label for="phone">No HP</label>
                <input type="text" name="phone"
                    class="form-control @error('phone') is-invalid @enderror"
                    id="phone"
                    value="{{ old('phone', $customer->phone) }}" required>

                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- ALAMAT --}}
            <div class="form-group">
                <label for="address">Alamat</label>
                <textarea name="address"
                    class="form-control @error('address') is-invalid @enderror"
                    id="address" required>{{ old('address', $customer->address) }}</textarea>

                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- BUTTON --}}
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('customer.index') }}" class="btn btn-modern btn-back">
                    ← Kembali
                </a>

                <button type="submit" class="btn btn-modern btn-save">
                    💾 Update
                </button>
            </div>

        </form>

    </div>
</div>

@stop