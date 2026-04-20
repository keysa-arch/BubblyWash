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
    <small class="text-muted pt-1">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMM YYYY') }}</small>
  </div>

  {{-- Hero --}}
  <div class="card border rounded-3 p-3 mb-4" style="box-shadow:none">
    <div class="d-flex align-items-center justify-content-between">
      <div>
        <div style="font-size:15px;font-weight:500;margin-bottom:3px">Laundry Bersih & Cepat</div>
        <div class="text-muted" style="font-size:12px">Cuci kiloan, setrika, dan dry cleaning siap melayani kamu</div>
      </div>
      {{-- ✅ route diperbaiki --}}
      <a href="{{ route('customer.transaksi.create') }}"
         class="btn btn-sm rounded-2 flex-shrink-0 ms-3"
         style="background:#3C3489;color:#fff;font-size:12px;font-weight:500;padding:6px 14px;">
        + Buat Transaksi
      </a>
    </div>
  </div>

  {{-- Stats ringkas --}}
  @php
    $transaksis   = $transaksis ?? collect();
    $totalTrx     = $transaksis->count();
    $totalBayar   = $transaksis->sum('total');
    $statusProses = $transaksis->where('status', 'proses')->count();
  @endphp
  <div class="row g-3 mb-4">
    @foreach([
      ['n' => $totalTrx,                              'label' => 'Total pesanan',   'bg' => '#E6F1FB', 'fill' => '#378ADD', 'pct' => min($totalTrx * 10, 100),    'tc' => '#185FA5', 'ic' => 'fa-box'],
      ['n' => 'Rp '.number_format($totalBayar,0,',','.'), 'label' => 'Total pembayaran','bg' => '#EAF3DE', 'fill' => '#639922', 'pct' => 60,                           'tc' => '#3B6D11', 'ic' => 'fa-wallet'],
      ['n' => $statusProses,                          'label' => 'Sedang diproses', 'bg' => '#FAEEDA', 'fill' => '#BA7517', 'pct' => min($statusProses * 20, 100), 'tc' => '#854F0B', 'ic' => 'fa-spinner'],
    ] as $s)
    <div class="col-md-4">
      <div class="card border rounded-3 p-3 h-100" style="box-shadow:none">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <span class="rounded-2 p-2" style="background:{{ $s['bg'] }}">
            <i class="fas {{ $s['ic'] }}" style="color:{{ $s['tc'] }};font-size:13px;width:14px;text-align:center"></i>
          </span>
        </div>
        <div style="font-size:20px;font-weight:500;line-height:1">{{ $s['n'] }}</div>
        <div class="text-muted mt-1 mb-2" style="font-size:12px">{{ $s['label'] }}</div>
        <div class="rounded" style="height:3px;background:#eee;overflow:hidden">
          <div style="width:{{ $s['pct'] }}%;height:100%;background:{{ $s['fill'] }};border-radius:2px"></div>
        </div>
      </div>
    </div>
    @endforeach
  </div>

  {{-- Layanan --}}
  <div class="d-flex align-items-center gap-2 mb-3">
    <span class="text-uppercase text-muted" style="font-size:11px;font-weight:500;letter-spacing:.07em;white-space:nowrap">Layanan kami</span>
    <hr class="flex-grow-1 my-0">
  </div>
  <div class="row g-2 mb-4">
    @foreach([
      ['label' => 'Cuci Kiloan',  'sub' => 'Per kg, cepat & bersih', 'bg' => '#E6F1FB', 'tc' => '#185FA5', 'ic' => 'fa-tint'],
      ['label' => 'Setrika Rapih','sub' => 'Hasil rapi & harum',      'bg' => '#EAF3DE', 'tc' => '#3B6D11', 'ic' => 'fa-magic'],
      ['label' => 'Dry Cleaning', 'sub' => 'Untuk pakaian spesial',   'bg' => '#FAEEDA', 'tc' => '#854F0B', 'ic' => 'fa-star'],
    ] as $sv)
    <div class="col-md-4">
      <div class="d-flex align-items-center gap-2 border rounded-3 p-2 bg-white">
        <span class="rounded-2 p-2 flex-shrink-0" style="background:{{ $sv['bg'] }}">
          <i class="fas {{ $sv['ic'] }}" style="color:{{ $sv['tc'] }};font-size:13px;width:14px;text-align:center"></i>
        </span>
        <div>
          <div style="font-size:13px;font-weight:500">{{ $sv['label'] }}</div>
          <div class="text-muted" style="font-size:11px">{{ $sv['sub'] }}</div>
        </div>
      </div>
    </div>
    @endforeach
  </div>

  {{-- Riwayat --}}
  <div class="d-flex align-items-center gap-2 mb-3">
    <span class="text-uppercase text-muted" style="font-size:11px;font-weight:500;letter-spacing:.07em;white-space:nowrap">Riwayat pesanan</span>
    <hr class="flex-grow-1 my-0">
  </div>

  {{-- Filter status --}}
  @php $filterStatus = request('status', 'semua'); @endphp
  <div class="d-flex gap-2 mb-3 flex-wrap">
    @foreach(['semua' => 'Semua', 'proses' => 'Proses', 'selesai' => 'Selesai', 'diambil' => 'Diambil'] as $val => $label)
    <a href="?status={{ $val }}"
       class="rounded-pill px-3 py-1 text-decoration-none"
       style="font-size:12px;font-weight:500;
              background:{{ $filterStatus == $val ? '#3C3489' : '#f4f4f4' }};
              color:{{ $filterStatus == $val ? '#fff' : '#666' }}">
      {{ $label }}
    </a>
    @endforeach
  </div>

  <div class="card border rounded-3 overflow-hidden" style="box-shadow:none">
    <div class="card-body p-0">
      @php
        $filtered = $filterStatus === 'semua'
          ? $transaksis
          : $transaksis->where('status', $filterStatus);
      @endphp
      <table class="table table-bordered mb-0" style="font-size:13px;">
        <thead>
          <tr style="background:#f8f8f8;">
            <th class="text-muted border-0 ps-3" style="font-size:11px;font-weight:500;text-transform:uppercase;letter-spacing:.05em;">No</th>
            <th class="text-muted border-0"       style="font-size:11px;font-weight:500;text-transform:uppercase;letter-spacing:.05em;">Service</th>
            <th class="text-muted border-0"       style="font-size:11px;font-weight:500;text-transform:uppercase;letter-spacing:.05em;">Berat (kg)</th>
            <th class="text-muted border-0"       style="font-size:11px;font-weight:500;text-transform:uppercase;letter-spacing:.05em;">Total</th>
            <th class="text-muted border-0"       style="font-size:11px;font-weight:500;text-transform:uppercase;letter-spacing:.05em;">Status</th>
            <th class="text-muted border-0 pe-3"  style="font-size:11px;font-weight:500;text-transform:uppercase;letter-spacing:.05em;">Tanggal</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($filtered->values() as $i => $trx)
          <tr class="trx-row">
            <td class="ps-3 text-muted">{{ $i + 1 }}</td>
            <td style="font-weight:500">{{ optional($trx->service)->nama_layanan ?? '-' }}</td>
            <td>{{ $trx->qty }} kg</td>
            <td>Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
            <td>
              @if($trx->status == 'proses')
                <span class="rounded-pill px-2 py-1" style="background:#FAEEDA;color:#854F0B;font-size:11px;">Proses</span>
              @elseif($trx->status == 'selesai')
                <span class="rounded-pill px-2 py-1" style="background:#EAF3DE;color:#3B6D11;font-size:11px;">Selesai</span>
              @else
                <span class="rounded-pill px-2 py-1" style="background:#EEEDFE;color:#3C3489;font-size:11px;">Diambil</span>
              @endif
            </td>
            <td class="pe-3 text-muted">{{ optional($trx->created_at)->format('d-m-Y') }}</td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center text-muted py-4" style="font-size:13px;">
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