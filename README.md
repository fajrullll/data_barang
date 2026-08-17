# Aplikasi Data Barang

Aplikasi Laravel ini digunakan untuk mengelola data **barang** dan **kategori** melalui proses CRUD: menampilkan, menambah, mengubah, dan menghapus data.

## Alur Aplikasi

```text
Pengguna membuka URL
        ↓
Route menerima request
        ↓
Controller menjalankan proses
        ↓
Model membaca atau mengubah database
        ↓
Controller mengirim data ke View
        ↓
View menampilkan halaman
```

Saat formulir dikirim, alurnya kembali melalui **Route → Controller → validasi → Model → database**. Setelah berhasil, pengguna diarahkan ke halaman daftar dan menerima pesan sukses.

### Tabel Alur Flow

| Proses            | Request/URL                | Route              | Controller                   | Model/Database                     | View/Hasil                                  |
| ----------------- | -------------------------- | ------------------ | ---------------------------- | ---------------------------------- | ------------------------------------------- |
| Lihat barang      | `GET /barang`              | `barang.index`     | `BarangController@index`     | Mengambil semua data `barangs`     | `barang.index` menampilkan tabel barang     |
| Tambah barang     | `GET /barang/create`       | `barang.create`    | `BarangController@create`    | Belum mengakses database           | Menampilkan `barang.create`                 |
| Simpan barang     | `POST /barang`             | `barang.store`     | `BarangController@store`     | Validasi lalu `Barang::create()`   | Kembali ke daftar barang                    |
| Edit barang       | `GET /barang/{id}/edit`    | `barang.edit`      | `BarangController@edit`      | Mencari barang berdasarkan ID      | Menampilkan `barang.edit`                   |
| Perbarui barang   | `PUT/PATCH /barang/{id}`   | `barang.update`    | `BarangController@update`    | Validasi lalu memperbarui barang   | Kembali ke daftar barang                    |
| Hapus barang      | `DELETE /barang/{id}`      | `barang.destroy`   | `BarangController@destroy`   | Mencari lalu menghapus barang      | Kembali ke daftar barang                    |
| Lihat kategori    | `GET /kategori`            | `kategori.index`   | `KategoriController@index`   | Mengambil semua data `kategoris`   | `kategori.index` menampilkan tabel kategori |
| Tambah kategori   | `GET /kategori/create`     | `kategori.create`  | `KategoriController@create`  | Belum mengakses database           | Menampilkan `kategori.create`               |
| Simpan kategori   | `POST /kategori`           | `kategori.store`   | `KategoriController@store`   | Validasi lalu `Kategori::create()` | Kembali ke daftar kategori                  |
| Edit kategori     | `GET /kategori/{id}/edit`  | `kategori.edit`    | `KategoriController@edit`    | Mencari kategori berdasarkan ID    | Menampilkan `kategori.edit`                 |
| Perbarui kategori | `PUT/PATCH /kategori/{id}` | `kategori.update`  | `KategoriController@update`  | Validasi lalu memperbarui kategori | Kembali ke daftar kategori                  |
| Hapus kategori    | `DELETE /kategori/{id}`    | `kategori.destroy` | `KategoriController@destroy` | Mencari lalu menghapus kategori    | Kembali ke daftar kategori                  |

## 1. Controller

Controller berada di `app/Http/Controllers` dan menghubungkan route, model, serta view.

### `BarangController.php`

Mengatur CRUD barang:

- `index()` mengambil seluruh barang terbaru dan membuka `barang.index`.
- `create()` membuka formulir tambah barang.
- `store()` memvalidasi lalu menyimpan barang baru.
- `show()` mengambil detail barang berdasarkan ID.
- `edit()` mengambil barang lalu membuka formulir edit.
- `update()` memvalidasi lalu memperbarui barang.
- `destroy()` menghapus barang berdasarkan ID.

Validasi memastikan kode barang unik, data utama wajib diisi, stok berupa bilangan bulat minimal `0`, dan harga berupa angka minimal `0`.

### `KategoriController.php`

Mengatur CRUD kategori:

- `index()` mengambil seluruh kategori terbaru dan membuka `kategori.index`.
- `create()` membuka formulir tambah kategori.
- `store()` memvalidasi lalu menyimpan kategori baru.
- `show()` mengambil detail kategori berdasarkan ID.
- `edit()` mengambil kategori lalu membuka formulir edit.
- `update()` memvalidasi lalu memperbarui kategori.
- `destroy()` menghapus kategori berdasarkan ID.

Nama kategori wajib diisi dan unik. Deskripsi boleh kosong.

## 2. Model

Model berada di `app/Models` dan memakai Eloquent ORM untuk berkomunikasi dengan database.

### `barang.php`

Model `Barang` terhubung ke tabel `barangs`. Properti `$fillable` mengizinkan pengisian:

