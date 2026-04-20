@extends('adminlte::page')

@section('title', 'Tambah Member')

@section('content_header')
    <h1 class="font-weight-bold">Tambah Member</h1>
@stop

@section('content')

<style>
    .card-modern {
        border: none;
        border-radius: 16px;
        box-shadow: 0 6px 18px rgba(0,0,0,0.08);
    }

    label {
        font-weight: 500;
        margin-bottom: 5px;
    }

    .form-control {
        border-radius: 10px;
        font-size: 14px;
    }

    .form-control:focus {
        box-shadow: none;
        border-color: #6366f1;
    }

    .btn-modern {
        border-radius: 10px;
        padding: 6px 16px;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.25s ease;
    }

    .btn-save {
        background-color: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    .btn-save:hover {
        background-color: #166534;
        color: white;
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
</style>

<div class="card card-modern">

    <div class="card-header bg-white" style="border-bottom:1px solid #eee;">
        <h5 class="mb-0 font-weight-bold">⭐ Form Tambah Member</h5>
    </div>

    <div class="card-body">

        <form action="{{ route('member.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Pilih Customer</label>

                <select name="customer_id"
                    class="form-control @error('customer_id') is-invalid @enderror"
                    required>

                    <option value="">-- Pilih Customer --</option>

                    @foreach($customers as $c)
                        <option value="{{ $c->id }}"
                            {{ old('customer_id') == $c->id ? 'selected' : '' }}>
                            {{ $c->name }} {{-- ✅ diperbaiki --}}
                        </option>
                    @endforeach

                </select>

                @error('customer_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between mt-4">

                <a href="{{ route('member.index') }}" class="btn btn-modern btn-back">
                    ← Kembali
                </a>

                <button class="btn btn-modern btn-save">
                    💾 Simpan Member
                </button>

            </div>

        </form>

    </div>
</div>

@stop