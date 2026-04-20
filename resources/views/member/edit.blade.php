@extends('adminlte::page')

@section('title', 'Edit Member')

@section('content_header')
    <h1 class="font-weight-bold">Edit Member</h1>
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

<div class="card card-modern">

    <div class="card-header bg-white" style="border-bottom:1px solid #eee;">
        <h5 class="mb-0 font-weight-bold">✏️ Form Edit Member</h5>
    </div>

    <div class="card-body">

        <form action="{{ route('member.update', $member->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Pilih Customer</label>

                <select name="customer_id"
                    class="form-control @error('customer_id') is-invalid @enderror"
                    required>

                    @foreach($customers as $c)
                        <option value="{{ $c->id }}"
                            {{ old('customer_id', $member->customer_id) == $c->id ? 'selected' : '' }}>
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

                <button type="submit" class="btn btn-modern btn-save">
                    💾 Update Member
                </button>

            </div>

        </form>

    </div>
</div>

@stop