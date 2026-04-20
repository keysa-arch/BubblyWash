@extends('adminlte::page')

@section('title', 'Data Customer')

@section('content_header')
    <h1 class="font-weight-bold">Data Customer</h1>
@stop

@section('content')

{{-- ================= STYLE ================= --}}
<style>
    .card-modern {
        border: none;
        border-radius: 16px;
        box-shadow: 0 6px 18px rgba(0,0,0,0.08);
    }

    .btn-modern {
        border-radius: 10px;
        padding: 6px 12px;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.25s ease;
    }

    .btn-add {
        background-color: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    .btn-add:hover {
        background-color: #166534;
        color: white;
    }

    .btn-view {
        background-color: #e0f2fe;
        color: #0369a1;
        border: 1px solid #bae6fd;
    }

    .btn-view:hover {
        background-color: #0369a1;
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

    .table-modern thead {
        background-color: #f8fafc;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table-modern tbody tr:hover {
        background-color: #f1f5f9;
        transition: 0.2s;
    }

    .search-box {
        border-radius: 10px;
        font-size: 14px;
    }
</style>

{{-- ================= CARD ================= --}}
<div class="card card-modern">

    {{-- HEADER --}}
    <div class="card-header bg-white d-flex justify-content-between align-items-center"
         style="border-bottom:1px solid #eee;">

        <h5 class="mb-0 font-weight-bold">🧍 Daftar Customer</h5>

        <a href="{{ route('customer.create') }}" class="btn btn-modern btn-add">
            + Tambah Customer
        </a>
    </div>

    {{-- SEARCH --}}
    <div class="card-body pb-2">

        <form action="{{ route('customer.index') }}" method="GET">
            <div class="input-group">
                <input type="text"
                       name="search"
                       class="form-control search-box"
                       placeholder="Cari nama atau no HP..."
                       value="{{ request('search') }}">

                <div class="input-group-append">
                    <button class="btn btn-modern btn-view" type="submit">
                        🔍 Cari
                    </button>
                </div>
            </div>
        </form>

        {{-- ALERT --}}
        @if(session('success'))
            <div class="alert alert-success mt-3 shadow-sm rounded">
                {{ session('success') }}
            </div>
        @endif

    </div>

    {{-- TABLE --}}
    <div class="card-body table-responsive p-0">

        <table class="table table-hover table-modern text-nowrap">

            <thead class="text-center">
                <tr>
                    <th>No</th>
                    <th class="text-left">Nama Customer</th>
                    <th>No HP</th>
                    <th class="text-left">Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($customers as $key => $customer)
                    <tr class="text-center">

                        <td>{{ $customers->firstItem() + $key }}</td>

                        <td class="text-left font-weight-semibold">
                            {{ $customer->nama_customer }}
                        </td>

                        <td>{{ $customer->no_hp }}</td>

                        <td class="text-left text-muted">
                            {{ $customer->alamat }}
                        </td>

                        <td>

                            {{-- VIEW --}}

                            {{-- EDIT --}}
                            <a href="{{ route('customer.edit', $customer->id) }}"
                               class="btn btn-modern btn-edit btn-sm">
                                ✏️
                            </a>

                            {{-- DELETE --}}
                            <form action="{{ route('customer.destroy', $customer->id) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Yakin hapus data?')">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-modern btn-delete btn-sm">
                                    🗑
                                </button>
                            </form>

                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            Data tidak ditemukan
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>

    </div>

    {{-- PAGINATION --}}
    <div class="card-footer bg-white d-flex justify-content-end">
        {{ $customers->appends(request()->query())->links() }}
    </div>

</div>

@stop