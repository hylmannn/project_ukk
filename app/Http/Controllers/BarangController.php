<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $rsetBarang = Barang::latest()->paginate(10);
        // return view('v_barang.index',compact('rsetBarang'));

        // return view('vsiswa.index');

        $rsetBarang = Barang::all();
        $namaProduk = Barang::with('kategori')->get();
        return view('v_barang.index',compact('rsetBarang', 'namaProduk'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = Kategori::all();

        $aKategori = array('blank'=>'Pilih Kategori',
                            'A'=>'Alat',
                            'B'=>'Bahan',
                            );
        return view('v_barang.create',compact('aKategori', 'kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $request->validate( [
            'merk'              => 'required|unique:barang,merk',
            'seri'              => 'required',
            'spesifikasi'       => 'required',
            'kategori_id'          => 'required|integer|min:0',
        ]);


        //create post
        Barang::create([
            'merk'          => $request->merk,
            'seri'          => $request->seri,
            'spesifikasi'   => $request->spesifikasi,
            'stok'      => $request->stok,
            'kategori_id'      => $request->kategori_id,
        ]);

        //redirect to index
        return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rsetBarang = Barang::find($id);
        $deskripsiKategori = Barang::with('kategori')->where('id', $id)->first();
        return view('v_barang.show', compact('rsetBarang', 'deskripsiKategori'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // $aKategori = array('blank'=>'Pilih Kategori',
        //                 'M'=>'Barang Modal',
        //                 'A'=>'Alat',
        //                 'BHP'=>'Bahan Habis Pakai',
        //                 'BTHP'=>'Bahan Tidak Habis Pakai'
        //             );

        $rsetBarang = Barang::find($id);
        $kategoriID = Kategori::all();
        //return $rsetBarang;
        return view('v_barang.edit', compact('rsetBarang', 'kategoriID'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $request->validate( [
        'merk' => 'required',
        'seri' => 'required',
        'spesifikasi' => 'required',
        'stok' => 'required',
        'kategori_id' => 'required',
    ]);

    $rsetBarang = Barang::find($id);
    $rsetBarang->update($request->all());

    return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Diubah!']);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (DB::table('barangmasuk')->where('barang_id', $id)->exists() || DB::table('barangkeluar')->where('barang_id', $id)->exists()) {
            return redirect()->route('barang.index')->with(['Gagal' => 'Gagal dihapus']);
        } else {
            $rsetBarang = Barang::find($id);
            $rsetBarang->delete();
            return redirect()->route('barang.index')->with(['Success' => 'Berhasil dihapus']);
        }
    }
}
