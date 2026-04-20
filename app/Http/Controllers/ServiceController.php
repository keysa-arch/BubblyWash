<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $services = Service::query()
            ->when($request->search, function ($query, $search) {
                $query->where('nama_layanan', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('service.index', compact('services'));
    }

    public function create()
    {
        return view('service.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'harga'        => 'required|integer',
            'satuan'       => 'required|string|max:50',
        ]);

        Service::create($data);

        return redirect()->route('service.index')
            ->with('success', 'Data service berhasil ditambahkan.');
    }

    public function edit(Service $service)
    {
        return view('service.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'harga'        => 'required|integer',
            'satuan'       => 'required|string|max:50',
        ]);

        $service->update($data);

        return redirect()->route('service.index')
            ->with('success', 'Data service berhasil diperbarui.');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('service.index')
            ->with('success', 'Data service berhasil dihapus.');
    }
}