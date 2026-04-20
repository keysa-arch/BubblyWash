@extends('adminlte::page')

@section('title', 'Edit Service')

@section('content_header')
    <h1 class="font-weight-bold">Edit Service</h1>
@stop

@section('content')

{{-- ================= STYLE ================= --}}
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

    /* BUTTON */
    .btn-modern {
        border-radius: 10px;
        padding: 6px 16px;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.25s ease;
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

{{-- ================= CARD ================= --}}
<div class="card card-modern">

    {{-- HEADER --}}
    <div class="card-header bg-white" style="border-bottom:1px solid #eee;">
        <h5 class="mb-0 font-weight-bold">✏️ Form Edit Service</h5>
    </div>

    {{-- BODY --}}
    <div class="card-body">

        <form action="{{ route('service.update', $service->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- NAMA LAYANAN --}}
            <div class="form-group">
                <label>Nama Layanan</label>
                <input type="text" name="nama_layanan"
                    class="form-control"
                    value="{{ $service->nama_layanan }}"
                    required>
            </div>

            {{-- HARGA --}}
            <div class="form-group">
                <label>Harga</label>
                <input type="number" name="harga"
                    class="form-control"
                    value="{{ $service->harga }}"
                    required>
            </div>

            {{-- SATUAN --}}
            <div class="form-group">
                <label>Satuan</label>
                <select name="satuan" class="form-control" required>

                    <option value="kg" {{ $service->satuan == 'kg' ? 'selected' : '' }}>
                        Kg
                    </option>

                    <option value="pcs" {{ $service->satuan == 'pcs' ? 'selected' : '' }}>
                        Pcs
                    </option>

                    <option value="pasang" {{ $service->satuan == 'pasang' ? 'selected' : '' }}>
                        Pasang
                    </option>

                </select>
            </div>

            {{-- BUTTON --}}
            <div class="d-flex justify-content-between mt-4">

                <a href="{{ route('service.index') }}" class="btn btn-modern btn-back">
                    ← Kembali
                </a>

                <button class="btn btn-modern btn-save">
                    💾 Update Service
                </button>

            </div>

        </form>

    </div>
</div>

@stop