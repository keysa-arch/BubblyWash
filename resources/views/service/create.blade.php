@extends('adminlte::page')

@section('title', 'Tambah Service')

@section('content_header')
    <h1 class="font-weight-bold">Tambah Service</h1>
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
        <h5 class="mb-0 font-weight-bold">🧺 Form Tambah Service</h5>
    </div>

    <div class="card-body">

        <form action="{{ route('service.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Nama Layanan</label>
                <input type="text" name="name" {{-- ✅ diperbaiki --}}
                    class="form-control"
                    required>
            </div>

            <div class="form-group">
                <label>Harga</label>
                <input type="number" name="price" {{-- ✅ diperbaiki --}}
                    class="form-control"
                    required>
            </div>

            <div class="form-group">
                <label>Satuan</label>
                <select name="unit" class="form-control" required> {{-- ✅ diperbaiki --}}
                    <option value="">-- Pilih Satuan --</option>
                    <option value="kg">Kg</option>
                    <option value="pasang">Pasang</option>
                </select>
            </div>

            <div class="d-flex justify-content-between mt-4">

                <a href="{{ route('service.index') }}" class="btn btn-modern btn-back">
                    ← Kembali
                </a>

                <button class="btn btn-modern btn-save">
                    💾 Simpan Service
                </button>

            </div>

        </form>

    </div>
</div>

@stop