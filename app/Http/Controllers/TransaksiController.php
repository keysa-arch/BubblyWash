<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Member;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    // =====================
    // INDEX
    // =====================
    public function index()
    {
        $transaksis = Transaksi::with(['customer', 'service'])
            ->latest()
            ->paginate(10);

        return view('transaksi.index', compact('transaksis'));
    }

    // =====================
    // CREATE
    // =====================
    public function create()
    {
        $user = auth()->user();

        $services = Service::all();

        if ($user->role === 'customer') {
            return view('transaksi.create_customer', compact('services'));
        }

        $customers = Customer::all();

        return view('transaksi.create', compact('customers', 'services'));
    }

    // =====================
    // STORE
    // =====================
    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'qty'        => 'required|numeric|min:1',
        ]);

        $user = auth()->user();

        $customer = null;

        if ($user->role === 'customer') {

            $customer = Customer::where('user_id', $user->id)->first();

            if (!$customer) {
                return redirect()->route('dashboard')
                    ->with('error', 'Data customer belum terhubung dengan akun ini.');
            }

        } else {

            // =====================
            // PILIH CUSTOMER LAMA
            // =====================
            if ($request->customer_id) {

                $customer = Customer::find($request->customer_id);

                if (!$customer) {
                    return redirect()->back()
                        ->with('error', 'Customer tidak ditemukan.');
                }

            // =====================
            // TAMBAH CUSTOMER BARU
            // =====================
            } else {

                $request->validate([
                    'name'    => 'required|string|max:255',
                    'phone'   => 'required|string|max:20',
                    'address' => 'required|string',
                ]);

                $customer = Customer::create([
                    'name'    => $request->name,
                    'phone'   => $request->phone,
                    'address' => $request->address,
                ]);

                // Jadikan member jika dicentang
                if ($request->is_member) {
                    Member::create([
                        'customer_id' => $customer->id,
                    ]);
                }
            }
        }

        // =====================
        // SERVICE
        // =====================
        $service = Service::findOrFail($request->service_id);

        // =====================
        // HITUNG TOTAL
        // =====================
        $subtotal = $service->price * $request->qty;

        $isMember = Member::where('customer_id', $customer->id)->exists();

        $discount = $isMember ? $subtotal * 0.1 : 0;

        $total = $subtotal - $discount;

        // =====================
        // SIMPAN TRANSAKSI
        // =====================
        Transaksi::create([
            'customer_id' => $customer->id,
            'service_id'  => $service->id,
            'qty'         => $request->qty,
            'price'       => $service->price,
            'discount'    => $discount,
            'total'       => $total,
            'status'      => 'process',
        ]);

        // =====================
        // REDIRECT BERDASARKAN ROLE
        // =====================
        if ($user->role === 'customer') {
            return redirect()
                ->route('dashboard')
                ->with('success', 'Pesanan laundry berhasil dibuat');
        }

        return redirect()
            ->route('transaksi.index')
            ->with('success', 'Transaksi berhasil dibuat');
    }

    // =====================
    // SHOW
    // =====================
    public function show(Transaksi $transaksi)
    {
        $transaksi->load(['customer', 'service']);

        return view('transaksi.show', compact('transaksi'));
    }

    // =====================
    // EDIT
    // =====================
    public function edit(Transaksi $transaksi)
    {
        return view('transaksi.edit', [
            'transaksi' => $transaksi,
            'customers' => Customer::all(),
            'services'  => Service::all(),
        ]);
    }

    // =====================
    // UPDATE
    // =====================
    public function update(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'service_id'  => 'required|exists:services,id',
            'qty'         => 'required|numeric|min:1',
            'status'      => 'required|in:process,done,picked_up',
        ]);

        $service = Service::findOrFail($request->service_id);

        $subtotal = $service->price * $request->qty;

        $isMember = Member::where('customer_id', $request->customer_id)->exists();

        $discount = $isMember ? $subtotal * 0.1 : 0;

        $total = $subtotal - $discount;

        $transaksi->update([
            'customer_id' => $request->customer_id,
            'service_id'  => $service->id,
            'qty'         => $request->qty,
            'price'       => $service->price,
            'discount'    => $discount,
            'total'       => $total,
            'status'      => $request->status,
        ]);

        return redirect()
            ->route('transaksi.index')
            ->with('success', 'Transaksi berhasil diperbarui');
    }

    // =====================
    // DELETE
    // =====================
    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }
}