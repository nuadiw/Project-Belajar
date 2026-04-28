<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kegiatan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today();

        if ($user->role === 'admin') {

            // ===== ADMIN STATS =====
            $stats = [
                'total_kegiatan' => Kegiatan::count(),
                'kegiatan_hari_ini' => Kegiatan::whereDate('tanggal_kegiatan', $today)->count(),
                'kegiatan_bulan_ini' => Kegiatan::whereMonth('tanggal_kegiatan', now()->month)
                    ->whereYear('tanggal_kegiatan', now()->year)
                    ->count(),
                'total_user' => User::count(),
            ];

        } else {

            // ===== USER STATS =====
            $stats = [
                'total_kegiatan_saya' => Kegiatan::where('user_id', $user->id)->count(),

                'kegiatan_hari_ini' => Kegiatan::where('user_id', $user->id)
                    ->whereDate('tanggal_kegiatan', $today)
                    ->count(),

                'kegiatan_bulan_ini' => Kegiatan::where('user_id', $user->id)
                    ->whereMonth('tanggal_kegiatan', now()->month)
                    ->whereYear('tanggal_kegiatan', now()->year)
                    ->count(),

                'kategori_terbanyak' => Kegiatan::where('user_id', $user->id)
                    ->select('kategori_kegiatan')
                    ->groupBy('kategori_kegiatan')
                    ->orderByRaw('COUNT(*) DESC')
                    ->value('kategori_kegiatan') ?? '-'
            ];
        }

        if ($user->role === 'admin') {
            $kegiatanTerbaru = Kegiatan::latest('tanggal_kegiatan')
                ->take(5)
                ->get();
        } else {
            $kegiatanTerbaru = Kegiatan::where('user_id', $user->id)
                ->latest('tanggal_kegiatan')
                ->take(5)
                ->get();
        }
        return view('dashboard', compact('stats', 'kegiatanTerbaru'));
    }
}
