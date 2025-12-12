<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VerificationController extends Controller
{
    public function index()
    {
        // Get sellers yang belum diverifikasi (is_active = false)
        $pendingSellers = Seller::with('user')
            ->where('is_active', false)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('Admin.Verifikasi.verifikasi', compact('pendingSellers'));
    }

    public function show($id)
    {
        $seller = Seller::with('user', 'region')->findOrFail($id);
        
        return view('Admin.Verifikasi.detailverifikasi', compact('seller'));
    }

    public function approve($id)
    {
        try {
            $seller = Seller::findOrFail($id);
            
            // Update status seller menjadi aktif
            $seller->update([
                'is_active' => true,
                'verified_at' => now()
            ]);

            return redirect()
                ->route('admin.verification.index')
                ->with('success', "Seller {$seller->shop_name} berhasil disetujui dan diaktifkan!");
                
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|min:10'
        ]);

        try {
            $seller = Seller::findOrFail($id);
            
            // Update dengan rejection info
            $seller->update([
                'is_active' => false,
                'rejection_reason' => $request->rejection_reason,
                'rejected_at' => now()
            ]);

            return redirect()
                ->route('admin.verification.index')
                ->with('success', "Pengajuan seller {$seller->shop_name} telah ditolak.");
                
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
