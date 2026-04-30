<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
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
        if (Auth::user()->role === 'admin') {
        // Admin lihat semua kegiatan
        $kegiatans = Kegiatan::latest()->get();
    } else {
        // User hanya lihat kegiatannya sendiri
        $kegiatans = Kegiatan::where('user_id', Auth::id())
            ->latest()
            ->get();
    }
        return view('kegiatan.index', compact('kegiatans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        return view('kegiatan.add', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal_kegiatan' => 'required|date',
            'pic' => 'required|string|max:255',
            'posisi' => 'required|string|max:255',
            'judul_kegiatan' => 'required|string|max:255',
            'kategori_kegiatan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            // 'image' sudah mencakup pengecekan tipe file gambar secara umum
            'dokumentasi' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            // Custom message agar user lebih paham
            'dokumentasi.image' => 'File harus berupa gambar.',
            'dokumentasi.mimes' => 'Format gambar yang diizinkan hanya JPG, JPEG, dan PNG.',
            'dokumentasi.max' => 'Ukuran gambar maksimal adalah 2MB.',
        ]);

        if ($request->hasFile('dokumentasi')) {
            // Simpan file ke folder 'public/dokumentasi'
            $path = $request->file('dokumentasi')->store('dokumentasi', 'public');
            $validated['dokumentasi'] = $path;
        }

        Kegiatan::create($validated);

        return redirect()->route('index')->with('success', 'Kegiatan berhasil ditambahkan!');
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
        return view('kegiatan.edit', compact('kegiatan'));
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
            'pic' => 'required|string|max:255',
            'posisi' => 'required|string|max:255',
            'judul_kegiatan' => 'required|string|max:255',
            'kategori_kegiatan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'dokumentasi' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();
        if ($request->hasFile('dokumentasi')) {
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
        // 🔐 PROTEKSI AKSES (tambahkan ini)
        if (Auth::user()->role !== 'admin' && $kegiatan->user_id !== Auth::id()) {
            abort(403, 'Anda tidak punya akses menghapus kegiatan ini.');
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
        $query = Kegiatan::query();

        // 🔐 Role based access
        if ($user->role !== 'admin') {
            $query->where('user_id', $user->id);
        }

        // 📅 Filter tanggal
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal_kegiatan', [
                $request->tanggal_awal,
                $request->tanggal_akhir
            ]);
        }

        // 🏷️ Filter kategori
        if ($request->filled('kategori')) {
            $query->where('kategori_kegiatan', 'like', '%'.$request->kategori.'%');
        }

        // 👤 Filter PIC / Nama
        if ($request->filled('pic')) {
            $query->where('pic', 'like', '%'.$request->pic.'%');
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

        $kegiatans = $query->paginate(10)
            ->appends($request->query());

        return view('kegiatan.history', compact('kegiatans'));
    }

    // Create PDF
    public function exportPdf(Request $request)
    {
        $user = Auth::user();
        $query = Kegiatan::query();

        // 🔐 Role based
        if ($user->role !== 'admin') {
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
            $query->where('kategori_kegiatan', $request->kategori);
        }

        // 👤 PIC
        if ($request->filled('pic')) {
            $query->where('pic', 'like', '%'.$request->pic.'%');
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

        $pdf = Pdf::loadView('kegiatan.pdf', [
            'kegiatans' => $kegiatans,
            'user' => $user
        ])->setPaper('A4', 'landscape');

        // 🔀 MODE OUTPUT
        if ($request->query('mode') === 'download') {
            return $pdf->download('riwayat-kegiatan.pdf');
        }

        // default = preview
        return $pdf->stream('riwayat-kegiatan.pdf');
    }


}
