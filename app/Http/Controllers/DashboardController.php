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
            // Stats untuk Admin (Global)
            $stats = [
                'total_kegiatan' => Kegiatan::count(),
                'kegiatan_hari_ini' => Kegiatan::whereDate('tanggal_kegiatan', $today)->count(),
                'kegiatan_bulan_ini' => Kegiatan::whereMonth('tanggal_kegiatan', now()->month)->count(),
                'total_user' => User::count(),
            ];
            $kegiatanTerbaru = Kegiatan::latest('tanggal_kegiatan')->take(5)->get();

        } elseif ($user->role === 'coordinator') {
            // Stats untuk Coordinator (Filter per tim/posisi)
            $stats = [
                'total_kegiatan_tim' => Kegiatan::where('posisi', $user->position)->count(),
                'kegiatan_hari_ini' => Kegiatan::where('posisi', $user->position)
                                        ->whereDate('tanggal_kegiatan', $today)->count(),
                'kegiatan_bulan_ini' => Kegiatan::where('posisi', $user->position)
                                        ->whereMonth('tanggal_kegiatan', now()->month)->count(),
                'total_anggota_tim' => User::where('position', $user->position)->count(),
            ];
            $kegiatanTerbaru = Kegiatan::where('posisi', $user->position)
                                ->latest('tanggal_kegiatan')->take(5)->get();

        } else {
            // Stats untuk Staff biasa
            $stats = [
                'total_kegiatan_saya' => Kegiatan::where('user_id', $user->id)->count(),
                'kegiatan_hari_ini' => Kegiatan::where('user_id', $user->id)
                                        ->whereDate('tanggal_kegiatan', $today)->count(),
                'kegiatan_bulan_ini' => Kegiatan::where('user_id', $user->id)
                                        ->whereMonth('tanggal_kegiatan', now()->month)->count(),
                'kategori_terbanyak' => Kegiatan::where('user_id', $user->id)
                                        ->select('kategori_kegiatan')->groupBy('kategori_kegiatan')
                                        ->orderByRaw('COUNT(*) DESC')->value('kategori_kegiatan') ?? '-'
            ];
            $kegiatanTerbaru = Kegiatan::where('user_id', $user->id)
                                ->latest('tanggal_kegiatan')->take(5)->get();
        }

        return view('dashboard', compact('stats', 'kegiatanTerbaru'));
    }
}
