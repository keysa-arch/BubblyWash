@extends('adminlte::page')
@section('title', 'Super Admin Dashboard')
@section('content_header')@stop
@section('content')
<div class="py-3">

  {{-- Top bar --}}
  <div class="d-flex align-items-start justify-content-between mb-4">
    <div>
      <span class="badge rounded-pill mb-1" style="background:#EEEDFE;color:#3C3489;font-size:11px;">
        &#9679; Super admin
      </span>
      <h4 class="fw-medium mb-0">Dashboard</h4>
    </div>
    <small class="text-muted pt-1">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMM YYYY') }}</small>
  </div>

  {{-- Stats --}}
  <div class="row g-3 mb-4">
    @foreach([
      ['n' => \App\Models\User::count(),      'label' => 'Total user',      'trend' => '+12%', 'bg' => '#E6F1FB', 'fill' => '#378ADD', 'pct' => 72, 'tc' => '#185FA5'],
      ['n' => \App\Models\Transaksi::count(), 'label' => 'Total transaksi', 'trend' => '+8%',  'bg' => '#EAF3DE', 'fill' => '#639922', 'pct' => 55, 'tc' => '#3B6D11'],
      ['n' => \App\Models\Customer::count(),  'label' => 'Total customer',  'trend' => '+5%',  'bg' => '#FAEEDA', 'fill' => '#BA7517', 'pct' => 38, 'tc' => '#854F0B'],
    ] as $s)
    <div class="col-md-4">
      <div class="card border rounded-3 p-3 h-100">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <span class="rounded-2 p-2" style="background:{{ $s['bg'] }}">
            <i class="fas fa-users" style="color:{{ $s['tc'] }};font-size:14px;"></i>
          </span>
          <span class="badge rounded-pill" style="background:{{ $s['bg'] }};color:{{ $s['tc'] }};font-size:11px;">
            {{ $s['trend'] }}
          </span>
        </div>
        <div class="fs-3 fw-medium lh-1">{{ number_format($s['n']) }}</div>
        <div class="text-muted small mt-1 mb-2">{{ $s['label'] }}</div>
        <div class="rounded" style="height:3px;background:#eee;overflow:hidden">
          <div style="width:{{ $s['pct'] }}%;height:100%;background:{{ $s['fill'] }};border-radius:2px"></div>
        </div>
      </div>
    </div>
    @endforeach
  </div>

  {{-- Menu --}}
  <div class="d-flex align-items-center gap-2 mb-3">
    <span class="text-uppercase text-muted fw-medium" style="font-size:11px;letter-spacing:.07em;white-space:nowrap">Menu navigasi</span>
    <hr class="flex-grow-1 my-0">
  </div>
  <div class="row g-2">
    @foreach([
      ['route' => 'user.index',      'title' => 'Kelola user',      'sub' => 'Akun & akses',      'bg' => '#FCEBEB', 'ic' => 'fa-user',          'ic_c' => '#A32D2D'],
      ['route' => 'customer.index',  'title' => 'Kelola customer',  'sub' => 'Data pelanggan',     'bg' => '#FAEEDA', 'ic' => 'fa-users',         'ic_c' => '#854F0B'],
      ['route' => 'service.index',   'title' => 'Kelola service',   'sub' => 'Layanan laundry',    'bg' => '#E6F1FB', 'ic' => 'fa-concierge-bell','ic_c' => '#185FA5'],
      ['route' => 'transaksi.index', 'title' => 'Kelola transaksi', 'sub' => 'Riwayat & status',   'bg' => '#EAF3DE', 'ic' => 'fa-file-alt',      'ic_c' => '#3B6D11'],
      ['route' => 'member.index',    'title' => 'Kelola member',    'sub' => 'Poin & keanggotaan', 'bg' => '#EEEDFE', 'ic' => 'fa-id-badge',      'ic_c' => '#534AB7'],
      ['route' => 'laporan.index',   'title' => 'Laporan',          'sub' => 'Rekap & analitik',   'bg' => '#F1EFE8', 'ic' => 'fa-chart-bar',     'ic_c' => '#5F5E5A'],
    ] as $m)
    <div class="col-md-4 col-6">
      <a href="{{ route($m['route']) }}"
         class="d-flex align-items-center gap-2 text-decoration-none border rounded-3 p-2 bg-white"
         style="transition:.15s">
        <span class="rounded-2 p-2 flex-shrink-0" style="background:{{ $m['bg'] }}">
          <i class="fas {{ $m['ic'] }}" style="color:{{ $m['ic_c'] }};font-size:13px;width:14px;text-align:center"></i>
        </span>
        <div>
          <div class="fw-medium" style="font-size:13px;color:var(--dark)">{{ $m['title'] }}</div>
          <div class="text-muted" style="font-size:11px">{{ $m['sub'] }}</div>
        </div>
      </a>
    </div>
    @endforeach
  </div>

</div>
@stop