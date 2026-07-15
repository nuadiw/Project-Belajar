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
            $kegiatanTerbaru = Kegiatan::with(['user.position', 'category'])->latest('tanggal_kegiatan')->take(5)->get();

        } elseif ($user->role === 'coordinator') {
            // Stats untuk Coordinator (Filter relasi lewat users.position_id)
            $stats = [
                'total_kegiatan_tim' => Kegiatan::whereHas('user', function($q) use ($user) {
                    $q->where('position_id', $user->position_id);
                })->count(),

                'kegiatan_hari_ini' => Kegiatan::whereHas('user', function($q) use ($user) {
                    $q->where('position_id', $user->position_id);
                })->whereDate('tanggal_kegiatan', $today)->count(),

                'kegiatan_bulan_ini' => Kegiatan::whereHas('user', function($q) use ($user) {
                    $q->where('position_id', $user->position_id);
                })->whereMonth('tanggal_kegiatan', now()->month)->count(),

                // Perbaikan hitung anggota tim menggunakan kolom position_id yang baru
                'total_anggota_tim' => User::where('position_id', $user->position_id)->count(),
            ];

            // Mengambil kegiatan tim terbaru (Eager loading disertakan agar render view cepat)
            $kegiatanTerbaru = Kegiatan::with(['user.position', 'category'])
                ->whereHas('user', function($q) use ($user) {
                    $q->where('position_id', $user->position_id);
                })
                ->latest('tanggal_kegiatan')
                ->take(5)
                ->get();

        } else {
            // Stats untuk Staff biasa
            $stats = [
                'total_kegiatan_saya' => Kegiatan::where('user_id', $user->id)->count(),
                'kegiatan_hari_ini' => Kegiatan::where('user_id', $user->id)
                                        ->whereDate('tanggal_kegiatan', $today)->count(),
                'kegiatan_bulan_ini' => Kegiatan::where('user_id', $user->id)
                                        ->whereMonth('tanggal_kegiatan', now()->month)->count(),
                'kategori_terbanyak' => Kegiatan::where('user_id', $user->id)
                                        ->select('category_id')->groupBy('category_id')
                                        ->orderByRaw('COUNT(*) DESC')->value('category_id') ?? '-'
            ];
            $kegiatanTerbaru = Kegiatan::with(['user.position', 'category'])
                                ->where('user_id', $user->id)
                                ->latest('tanggal_kegiatan')->take(5)->get();
        }

        return view('dashboard', compact('stats', 'kegiatanTerbaru'));
    }
}
