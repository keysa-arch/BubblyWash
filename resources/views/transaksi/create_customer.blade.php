@extends('adminlte::page')

@section('title', 'Pesan Laundry')

@section('content_header')
    <h1 class="font-weight-bold">Pesan Laundry</h1>
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
        padding: 8px 16px;
        font-size: 14px;
        font-weight: 500;
        transition: 0.25s;
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

    .total-box {
        background: #f8fafc;
        font-weight: bold;
        color: #16a34a;
    }
</style>

<div class="card card-modern">

    <div class="card-header bg-white" style="border-bottom:1px solid #eee;">
        <h5 class="mb-0 font-weight-bold">🧺 Form Pesan Laundry</h5>
    </div>

    <div class="card-body">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ✅ route customer --}}
        <form action="{{ route('customer.transaksi.store') }}" method="POST">
            @csrf

            <input type="hidden" name="customer_id"
                   value="{{ optional(auth()->user()->customer)->id }}">

            <div class="form-group">
                <label>Pilih Service</label>
                <select name="service_id" id="service_id"
                        class="form-control" required>
                    <option value="">-- Pilih Service --</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}"
                                data-harga="{{ $service->harga }}">
                            {{ $service->nama_layanan }} (Rp {{ number_format($service->harga) }}/kg)
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- ✅ name="qty" sesuai controller --}}
            <div class="form-group">
                <label>Berat (Kg)</label>
                <input type="number" name="qty" id="berat"
                       class="form-control"
                       min="1" required>
            </div>

            <div class="form-group">
                <label>Total Harga</label>
                <input type="text" id="total"
                       class="form-control total-box"
                       readonly>
            </div>

            <div class="text-right mt-4">
                {{-- ✅ type="submit" --}}
                <button type="submit" class="btn btn-modern btn-save">
                    🧺 Pesan Laundry
                </button>
            </div>

        </form>

    </div>
</div>

@stop

@section('js')
<script>
    const service = document.getElementById('service_id');
    const berat = document.getElementById('berat');
    const total = document.getElementById('total');

    function hitungTotal() {
        let harga = service.options[service.selectedIndex]?.dataset.harga || 0;
        let qty = berat.value || 0;

        total.value = (harga * qty).toLocaleString('id-ID');
    }

    service.addEventListener('change', hitungTotal);
    berat.addEventListener('input', hitungTotal);
</script>
@stop