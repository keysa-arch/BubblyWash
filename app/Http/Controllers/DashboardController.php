<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Customer;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // =====================
        // DASHBOARD CUSTOMER
        // =====================
        if ($user->role === 'customer') {

            $customer = Customer::where('user_id', $user->id)->first();

            $transaksis = collect();

            if ($customer) {
                $transaksis = Transaksi::with('service')
                    ->where('customer_id', $customer->id)
                    ->latest()
                    ->get();
            }

            return view('dashboard_customer', compact('transaksis'));
        }

        // =====================
        // DASHBOARD ADMIN
        // =====================
        $totalTransaksi  = Transaksi::count();
        $totalProses     = Transaksi::where('status', 'proses')->count();
        $totalSelesai    = Transaksi::where('status', 'selesai')->count();
        $totalPendapatan = Transaksi::where('status', 'selesai')->sum('total');

        return view('dashboard', compact(
            'totalTransaksi',
            'totalProses',
            'totalSelesai',
            'totalPendapatan'
        ));
    }
}