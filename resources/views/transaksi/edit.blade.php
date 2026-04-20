@extends('adminlte::page')

@section('title', 'Edit Transaksi')

@section('content_header')
    <h1 class="font-weight-bold">Edit Transaksi</h1>
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

    .btn-cancel {
        background-color: #f1f5f9;
        color: #334155;
        border: 1px solid #e2e8f0;
    }

    .btn-cancel:hover {
        background-color: #334155;
        color: white;
    }

    .box-summary {
        background: #f8fafc;
        border-radius: 12px;
        padding: 15px;
    }

    .money {
        font-weight: bold;
        color: #16a34a;
    }
</style>

<div class="row">
<div class="col-md-8 offset-md-2">

<div class="card card-modern">

    <div class="card-header bg-white" style="border-bottom:1px solid #eee;">
        <h5 class="mb-0 font-weight-bold">✏️ Edit Transaksi Laundry</h5>
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

        <form action="{{ route('transaksi.update', $transaksi->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- CUSTOMER --}}
            <div class="form-group">
                <label>Pilih Customer</label>
                <select name="customer_id" class="form-control" required>
                    <option value="">-- Pilih Customer --</option>
                    @foreach($customers as $c)
                        <option value="{{ $c->id }}"
                            {{ $transaksi->customer_id == $c->id ? 'selected' : '' }}>
                            {{ $c->nama_customer }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- SERVICE & QTY --}}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Service</label>
                        <select name="service_id" id="service" class="form-control" required>
                            <option value="">-- Pilih Service --</option>
                            @foreach($services as $s)
                                <option value="{{ $s->id }}"
                                    data-harga="{{ $s->harga }}"
                                    {{ $transaksi->service_id == $s->id ? 'selected' : '' }}>
                                    {{ $s->nama_layanan }} (Rp {{ number_format($s->harga) }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        {{-- ✅ name="qty" sesuai controller --}}
                        <label>Qty / Berat (Kg)</label>
                        <input type="number" name="qty" id="qty"
                               class="form-control"
                               min="1" required
                               value="{{ $transaksi->qty }}">
                    </div>
                </div>
            </div>

            {{-- STATUS --}}
            <div class="form-group mt-3">
                <label>Status</label>
                <select name="status" class="form-control" required>
                    <option value="proses"   {{ $transaksi->status == 'proses'   ? 'selected' : '' }}>Proses</option>
                    <option value="selesai"  {{ $transaksi->status == 'selesai'  ? 'selected' : '' }}>Selesai</option>
                    <option value="diambil"  {{ $transaksi->status == 'diambil'  ? 'selected' : '' }}>Diambil</option>
                </select>
            </div>

            {{-- SUMMARY --}}
            <div class="box-summary mt-3">
                <h6 class="font-weight-bold">📊 Perhitungan</h6>

                <div class="row">
                    <div class="col-md-4">
                        <label>Harga</label>
                        <input type="text" id="harga" class="form-control" readonly
                               value="{{ $transaksi->harga }}">
                    </div>

                    <div class="col-md-4">
                        <label>Diskon</label>
                        <input type="text" id="diskon" class="form-control" readonly
                               value="{{ $transaksi->diskon ?? 0 }}">
                    </div>

                    <div class="col-md-4">
                        <label>Total</label>
                        <input type="text" id="total" class="form-control money" readonly
                               value="{{ $transaksi->total }}">
                    </div>
                </div>
            </div>

            {{-- BUTTON --}}
            <div class="d-flex justify-content-between mt-4">

                <a href="{{ route('transaksi.index') }}"
                   class="btn btn-modern btn-cancel">
                    ← Batal
                </a>

                {{-- ✅ tambah type="submit" --}}
                <button type="submit" class="btn btn-modern btn-save">
                    💾 Update Transaksi
                </button>

            </div>

        </form>

    </div>
</div>

</div>
</div>

@stop

@section('js')
<script>
let service = document.getElementById('service');
let qty = document.getElementById('qty');
let harga = document.getElementById('harga');
let total = document.getElementById('total');
let diskon = document.getElementById('diskon');

let isMember = {{ $transaksi->diskon > 0 ? 'true' : 'false' }};

function formatRp(n) {
    return "Rp " + (n || 0).toLocaleString('id-ID');
}

function hitung() {
    let h = service.options[service.selectedIndex]?.dataset.harga || 0;
    let q = qty.value || 0;

    let subtotal = h * q;
    let d = isMember ? subtotal * 0.1 : 0;

    harga.value = formatRp(h);
    diskon.value = formatRp(d);
    total.value = formatRp(subtotal - d);
}

hitung();

service.addEventListener('change', hitung);
qty.addEventListener('input', hitung);
</script>
@stop