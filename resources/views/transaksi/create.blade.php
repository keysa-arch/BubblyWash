@extends('adminlte::page')

@section('title', 'Tambah Transaksi')

@section('content_header')
    <h1 class="font-weight-bold">Tambah Transaksi</h1>
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
        background-color: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    .btn-save:hover {
        background-color: #166534;
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
        <h5 class="mb-0 font-weight-bold">🧺 Form Transaksi Laundry</h5>
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

        <form action="{{ route('transaksi.store') }}" method="POST">
            @csrf

            {{-- CUSTOMER --}}
            <div class="form-group">
                <label>Pilih Customer</label>
                <select name="customer_id" id="customer_id" class="form-control">
                    <option value="">-- Customer Baru --</option>
                    @foreach($customers as $c)
                        <option value="{{ $c->id }}" {{ old('customer_id') == $c->id ? 'selected' : '' }}>
                            {{ $c->nama_customer }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- FORM CUSTOMER BARU --}}
            <div class="box-summary mb-3" id="form_customer_baru">
                <label class="font-weight-bold">➕ Tambah Customer Baru</label>

                <input type="text" name="nama_customer"
                       class="form-control mb-2"
                       placeholder="Nama Customer"
                       value="{{ old('nama_customer') }}">

                <input type="text" name="no_hp"
                       class="form-control mb-2"
                       placeholder="No HP"
                       value="{{ old('no_hp') }}">

                <textarea name="alamat"
                          class="form-control mb-2"
                          placeholder="Alamat">{{ old('alamat') }}</textarea>

                <div class="form-check mt-2">
                    <input type="checkbox"
                           name="is_member"
                           value="1"
                           class="form-check-input"
                           id="member"
                           {{ old('is_member') ? 'checked' : '' }}>
                    <label class="form-check-label" for="member">
                        🎟 Jadikan Member (Diskon 10%)
                    </label>
                </div>
            </div>

            {{-- SERVICE & QTY --}}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Service</label>
                        <select name="service_id" id="service" class="form-control" required>
                            <option value="">-- Pilih Service --</option>
                            @foreach($services as $s)
                                <option value="{{ $s->id }}" data-harga="{{ $s->harga }}"
                                    {{ old('service_id') == $s->id ? 'selected' : '' }}>
                                    {{ $s->nama_layanan }} (Rp {{ number_format($s->harga) }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Qty / Berat (Kg)</label>
                        <input type="number" name="qty" id="qty"
                               class="form-control"
                               placeholder="Masukkan jumlah"
                               min="1" required
                               value="{{ old('qty') }}">
                    </div>
                </div>
            </div>

            {{-- SUMMARY --}}
            <div class="box-summary mt-3">
                <h6 class="font-weight-bold">📊 Perhitungan</h6>

                <div class="row">
                    <div class="col-md-4">
                        <label>Harga</label>
                        <input type="text" id="harga" class="form-control" readonly>
                    </div>

                    <div class="col-md-4">
                        <label>Diskon</label>
                        <input type="text" id="diskon" class="form-control" readonly>
                    </div>

                    <div class="col-md-4">
                        <label>Total</label>
                        <input type="text" id="total" class="form-control money" readonly>
                    </div>
                </div>
            </div>

            {{-- BUTTON --}}
            <div class="d-flex justify-content-between mt-4">

                <a href="{{ route('transaksi.index') }}"
                   class="btn btn-modern btn-cancel">
                    ← Batal
                </a>

                <button type="submit" class="btn btn-modern btn-save">
                    💾 Simpan Transaksi
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
    const customerSelect = document.getElementById('customer_id');
    const formCustomerBaru = document.getElementById('form_customer_baru');
    const service = document.getElementById('service');
    const qty = document.getElementById('qty');
    const harga = document.getElementById('harga');
    const total = document.getElementById('total');
    const diskon = document.getElementById('diskon');
    const member = document.getElementById('member');

    // Toggle form customer baru
    function toggleCustomerBaru() {
        if (customerSelect.value === '') {
            formCustomerBaru.style.display = 'block';
        } else {
            formCustomerBaru.style.display = 'none';
        }
    }

    // Jalankan saat pertama load
    toggleCustomerBaru();
    customerSelect.addEventListener('change', toggleCustomerBaru);

    // Hitung total
    function formatRp(n) {
        return "Rp " + (n || 0).toLocaleString('id-ID');
    }

    function hitung() {
        let h = service.options[service.selectedIndex]?.dataset.harga || 0;
        let q = qty.value || 0;
        let subtotal = h * q;
        let d = member.checked ? subtotal * 0.1 : 0;

        harga.value = formatRp(h);
        diskon.value = formatRp(d);
        total.value = formatRp(subtotal - d);
    }

    service.addEventListener('change', hitung);
    qty.addEventListener('input', hitung);
    member.addEventListener('change', hitung);
</script>
@stop