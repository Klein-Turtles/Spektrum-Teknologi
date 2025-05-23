<?php

namespace App\Http\Controllers;
use App\Models\Portofolio;
use Illuminate\Http\Request;

class PortoPageController extends Controller
{
        public function portofolio()
    {

        $portofolio = Portofolio::paginate(6);
        return view('portofolio', compact('portofolio'));
    }
    public function detailporto($slug)
    {
        $portofolio = Portofolio::where('slug', $slug)->firstOrFail();
        return view('detail-porto', compact('portofolio'));
    }

    //CRUD

    //INSERT 

        public function create()
    {
        return view('dashboard.input-porto'); // Mengarahkan ke form input portofolio
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nama'=>'required|string|max:255',
            'deskripsi_singkat'=>'required|string|max:255',
            'deskripsi'=>'required|string|max:1000',
            'client'=>'required|string',
            'tahun'=>'required|integer',
            'spesifikasi'=>'required|string|max:1000',
            'gambar'=>'required|image|mimes:jpg,jpeg,png,gif'
        
        ]);

        $gambarPath = $request->file('gambar')->store('portofolio', 'public');

        Portofolio::create([
            'nama'=>$request->nama,
            'deskripsi_singkat'=>$request->deskripsi_singkat,
            'deskripsi'=>$request->deskripsi,
            'client'=>$request->client,
            'tahun'=>$request->tahun,
            'spesifikasi'=>$request->spesifikasi,
            'gambar'=>$gambarPath
        ]);

        return redirect()->route('input_porto')->with('success', 'Portofolio berhasil ditambahkan!');

    }

    //admin dashboard utama 

        public function portoShow (){

        $portofolio = Portofolio::paginate(8);
        return view ('dashboard.portofolio', compact('portofolio'));
    }

        public function edit($id)
    {
        $portofolio = Portofolio::findOrFail($id);
        return view('dashboard.edit-porto', compact('portofolio'));
    }

        public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi_singkat' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:1000',
            'client' => 'required|string',
            'tahun' => 'required|integer',
            'spesifikasi' => 'required|string|max:1000',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,gif',
        ]);

        $portofolio = Portofolio::findOrFail($id);

        // Jika ada gambar baru, upload dan update path-nya
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('portofolio', 'public');
            $portofolio->gambar = $gambarPath;
        }

        // Update field lainnya
        $portofolio->update([
            'nama' => $request->nama,
            'deskripsi_singkat' => $request->deskripsi_singkat,
            'deskripsi' => $request->deskripsi,
            'client' => $request->client,
            'tahun' => $request->tahun,
            'spesifikasi' => $request->spesifikasi,
        ]);

        return redirect()->route('admin_porto')->with('success', 'Portofolio berhasil diperbarui!');
    }

    public function destroy(Portofolio $id)
    {
        $id->delete();
        return back()->with('success', 'Portofolio berhasil dihapus.');
    }
}
