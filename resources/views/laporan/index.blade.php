@extends('adminlte::page')

@section('title', 'Laporan')

@section('content_header')
    <h1 class="font-weight-bold">Laporan</h1>
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
        background-color: #f8fafc;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table-modern tbody tr:hover {
        background-color: #f1f5f9;
        transition: 0.2s;
    }

    .text-money {
        font-weight: 500;
        color: #16a34a;
    }

    .date-text {
        color: #64748b;
        font-size: 13px;
    }
</style>

{{-- ================= CARD ================= --}}
<div class="card card-modern">

    {{-- HEADER --}}
    <div class="card-header bg-white"
         style="border-bottom:1px solid #eee;">

        <h5 class="mb-0 font-weight-bold">📊 Data Laporan Transaksi</h5>

    </div>

    {{-- TABLE --}}
    <div class="card-body table-responsive p-0">

        <table class="table table-hover table-modern text-nowrap">

            <thead class="text-center">
                <tr>
                    <th>No</th>
                    <th class="text-left">Customer</th>
                    <th class="text-left">Service</th>
                    <th>Total</th>
                    <th>Tanggal</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($transaksis as $index => $t)
                    <tr class="text-center">

                        <td>{{ $index + 1 }}</td>

                        <td class="text-left font-weight-semibold">
                            {{ $t->customer->name }}  {{-- ✅ diperbaiki --}}
                        </td>

                        <td class="text-left">
                            {{ $t->service->name }}   {{-- ✅ diperbaiki --}}
                        </td>

                        <td class="text-money">
                            Rp {{ number_format($t->total, 0, ',', '.') }}
                        </td>

                        <td class="date-text">
                            {{ $t->created_at->format('d-m-Y') }}
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            Data laporan tidak ditemukan
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>

    </div>

</div>

@stop