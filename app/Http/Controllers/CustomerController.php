<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $customers = Customer::query()
            ->when($request->search, function ($query, $search) {
                $query->where('nama_customer', 'like', "%{$search}%")
                      ->orWhere('no_hp', 'like', "%{$search}%");
            })
            ->latest() // biar data terbaru di atas (opsional)
            ->paginate(10);

        return view('customer.index', compact('customers'));
    }

    public function create()
    {
        return view('customer.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_customer' => 'required|string|max:255',
            'no_hp'         => 'required|string|max:15|unique:customers,no_hp',
            'alamat'        => 'required|string',
        ]);

        Customer::create($data);

        return redirect()->route('customer.index')
            ->with('success', 'Data customer berhasil ditambahkan.');
    }

    public function show(Customer $customer)
    {
        return view('customer.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('customer.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $data = $request->validate([
            'nama_customer' => 'required|string|max:255',
            'no_hp'         => 'required|string|max:15|unique:customers,no_hp,' . $customer->id,
            'alamat'        => 'required|string',
        ]);

        $customer->update($data);

        return redirect()->route('customer.index')
            ->with('success', 'Data customer berhasil diperbarui.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customer.index')
            ->with('success', 'Data customer berhasil dihapus.');
    }
}