- `kode_barang`
- `nama_barang`
- `kategori`
- `stok`
- `harga`

### `kategori.php`

Model `Kategori` terhubung ke tabel `kategoris`. Properti `$fillable` mengizinkan pengisian:

- `nama_kategori`
- `deskripsi`

## 3. Migration

Migration berada di `database/migrations` dan menentukan struktur tabel database.

### Tabel `barangs`

Migration `2026_08_17_095753_create_barangs_table.php` membuat:

| Kolom                      | Tipe      | Keterangan                    |
| -------------------------- | --------- | ----------------------------- |
| `id`                       | ID        | Primary key                   |
| `kode_barang`              | String    | Nilai unik                    |
| `nama_barang`              | String    | Nama barang                   |
| `kategori`                 | String    | Kategori barang               |
| `stok`                     | Integer   | Nilai awal `0`                |
| `harga`                    | Decimal   | 12 digit dan 2 angka desimal  |
| `created_at`, `updated_at` | Timestamp | Waktu pembuatan dan perubahan |

### Tabel `kategoris`

Migration `2026_08_17_103153_create_kategoris_table.php` membuat:

| Kolom                      | Tipe      | Keterangan                    |
| -------------------------- | --------- | ----------------------------- |
| `id`                       | ID        | Primary key                   |
| `nama_kategori`            | String    | Nilai unik                    |
| `deskripsi`                | Text      | Boleh kosong                  |
| `created_at`, `updated_at` | Timestamp | Waktu pembuatan dan perubahan |

Jalankan migration dengan:

```bash
php artisan migrate
```

## 4. Views

View berada di `resources/views` dan menggunakan Blade.

### Folder `barang`

- `index.blade.php`: halaman dashboard modern 2 panel (tabel Data Barang scrollable di kiri ±70% dan Doughnut Chart Kategori Barang dinamis di kanan ±30%).
- `create.blade.php`: formulir tambah barang.
- `edit.blade.php`: formulir edit barang.

### Folder `kategori`

- `index.blade.php`: tabel daftar kategori serta tombol tambah, edit, dan hapus.
- `create.blade.php`: formulir tambah kategori.
- `edit.blade.php`: formulir edit kategori.

Data ditampilkan memakai sintaks Blade seperti `{{ $barang->nama_barang }}`. Form memakai `@csrf` untuk keamanan. Form edit memakai `@method('PUT')`; form hapus memakai `@method('DELETE')`.

## 5. Routes

Route berada di `routes/web.php`.

```php
Route::get('/', function () {
    return view('welcome');
});

Route::resource('barang', BarangController::class);
Route::resource('kategori', KategoriController::class);
```

Route `/` menampilkan `welcome`. `Route::resource()` otomatis membuat route CRUD:

| Method    | URL Barang          | Controller | Fungsi        |
| --------- | ------------------- | ---------- | ------------- |
| GET       | `/barang`           | `index`    | Daftar barang |
| GET       | `/barang/create`    | `create`   | Form tambah   |
| POST      | `/barang`           | `store`    | Simpan data   |
| GET       | `/barang/{id}`      | `show`     | Detail data   |
| GET       | `/barang/{id}/edit` | `edit`     | Form edit     |
| PUT/PATCH | `/barang/{id}`      | `update`   | Perbarui data |
| DELETE    | `/barang/{id}`      | `destroy`  | Hapus data    |

Pola sama tersedia pada `/kategori`. Lihat seluruh route dengan:

```bash
php artisan route:list
```

## 6. `.env`

`.env` menyimpan konfigurasi lokal dan data sensitif aplikasi. Konfigurasi penting proyek:

- `APP_ENV=local`: lingkungan pengembangan lokal.
- `APP_DEBUG=true`: menampilkan detail error saat pengembangan.
- `APP_URL`: alamat dasar aplikasi.
- `DB_CONNECTION=mysql`: memakai MySQL.
- `DB_HOST` dan `DB_PORT`: alamat server MySQL.
- `DB_DATABASE=data_barang`: nama database.
- `DB_USERNAME` dan `DB_PASSWORD`: autentikasi database.
- `SESSION_DRIVER=database`: session disimpan di database.
- `CACHE_STORE=database`: cache disimpan di database.
- `QUEUE_CONNECTION=database`: antrean memakai database.

> Jangan unggah `.env` ke repository publik karena berisi `APP_KEY`, kredensial database, dan konfigurasi sensitif.

Setelah mengubah `.env`, jalankan:

```bash
php artisan config:clear
```

## Menjalankan Aplikasi

Pastikan database `data_barang` tersedia dan `.env` sudah benar, lalu jalankan:

```bash
php artisan migrate
php artisan serve
```

Buka:

- `http://127.0.0.1:8000/barang` untuk CRUD barang.
- `http://127.0.0.1:8000/kategori` untuk CRUD kategori.
