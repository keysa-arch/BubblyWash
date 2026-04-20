@extends('adminlte::page')

@section('title', 'Admin Dashboard')

@section('content_header')@stop

@section('css')
<style>
  .notif-item { border-left: 3px solid transparent; }
  .notif-item.proses  { border-color: #BA7517; background: #FAEEDA; }
  .notif-item.selesai { border-color: #639922; background: #EAF3DE; }
  .notif-item.diambil { border-color: #534AB7; background: #EEEDFE; }
</style>
@stop

@section('content')
<div class="py-3">

  {{-- Top bar --}}
  <div class="d-flex align-items-start justify-content-between mb-4">
    <div>
      <span class="badge rounded-pill mb-1" style="background:#EAF3DE;color:#3B6D11;font-size:11px;">
        &#9679; Admin
      </span>
      <h4 style="font-weight:500;margin-bottom:0">Dashboard</h4>
    </div>
    <small class="text-muted pt-1">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMM YYYY') }}</small>
  </div>

  {{-- Stats --}}
  <div class="row g-3 mb-4">
    @foreach([
      ['n' => \App\Models\Transaksi::count(), 'label' => 'Total transaksi', 'bg' => '#EAF3DE', 'fill' => '#639922', 'pct' => 55, 'tc' => '#3B6D11', 'ic' => 'fa-file-alt'],
      ['n' => \App\Models\Member::count(),    'label' => 'Total member',    'bg' => '#EEEDFE', 'fill' => '#534AB7', 'pct' => 40, 'tc' => '#3C3489', 'ic' => 'fa-id-badge'],
    ] as $s)
    <div class="col-md-6">
      <div class="card border rounded-3 p-3 h-100" style="box-shadow:none">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <span class="rounded-2 p-2" style="background:{{ $s['bg'] }}">
            <i class="fas {{ $s['ic'] }}" style="color:{{ $s['tc'] }};font-size:14px;width:14px;text-align:center"></i>
          </span>
        </div>
        <div style="font-size:22px;font-weight:500;line-height:1">{{ number_format($s['n']) }}</div>
        <div class="text-muted mt-1 mb-2" style="font-size:12px">{{ $s['label'] }}</div>
        <div class="rounded" style="height:3px;background:#eee;overflow:hidden">
          <div style="width:{{ $s['pct'] }}%;height:100%;background:{{ $s['fill'] }};border-radius:2px"></div>
        </div>
      </div>
    </div>
    @endforeach
  </div>

  {{-- Grafik & Notifikasi --}}
  <div class="row g-3 mb-4">

    {{-- Grafik --}}
    <div class="col-md-7">
      <div class="card border rounded-3 p-3 h-100" style="box-shadow:none">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <div>
            <div style="font-size:13px;font-weight:500">Transaksi 7 Hari Terakhir</div>
            <div class="text-muted" style="font-size:11px">Jumlah transaksi per hari</div>
          </div>
          <span class="rounded-2 p-2" style="background:#EAF3DE">
            <i class="fas fa-chart-line" style="color:#3B6D11;font-size:13px;width:14px;text-align:center"></i>
          </span>
        </div>
        <canvas id="chartTransaksi" height="110"></canvas>
      </div>
    </div>

    {{-- Notifikasi --}}
    <div class="col-md-5">
      <div class="card border rounded-3 p-3 h-100" style="box-shadow:none">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <div>
            <div style="font-size:13px;font-weight:500">Notifikasi</div>
            <div class="text-muted" style="font-size:11px">Transaksi terbaru</div>
          </div>
          <span class="rounded-2 p-2" style="background:#FAEEDA">
            <i class="fas fa-bell" style="color:#854F0B;font-size:13px;width:14px;text-align:center"></i>
          </span>
        </div>

        @php
          $notifs = \App\Models\Transaksi::with('service')
            ->latest()
            ->take(5)
            ->get();
        @endphp

        @forelse ($notifs as $notif)
        <div class="notif-item {{ $notif->status }} rounded-2 p-2 mb-2">
          <div class="d-flex justify-content-between align-items-start">
            <div style="font-size:12px;font-weight:500">
              {{ optional($notif->service)->nama_layanan ?? 'Transaksi' }}
            </div>
            <small style="font-size:10px;color:inherit;opacity:.7">
              {{ optional($notif->created_at)->diffForHumans() }}
            </small>
          </div>
          <div style="font-size:11px;opacity:.75;margin-top:2px">
            Rp {{ number_format($notif->total, 0, ',', '.') }} &middot;
            @if($notif->status == 'proses')  Sedang diproses
            @elseif($notif->status == 'selesai') Selesai
            @else Sudah diambil
            @endif
          </div>
        </div>
        @empty
        <div class="text-center text-muted py-3" style="font-size:12px">Belum ada transaksi</div>
        @endforelse

      </div>
    </div>

  </div>

  {{-- Menu --}}
  <div class="d-flex align-items-center gap-2 mb-3">
    <span class="text-uppercase text-muted" style="font-size:11px;font-weight:500;letter-spacing:.07em;white-space:nowrap">Menu navigasi</span>
    <hr class="flex-grow-1 my-0">
  </div>
  <div class="row g-2">
    @foreach([
      ['route' => 'transaksi.index', 'title' => 'Kelola transaksi', 'sub' => 'Riwayat & status',  'bg' => '#EAF3DE', 'ic' => 'fa-file-alt',      'ic_c' => '#3B6D11'],
      ['route' => 'laporan.index',   'title' => 'Laporan keuangan', 'sub' => 'Rekap & analitik',  'bg' => '#F1EFE8', 'ic' => 'fa-chart-bar',      'ic_c' => '#5F5E5A'],
      ['route' => 'service.index',   'title' => 'Data service',     'sub' => 'Layanan laundry',   'bg' => '#E6F1FB', 'ic' => 'fa-concierge-bell', 'ic_c' => '#185FA5'],
    ] as $m)
    <div class="col-md-4 col-6">
      <a href="{{ route($m['route']) }}"
         class="d-flex align-items-center gap-2 text-decoration-none border rounded-3 p-2 bg-white"
         style="transition:.15s">
        <span class="rounded-2 p-2 flex-shrink-0" style="background:{{ $m['bg'] }}">
          <i class="fas {{ $m['ic'] }}" style="color:{{ $m['ic_c'] }};font-size:13px;width:14px;text-align:center"></i>
        </span>
        <div>
          <div style="font-size:13px;font-weight:500;color:var(--dark)">{{ $m['title'] }}</div>
          <div class="text-muted" style="font-size:11px">{{ $m['sub'] }}</div>
        </div>
      </a>
    </div>
    @endforeach
  </div>

</div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
@php
  $labels = [];
  $data   = [];
  for ($i = 6; $i >= 0; $i--) {
    $date     = \Carbon\Carbon::now()->subDays($i);
    $labels[] = $date->isoFormat('ddd, D MMM');
    $data[]   = \App\Models\Transaksi::whereDate('created_at', $date->toDateString())->count();
  }
@endphp

const ctx = document.getElementById('chartTransaksi').getContext('2d');
new Chart(ctx, {
  type: 'bar',
  data: {
    labels: {!! json_encode($labels) !!},
    datasets: [{
      label: 'Transaksi',
      data: {!! json_encode($data) !!},
      backgroundColor: '#EAF3DE',
      borderColor: '#639922',
      borderWidth: 1.5,
      borderRadius: 4,
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: { display: false },
      tooltip: {
        callbacks: {
          label: ctx => ' ' + ctx.parsed.y + ' transaksi'
        }
      }
    },
    scales: {
      x: {
        grid: { display: false },
        ticks: { font: { size: 10 }, color: '#888' }
      },
      y: {
        beginAtZero: true,
        ticks: { stepSize: 1, font: { size: 10 }, color: '#888' },
        grid: { color: '#f0f0f0' }
      }
    }
  }
});
</script>
@stop