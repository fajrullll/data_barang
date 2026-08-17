<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Barang</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 1100px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 8px;
        }

        h1 {
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            color: white;
            background-color: #198754;
            margin-bottom: 20px;
        }

        .btn-edit {
            background-color: #ffc107;
            color: black;
            padding: 8px 12px;
            border-radius: 20px;
            margin-bottom: 0;
        }

        .btn-delete {
            background-color: #dc3545;
            border: none;
            color: white;
            padding: 8px 12px;
            border-radius: 20px;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #343a40;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .success {
            padding: 12px;
            margin-bottom: 20px;
            background-color: #d1e7dd;
            color: #0f5132;
            border-radius: 5px;
        }

        .aksi {
            display: flex;
            gap: 5px;
            align-items: center;
        }
    </style>
</head>

<body>

    <div class="container">

        <h1>Data Barang</h1>

        {{-- Pesan sukses --}}
        @if (session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
        @endif

        {{-- Tombol tambah --}}
        <a href="{{ route('barang.create') }}" class="btn">
            + Tambah Barang
        </a>

        {{-- Tabel barang --}}
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse ($barangs as $barang)

                <tr>
                    <td>{{ $loop->iteration }}</td>

                    <td>
                        {{ $barang->kode_barang }}
                    </td>

                    <td>
                        {{ $barang->nama_barang }}
                    </td>

                    <td>
                        {{ $barang->kategori }}
                    </td>

                    <td>
                        {{ $barang->stok }}
                    </td>

                    <td>
                        Rp {{ number_format($barang->harga, 0, ',', '.') }}
                    </td>

                    <td>
                        <div class="aksi">

                            {{-- Edit --}}
                            <a
                                href="{{ route('barang.edit', $barang->id) }}"
                                class="btn btn-edit">
                                Edit
                            </a>

                            {{-- Hapus --}}
                            <form
                                action="{{ route('barang.destroy', $barang->id) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn-delete">
                                    Hapus
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>

                @empty

                <tr>
                    <td colspan="7" style="text-align: center;">
                        Belum ada data barang.
                    </td>
                </tr>

                @endforelse

            </tbody>
        </table>

    </div>

</body>

</html>