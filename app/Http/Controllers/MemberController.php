<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::orderBy('created_at', 'desc')->paginate(20);
        return view('kasir.member', compact('members'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:members,email',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string'
        ]);

        $validated['member_code'] = Member::generateMemberCode();
        $validated['barcode'] = Member::generateBarcode();
        $validated['points'] = 0;
        $validated['is_active'] = true;

        $member = Member::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Member berhasil didaftarkan!',
            'member' => $member
        ]);
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:members,email,' . $member->id,
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string'
        ]);

        $member->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data member berhasil diupdate!',
            'member' => $member
        ]);
    }

    public function destroy(Member $member)
    {
        $member->delete();

        return response()->json([
            'success' => true,
            'message' => 'Member berhasil dihapus!'
        ]);
    }

    public function toggleStatus(Member $member)
    {
        $member->is_active = !$member->is_active;
        $member->save();

        return response()->json([
            'success' => true,
            'message' => 'Status member berhasil diubah!',
            'member' => $member
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->get('q', '');
        
        $members = Member::where('is_active', true)
            ->where(function($q) use ($query) {
                $q->where('member_code', 'like', "%{$query}%")
                  ->orWhere('name', 'like', "%{$query}%")
                  ->orWhere('phone', 'like', "%{$query}%");
            })
            ->limit(10)
            ->get(['id', 'member_code', 'name', 'phone', 'points', 'rating', 'total_spent']);
        
        return response()->json([
            'success' => true,
            'members' => $members
        ]);
    }
}
