<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Customer;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::with('customer')->paginate(10);
        return view('member.index', compact('members'));
    }

    public function create()
    {
        $customers = Customer::all();
        return view('member.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => 'required|exists:customers,id|unique:members,customer_id'
        ]);

        Member::create($data);

        return redirect()->route('member.index')
            ->with('success', 'Member berhasil ditambahkan');
    }

    public function edit(Member $member)
    {
        $customers = Customer::all();
        return view('member.edit', compact('member','customers'));
    }

    public function update(Request $request, Member $member)
    {
        $data = $request->validate([
            'customer_id' => 'required|exists:customers,id|unique:members,customer_id,' . $member->id
        ]);

        $member->update($data);

        return redirect()->route('member.index')
            ->with('success', 'Member berhasil diupdate');
    }

    public function destroy(Member $member)
    {
        $member->delete();

        return redirect()->route('member.index')
            ->with('success', 'Member dihapus');
    }
}