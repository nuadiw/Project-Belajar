<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;


class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kegiatans = Kegiatan::with(['user.position', 'category']) // Wajib pakai user.position
        ->where('user_id', Auth::id())
        ->get();
    return view('kegiatan.index', compact('kegiatans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all(); // Mengambil semua kategori untuk dropdown

        // Jika Admin/Coordinator, ambil semua user untuk fitur delegasi input
        $users = [];
        if (Auth::user()->role == 'admin') {
            $users = User::all();
        } elseif (Auth::user()->role == 'coordinator') {
            // Ambil user yang jabatannya sama/satu tim (sesuaikan logika bisnismu)
            $users = User::where('position_id', Auth::user()->position_id)->get();
        }

        return view('kegiatan.add', compact('categories', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'judul_kegiatan' => 'required',
            'tanggal_kegiatan' => 'required|date',
            // Validasi lainnya...
        ]);

        $kegiatan = new Kegiatan();
        $kegiatan->tanggal_kegiatan = $request->tanggal_kegiatan;
        $kegiatan->judul_kegiatan = $request->judul_kegiatan;
        $kegiatan->category_id = $request->category_id; // Simpan ID Kategori
        $kegiatan->deskripsi = $request->deskripsi;

        // Logika Delegasi Input:
        // Jika Admin/Coordinator memilih user lain, gunakan ID tersebut.
        // Jika tidak, gunakan ID user yang sedang login.
        $kegiatan->user_id = $request->user_id ?? Auth::id();

        // Proses upload dokumentasi...
        if ($request->hasFile('dokumentasi')) {
            $kegiatan->dokumentasi = $request->file('dokumentasi')->store('dokumentasi', 'public');
        }

        $kegiatan->save();

        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil dicatat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kegiatan = Kegiatan::findOrFail($id);

        // Proteksi akses
        if (Auth::user()->role !== 'admin' && $kegiatan->user_id !== Auth::id()) {
            abort(403);
        }

        $categories = Category::all(); // Tambahkan ini untuk dropdown di view edit
        return view('kegiatan.edit', compact('kegiatan', 'categories'));
        }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $kegiatan = Kegiatan::findOrFail($id);

        if (Auth::user()->role !== 'admin' && $kegiatan->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'tanggal_kegiatan' => 'required|date',
            'category_id'      => 'required|exists:categories,id', // Ganti kategori_kegiatan
            'judul_kegiatan'   => 'required|string|max:255',
            'deskripsi'        => 'required|string',
            'dokumentasi'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except('dokumentasi'); // Ambil semua kecuali file dulu

        if ($request->hasFile('dokumentasi')) {
            // Hapus foto lama jika ada upload baru
            if ($kegiatan->dokumentasi) {
                Storage::disk('public')->delete($kegiatan->dokumentasi);
            }
            $data['dokumentasi'] = $request->file('dokumentasi')->store('dokumentasi', 'public');
        }

        $kegiatan->update($data);
        return redirect()->route('kegiatans.index')->with('success', 'Kegiatan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);

        if (Auth::user()->role !== 'admin' && $kegiatan->user_id !== Auth::id()) {
            abort(403, 'Anda tidak punya akses.');
        }

        if ($kegiatan->dokumentasi) {
            Storage::disk('public')->delete($kegiatan->dokumentasi);
        }

        $kegiatan->delete();
        return redirect()->route('kegiatans.index')->with('success', 'Kegiatan berhasil dihapus!');
    }

    public function destroyMultiple(Request $request)
    {
        $ids = $request->ids;

        if (!$ids || count($ids) === 0) {
            return redirect()->back()->with('error', 'Tidak ada kegiatan yang dipilih.');
        }

         // 🔐 FILTER BERDASARKAN ROLE
        if (Auth::user()->role !== 'admin') {
            // user hanya boleh hapus miliknya sendiri
            $ids = Kegiatan::whereIn('id', $ids)
                ->where('user_id', Auth::id())
                ->pluck('id')
                ->toArray();
        }

        if (count($ids) === 0) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses menghapus kegiatan tersebut.');
        }

        $kegiatans = Kegiatan::whereIn('id', $ids)->get();

        foreach ($kegiatans as $kegiatan) {
            if ($kegiatan->dokumentasi) {
                Storage::disk('public')->delete($kegiatan->dokumentasi);
            }
            $kegiatan->delete();
        }

        return redirect()->route('kegiatans.index')->with('success', count($ids).' kegiatan berhasil dihapus.');
    }


    public function riwayat(Request $request)
    {
        $user = Auth::user();
        // Gunakan with() agar tidak lambat (Eager Loading)
        $query = Kegiatan::with(['user.position', 'category']);

        // 🔐 Role based access
        if ($user->role === 'admin') {
            // Admin: Lihat semua
        } elseif ($user->role === 'coordinator') {
            // Coordinator: Lihat kegiatan tim berdasarkan kesamaan position_id di tabel users
            $query->whereHas('user', function($q) use ($user) {
                $q->where('position_id', $user->position_id);
            });
        } else {
            // Staff: Hanya miliknya sendiri
            $query->where('user_id', $user->id);
        }

        // 📅 Filter tanggal
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal_kegiatan', [$request->tanggal_awal, $request->tanggal_akhir]);
        }

        // 🏷️ Filter kategori (Sekarang pakai ID)
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // 👤 Filter PIC / Nama (Mencari di tabel users)
        if ($request->filled('nama_user')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->nama_user . '%');
            });
        }

        // ↕️ Sorting
        $sortField = $request->get('sort', 'tanggal_kegiatan');
        $direction = $request->get('direction', 'desc');
        $query->orderBy($sortField, $direction);

        $kegiatans = $query->paginate(10)->appends($request->query());
        $categories = Category::all(); // Untuk dropdown filter di view

        return view('kegiatan.history', compact('kegiatans', 'categories'));
    }

    // Create PDF
    public function exportPdf(Request $request)
    {
        $user = Auth::user();
        $query = Kegiatan::query();

        // 🔐 FIX: Samakan Role Based Access dengan fungsi riwayat
        if ($user->role === 'admin') {
            // Admin: Biarkan query tanpa filter tambahan agar ambil semua data
        } elseif ($user->role === 'coordinator') {
            // Coordinator: Ambil data satu tim berdasarkan kolom 'posisi'
            $query->where('posisi', $user->position);
        } else {
            // Member/Staff: Hanya ambil data miliknya sendiri
            $query->where('user_id', $user->id);
        }

        // 📅 Filter tanggal
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal_kegiatan', [
                $request->tanggal_awal,
                $request->tanggal_akhir
            ]);
        }

        // 🏷️ Kategori
        if ($request->filled('kategori')) {
            // Gunakan 'like' agar lebih fleksibel jika ada spasi/perbedaan case
            $query->where('kategori_kegiatan', 'like', '%' . $request->kategori . '%');
        }

        // 👤 PIC
        if ($request->filled('pic')) {
            $query->where('pic', 'like', '%' . $request->pic . '%');
        }

        // ↕️ Sorting
        if ($request->filled('sort')) {
            $query->orderBy(
                $request->sort,
                $request->direction === 'desc' ? 'desc' : 'asc'
            );
        } else {
            $query->orderBy('tanggal_kegiatan', 'desc');
        }

        $kegiatans = $query->get();

        // Pastikan view 'kegiatan.pdf' sudah menggunakan loop @foreach($kegiatans as $k)
        $pdf = Pdf::loadView('kegiatan.pdf', [
            'kegiatans' => $kegiatans,
            'user' => $user
        ])->setPaper('A4', 'landscape');

        // 🔀 MODE OUTPUT
        if ($request->query('mode') === 'download') {
            return $pdf->download('riwayat-kegiatan.pdf');
        }

        return $pdf->stream('riwayat-kegiatan.pdf');
    }


}
