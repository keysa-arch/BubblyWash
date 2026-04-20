@extends('adminlte::page')

@section('title', 'Dashboard Customer')

@section('content_header')@stop

@section('css')
<style>
  .menu-card { transition: border-color .15s, background .15s; }
  .menu-card:hover { border-color: #bbb !important; background: #fafafa !important; }
  .trx-row:hover { background: #fafafa; }
</style>
@stop

@section('content')
<div class="py-3">

  {{-- Top bar --}}
  <div class="d-flex align-items-start justify-content-between mb-4">
    <div>
      <span class="badge rounded-pill mb-1" style="background:#E6F1FB;color:#185FA5;font-size:11px;">
        &#9679; Customer
      </span>
      <h4 style="font-weight:500;margin-bottom:0">Dashboard</h4>
    </div>
    <small class="text-muted pt-1">
      {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMM YYYY') }}
    </small>
  </div>

  {{-- Hero --}}
  <div class="card border rounded-3 p-3 mb-4" style="box-shadow:none">
    <div class="d-flex align-items-center justify-content-between">
      <div>
        <div style="font-size:15px;font-weight:500;margin-bottom:3px">
          Laundry Bersih & Cepat
        </div>
        <div class="text-muted" style="font-size:12px">
          Cuci kiloan, setrika, dan dry cleaning siap melayani kamu
        </div>
      </div>

      <a href="{{ route('customer.transaksi.create') }}"
         class="btn btn-sm rounded-2 flex-shrink-0 ms-3"
         style="background:#3C3489;color:#fff;font-size:12px;font-weight:500;padding:6px 14px;">
        + Buat Transaksi
      </a>
    </div>
  </div>

  {{-- DATA --}}
  @php
    $transaksis   = $transaksis ?? collect();
    $totalTrx     = $transaksis->count();
    $totalBayar   = $transaksis->sum('total');
    $statusProses = $transaksis->where('status', 'process')->count();
  @endphp

  <div class="row g-3 mb-4">
    @foreach([
      ['n' => $totalTrx, 'label' => 'Total pesanan', 'bg' => '#E6F1FB', 'fill' => '#378ADD', 'pct' => min($totalTrx * 10, 100), 'tc' => '#185FA5', 'ic' => 'fa-box'],
      ['n' => 'Rp '.number_format($totalBayar,0,',','.'), 'label' => 'Total pembayaran', 'bg' => '#EAF3DE', 'fill' => '#639922', 'pct' => 60, 'tc' => '#3B6D11', 'ic' => 'fa-wallet'],
      ['n' => $statusProses, 'label' => 'Sedang diproses', 'bg' => '#FAEEDA', 'fill' => '#BA7517', 'pct' => min($statusProses * 20, 100), 'tc' => '#854F0B', 'ic' => 'fa-spinner'],
    ] as $s)
    <div class="col-md-4">
      <div class="card border rounded-3 p-3 h-100" style="box-shadow:none">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <span class="rounded-2 p-2" style="background:{{ $s['bg'] }}">
            <i class="fas {{ $s['ic'] }}" style="color:{{ $s['tc'] }};font-size:13px;"></i>
          </span>
        </div>

        <div style="font-size:20px;font-weight:500">{{ $s['n'] }}</div>
        <div class="text-muted" style="font-size:12px">{{ $s['label'] }}</div>

        <div class="rounded" style="height:3px;background:#eee;overflow:hidden">
          <div style="width:{{ $s['pct'] }}%;height:100%;background:{{ $s['fill'] }}"></div>
        </div>
      </div>
    </div>
    @endforeach
  </div>

  {{-- RIWAYAT --}}
  <div class="d-flex align-items-center gap-2 mb-3">
    <span class="text-uppercase text-muted" style="font-size:11px;">
      Riwayat pesanan
    </span>
    <hr class="flex-grow-1 my-0">
  </div>

  @php
    $filterStatus = request('status', 'semua');

    $filtered = $filterStatus === 'semua'
        ? $transaksis
        : $transaksis->where('status', $filterStatus);
  @endphp

  <div class="card border rounded-3 overflow-hidden" style="box-shadow:none">
    <div class="card-body p-0">
      <table class="table table-bordered mb-0" style="font-size:13px;">
        <thead>
          <tr style="background:#f8f8f8;">
            <th>No</th>
            <th>Service</th>
            <th>Berat (kg)</th>
            <th>Total</th>
            <th>Status</th>
            <th>Tanggal</th>
          </tr>
        </thead>

        <tbody>
          @forelse ($filtered->values() as $i => $trx)
          <tr class="trx-row">
            <td>{{ $i + 1 }}</td>

            <td style="font-weight:500">
              {{ $trx->service->name ?? '-' }}
            </td>

            <td>{{ $trx->qty }} kg</td>

            <td>
              Rp {{ number_format($trx->total, 0, ',', '.') }}
            </td>

            <td>
              @if($trx->status == 'process')
                Proses
              @elseif($trx->status == 'done')
                Selesai
              @else
                Diambil
              @endif
            </td>

            <td>
              {{ $trx->created_at->format('d-m-Y') }}
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center py-4">
              Belum ada pesanan
            </td>
          </tr>
          @endforelse
        </tbody>

      </table>
    </div>
  </div>

</div>
@stop