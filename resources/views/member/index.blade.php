@extends('adminlte::page')

@section('title', 'Data Member')

@section('content_header')
    <h1 class="font-weight-bold">Data Member</h1>
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
</style>

{{-- ================= CARD ================= --}}
<div class="card card-modern">

    {{-- HEADER --}}
    <div class="card-header bg-white d-flex justify-content-between align-items-center"
         style="border-bottom:1px solid #eee;">

        <h5 class="mb-0 font-weight-bold">⭐ Daftar Member</h5>

        <a href="{{ route('member.create') }}" class="btn btn-modern btn-add">
            + Tambah Member
        </a>
    </div>

    {{-- TABLE --}}
    <div class="card-body table-responsive p-0">

        <table class="table table-hover table-modern text-nowrap">

            <thead class="text-center">
                <tr>
                    <th>No</th>
                    <th>Nama Member</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($members as $key => $member)
                    <tr class="text-center">

                        <td>{{ $members->firstItem() + $key }}</td>

                        <td class="font-weight-semibold text-left">
                            {{ $member->customer->nama_customer }}
                        </td>

                        <td>

                            {{-- EDIT --}}
                            <a href="{{ route('member.edit', $member->id) }}"
                               class="btn btn-modern btn-edit btn-sm">
                                ✏️ Edit
                            </a>

                            {{-- DELETE --}}
                            <form action="{{ route('member.destroy', $member->id) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Hapus member?')">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-modern btn-delete btn-sm">
                                    🗑 Hapus
                                </button>
                            </form>

                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted py-4">
                            Data member tidak ditemukan
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>

    </div>

    {{-- FOOTER --}}
    <div class="card-footer bg-white d-flex justify-content-end">
        {{ $members->links() }}
    </div>

</div>

@stop