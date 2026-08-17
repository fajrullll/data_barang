<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Barang</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 8px;
        }

        h1 {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button,
        a {
            display: inline-block;
            padding: 10px 15px;
            margin-top: 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }

        button {
            background-color: #198754;
            color: white;
        }

        .kembali {
            background-color: #6c757d;
            color: white;
        }

        .error {
            background-color: #f8d7da;
            color: #842029;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
    </style>
</head>

<body>

    <div class="container">

        <h1>Tambah Barang</h1>

        {{-- Menampilkan error validasi --}}
        @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('barang.store') }}" method="POST">

            @csrf

            <label for="nama_barang">Nama Barang</label>
            <input
                type="text"
                id="nama_barang"
                name="nama_barang"
                value="{{ old('nama_barang') }}"
                placeholder="Contoh: Laptop"
                required>

            <label for="kategori">Kategori</label>
            <input
                type="text"
                id="kategori"
                name="kategori"
                value="{{ old('kategori') }}"
                placeholder="Contoh: Elektronik"
                required>

            <label for="stok">Stok</label>
            <input
                type="number"
                id="stok"
                name="stok"
                value="{{ old('stok', 0) }}"
                min="0"
                required>

            <label for="harga">Harga</label>
            <input
                type="number"
                id="harga"
                name="harga"
                value="{{ old('harga') }}"
                min="0"
                placeholder="Contoh: 5000000"
                required>

            <button type="submit">
                Simpan Barang
            </button>

            <a href="{{ route('barang.index') }}" class="kembali">
                Kembali
            </a>

        </form>

    </div>

</body>

</html>