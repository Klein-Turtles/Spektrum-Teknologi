@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h1 class="h3 mb-4">Tambah product Baru</h1>

    <form action="{{ route('update_product', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" name="nama" id="nama" class="form-control"  value="{{ old('nama',$product->nama) }}" required>
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4" required> {{ old('deskripsi', $product->deskripsi) }} </textarea>
            </div>

            <div class="mb-3">
                <label for="harga" class="form-label">harga</label>
                <input type="number" name="harga" id="harga" class="form-control"  value="{{ old('harga',$product->harga) }}" required>
        </div>

        <div class="mb-3">
            <label for="gambar" class="form-label">Gambar</label>
            <input type="file" name="gambar" id="gambar" class="form-control">
        </div>

        <div class="mb-3">
            <label for="kategori" class="form-label">Kategori</label>
            <select name="kategori" id="kategori" class="form-select"  value="{{ old('kategori',$product->kategori) }}" required>
                @foreach ($kategori as $cat)
                    <option value="{{ $cat }}" {{ old('kategori', $product->kategori) == $cat ? 'selected' : ''}}>
                        {{ $cat }}
                    </option>
                @endforeach
            </select>
        </div>


        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
