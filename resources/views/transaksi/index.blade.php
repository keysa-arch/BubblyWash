@extends('adminlte::page')

@section('title', 'Data Transaksi')

@section('content_header')
    <h1 class="font-weight-bold">Data Transaksi</h1>
@stop

@section('content')

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
        transition: 0.25s;
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

    .status-process  { background: #fef3c7; color: #92400e; padding: 4px 8px; border-radius: 8px; font-size: 12px; }
    .status-done     { background: #dcfce7; color: #166534; padding: 4px 8px; border-radius: 8px; font-size: 12px; }
    .status-picked_up { background: #e0f2fe; color: #0369a1; padding: 4px 8px; border-radius: 8px; font-size: 12px; }

    .money {
        font-weight: 500;
        color: #16a34a;
    }
</style>

<div class="card card-modern">

    <div class="card-header bg-white d-flex justify-content-between align-items-center"
         style="border-bottom:1px solid #eee;">

        <h5 class="mb-0 font-weight-bold">🧺 Daftar Transaksi</h5>

        <a href="{{ route('transaksi.create') }}" class="btn btn-modern btn-add">
            + Tambah Transaksi
        </a>

    </div>

    <div class="card-body pb-2">

        <form method="GET" action="{{ route('transaksi.index') }}">
            <div class="input-group">
                <input type="text"
                       name="search"
                       class="form-control search-box"
                       placeholder="Cari customer..."
                       value="{{ request('search') }}">

                <div class="input-group-append">
                    <button class="btn btn-modern btn-add">
                        🔍 Cari
                    </button>
                </div>
            </div>
        </form>

        @if(session('success'))
            <div class="alert alert-success mt-3 shadow-sm rounded">
                {{ session('success') }}
            </div>
        @endif

    </div>

    <div class="card-body table-responsive p-0">

        <table class="table table-hover table-modern text-nowrap">

            <thead class="text-center">
                <tr>
                    <th>No</th>
                    <th class="text-left">Customer</th>
                    <th class="text-left">Service</th>
                    <th>Qty</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($transaksis as $key => $t)
                    <tr class="text-center">

                        <td>{{ $transaksis->firstItem() + $key }}</td>

                        <td class="text-left font-weight-semibold">
                            {{ $t->customer->name }} {{-- ✅ diperbaiki --}}
                        </td>

                        <td class="text-left">
                            {{ $t->service->name }} {{-- ✅ diperbaiki --}}
                        </td>

                        <td>{{ $t->qty }}</td>

                        <td class="money">
                            Rp {{ number_format($t->total) }}
                        </td>

                        <td>
                            @if($t->status == 'process') {{-- ✅ diperbaiki --}}
                                <span class="status-process">Proses</span>
                            @elseif($t->status == 'done') {{-- ✅ diperbaiki --}}
                                <span class="status-done">Selesai</span>
                            @else
                                <span class="status-picked_up">Diambil</span>
                            @endif
                        </td>

                        <td>

                            <a href="{{ route('transaksi.edit', $t->id) }}"
                               class="btn btn-modern btn-edit btn-sm">
                                ✏️
                            </a>

                            <form action="{{ route('transaksi.destroy', $t->id) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Hapus data?')">

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
                        <td colspan="7" class="text-center text-muted py-4">
                            Data transaksi tidak ditemukan
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>

    </div>

    <div class="card-footer bg-white d-flex justify-content-end">
        {{ $transaksis->links() }}
    </div>

</div>

@stop