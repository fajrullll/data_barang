<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BarangController extends Controller
{
    /**
     * Menampilkan semua data barang.
     */
    public function index(Request $request)
    {
        // Mengambil keyword dari URL:
        // contoh: /barang?search=laptop
        $search = trim((string) $request->query('search'));

        // Query data barang
        $barangs = Barang::query()
            ->when($search !== '', function ($query) use ($search) {

                $query->where(function ($q) use ($search) {

                    $q->where('kode_barang', 'like', '%' . $search . '%')
                        ->orWhere('nama_barang', 'like', '%' . $search . '%')
                        ->orWhere('kategori', 'like', '%' . $search . '%')
                        ->orWhere('stok', 'like', '%' . $search . '%')
                        ->orWhere('harga', 'like', '%' . $search . '%');
                });
            })
            ->latest()
            ->get();

        // Semua barang tetap dibutuhkan untuk total barang
        // dan chart kategori agar chart tidak berubah ketika search.
        $allBarangs = Barang::all();

        return view('barang.index', compact(
            'barangs',
            'allBarangs',
            'search'
        ));
    }

    /**
     * Menampilkan form tambah barang.
     */
    public function create()
    {
        return view('barang.create');
    }

    /**
     * Menyimpan barang baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'kategori' => 'required',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
        ]);

        do {
            $kodeBarang = 'BRG-' . strtoupper(Str::random(6));
        } while (Barang::where('kode_barang', $kodeBarang)->exists());

        Barang::create([
            'kode_barang' => $kodeBarang,
            'nama_barang' => $request->nama_barang,
            'kategori' => $request->kategori,
            'stok' => $request->stok,
            'harga' => $request->harga,
        ]);
        return redirect()
            ->route('barang.index')
            ->with('success', 'Data barang berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail barang.
     */
    public function show(string $id)
    {
        $barang = Barang::findOrFail($id);

        return view('barang.show', compact('barang'));
    }

    /**
     * Menampilkan form edit barang.
     */
    public function edit(string $id)
    {
        $barang = Barang::findOrFail($id);

        return view('barang.edit', compact('barang'));
    }

    /**
     * Memperbarui data barang.
     */
    public function update(Request $request, string $id)
    {
        $barang = Barang::findOrFail($id);

        $request->validate([
            'kode_barang' => 'required|unique:barangs,kode_barang,' . $id,
            'nama_barang' => 'required',
            'kategori' => 'required',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
        ]);

        $barang->update([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'kategori' => $request->kategori,
            'stok' => $request->stok,
            'harga' => $request->harga,
        ]);

        return redirect()
            ->route('barang.index')
            ->with('success', 'Data barang berhasil diperbarui.');
    }

    /**
     * Menghapus data barang.
     */
    public function destroy(string $id)
    {
        $barang = Barang::findOrFail($id);

        $barang->delete();

        return redirect()
            ->route('barang.index')
            ->with('success', 'Data barang berhasil dihapus.');
    }
}
