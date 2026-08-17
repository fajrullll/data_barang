<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Kelola data barang, stok, harga, dan kategori dalam satu dashboard.">
    <title>Data Barang | Dashboard Inventori</title>
    <style>
        :root {
            --ink: #14221b;
            --muted: #68776f;
            --line: rgba(29, 66, 47, 0.1);
            --surface: rgba(255, 255, 255, 0.82);
            --green: #168454;
            --green-dark: #0d6840;
            --green-soft: #e7f6ed;
            --amber: #e59d18;
            --red: #d75151;
            --shadow: 0 20px 55px rgba(27, 61, 43, 0.1);
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            height: 100vh;
            margin: 0;
            overflow: hidden;
            color: var(--ink);
            background:
                radial-gradient(circle at 8% 8%, rgba(39, 174, 96, 0.09), transparent 30%),
                radial-gradient(circle at 92% 88%, rgba(232, 176, 61, 0.08), transparent 28%),
                #f8faf8;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        button,
        a {
            font: inherit;
        }

        .page-shell {
            width: min(1500px, calc(100% - 48px));
            height: 100vh;
            margin: 0 auto;
            padding: 24px 0;
            display: flex;
            flex-direction: column;
            box-sizing: border-box;
        }

        .page-heading {
            flex: 0 0 auto;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 24px;
            margin-bottom: 16px;
        }

        .eyebrow {
            margin: 0 0 7px;
            color: var(--green);
            font-size: 0.75rem;
            font-weight: 800;
            letter-spacing: 0.16em;
            text-transform: uppercase;
        }

        h1,
        h2,
        p {
            margin-top: 0;
        }

        h1 {
            margin-bottom: 6px;
            font-size: clamp(2rem, 4vw, 3.25rem);
            line-height: 1;
            letter-spacing: -0.055em;
        }

        .subtitle {
            margin-bottom: 0;
            color: var(--muted);
            font-size: 0.96rem;
        }

        .summary-chip {
            flex: 0 0 auto;
            padding: 10px 16px;
            border: 1px solid rgba(22, 132, 84, 0.16);
            border-radius: 999px;
            color: var(--green-dark);
            background: rgba(255, 255, 255, 0.68);
            box-shadow: 0 8px 24px rgba(24, 90, 59, 0.06);
            font-size: 0.84rem;
            font-weight: 750;
        }

        .dashboard-grid {
            flex: 1;
            min-height: 0;
            display: grid;
            grid-template-columns: minmax(0, 7fr) minmax(290px, 3fr);
            gap: 20px;
            align-items: start;
        }

        .glass-panel {
            border: 1px solid rgba(255, 255, 255, 0.95);
            border-radius: 26px;
            background: var(--surface);
            box-shadow: var(--shadow);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
        }

        .table-panel {
            min-width: 0;
            padding: 24px;
            display: flex;
            flex-direction: column;
            height: 100%;
            min-height: 0;
            box-sizing: border-box;
        }

        .panel-header {
            flex: 0 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 16px;
        }

        .panel-title h2 {
            margin-bottom: 4px;
            font-size: 1.2rem;
            letter-spacing: -0.025em;
        }

        .panel-title p {
            margin-bottom: 0;
            color: var(--muted);
            font-size: 0.82rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            min-height: 40px;
            padding: 0 15px;
            border: 0;
            border-radius: 12px;
            text-decoration: none;
            font-size: 0.82rem;
            font-weight: 750;
            cursor: pointer;
            transition: transform 180ms ease, box-shadow 180ms ease, background-color 180ms ease;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn:focus-visible {
            outline: 3px solid rgba(22, 132, 84, 0.24);
            outline-offset: 3px;
        }

        .btn-add {
            color: #fff;
            background: linear-gradient(135deg, #1b9a62, var(--green-dark));
            box-shadow: 0 10px 22px rgba(13, 104, 64, 0.22);
        }

        .success {
            flex: 0 0 auto;
            margin-bottom: 18px;
            padding: 12px 15px;
            border: 1px solid rgba(22, 132, 84, 0.16);
            border-radius: 13px;
            color: var(--green-dark);
            background: var(--green-soft);
            font-size: 0.88rem;
            font-weight: 650;
        }

        .table-wrap {
            flex: 1;
            min-height: 0;
            width: 100%;
            overflow: auto;
            border: 1px solid var(--line);
            border-radius: 17px;
            background: rgba(255, 255, 255, 0.58);
            scrollbar-width: thin;
            scrollbar-color: #b8c9bf transparent;
        }

        table {
            width: 100%;
            min-width: 830px;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 15px 14px;
            text-align: left;
            white-space: nowrap;
        }

        th {
            position: sticky;
            top: 0;
            z-index: 10;
            color: #607068;
            background: #edf4ef;
            font-size: 0.69rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            box-shadow: 0 1px 0 var(--line);
        }

        td {
            border-top: 1px solid var(--line);
            color: #34463d;
            font-size: 0.84rem;
        }

        tbody tr {
            transition: background-color 160ms ease;
        }

        tbody tr:hover {
            background: rgba(231, 246, 237, 0.52);
        }

        .number-cell {
            color: #92a097;
            font-variant-numeric: tabular-nums;
        }

        .code-cell {
            color: var(--green-dark);
            font-weight: 750;
        }

        .stock-badge,
        .category-badge {
            display: inline-flex;
            align-items: center;
            min-height: 27px;
            padding: 0 9px;
            border-radius: 999px;
            font-size: 0.74rem;
            font-weight: 700;
        }

        .category-badge {
            color: #496157;
            background: #eef3f0;
        }

        .stock-badge {
            color: var(--green-dark);
            background: var(--green-soft);
        }

        .price-cell {
            color: #253a30;
            font-weight: 720;
            font-variant-numeric: tabular-nums;
        }

        .actions {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .actions form {
            margin: 0;
        }

        .btn-edit,
        .btn-delete {
            min-height: 33px;
            padding: 0 11px;
            border-radius: 10px;
        }

        .btn-edit {
            color: #79520b;
            background: #fff2cf;
        }

        .btn-edit:hover {
            background: #ffe8a7;
        }

        .btn-delete {
            color: #a63232;
            background: #fdeaea;
        }

        .btn-delete:hover {
            background: #fbdada;
        }

        .empty-cell {
            height: 190px;
            color: var(--muted);
            text-align: center;
        }

        .chart-panel {
            padding: 24px;
            box-sizing: border-box;
            overflow: hidden;
        }

        .chart-panel .panel-header {
            margin-bottom: 8px;
        }

        .chart-wrap {
            position: relative;
            width: min(100%, 320px);
            aspect-ratio: 1;
            margin: 18px auto 12px;
        }

        .chart-center {
            position: absolute;
            inset: 50% auto auto 50%;
            z-index: 0;
            width: 96px;
            transform: translate(-50%, -50%);
            text-align: center;
            pointer-events: none;
        }

        .chart-total {
            display: block;
            font-size: 1.75rem;
            font-weight: 850;
            letter-spacing: -0.045em;
        }

        .chart-label {
            color: var(--muted);
            font-size: 0.72rem;
            font-weight: 650;
        }

        #category-chart {
            position: relative;
            z-index: 1;
        }

        .chart-empty {
            position: absolute;
            inset: 0;
            display: grid;
            place-items: center;
            border: 18px solid #edf2ef;
            border-radius: 50%;
            color: var(--muted);
            text-align: center;
            font-size: 0.8rem;
        }

        .legend {
            display: grid;
            gap: 9px;
            margin-top: 18px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 11px;
            background: rgba(245, 248, 246, 0.8);
            color: #506159;
            font-size: 0.78rem;
        }

        .legend-name {
            display: flex;
            align-items: center;
            min-width: 0;
            gap: 9px;
        }

        .legend-dot {
            flex: 0 0 auto;
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        .legend-item:nth-child(8n + 1) .legend-dot {
            background: #168454;
        }

        .legend-item:nth-child(8n + 2) .legend-dot {
            background: #e4a72d;
        }

        .legend-item:nth-child(8n + 3) .legend-dot {
            background: #4f7cac;
        }

        .legend-item:nth-child(8n + 4) .legend-dot {
            background: #9b6bc4;
        }

        .legend-item:nth-child(8n + 5) .legend-dot {
            background: #d26464;
        }

        .legend-item:nth-child(8n + 6) .legend-dot {
            background: #43a6a1;
        }

        .legend-item:nth-child(8n + 7) .legend-dot {
            background: #d47c3c;
        }

        .legend-item:nth-child(8n + 8) .legend-dot {
            background: #758c55;
        }

        .legend-text {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .legend-count {
            color: var(--ink);
            font-weight: 800;
        }

        @media (max-width: 1050px) {

            html,
            body {
                height: auto;
                min-height: 100vh;
                overflow: auto;
            }

            .page-shell {
                height: auto;
                padding: 24px 0;
            }

            .dashboard-grid {
                flex: none;
                grid-template-columns: 1fr;
            }

            .table-panel {
                height: auto;
            }

            .table-wrap {
                max-height: 480px;
            }

            .chart-panel {
                height: auto;
            }

            .chart-wrap {
                width: min(100%, 280px);
            }
        }

        @media (max-width: 640px) {
            .page-shell {
                width: min(100% - 24px, 1500px);
                padding: 26px 0;
            }

            .page-heading,
            .panel-header {
                align-items: stretch;
                flex-direction: column;
            }

            .summary-chip {
                align-self: flex-start;
            }

            .table-panel,
            .chart-panel {
                padding: 17px;
                border-radius: 20px;
            }

            .btn-add {
                width: 100%;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                transition: none !important;
            }
        }
    </style>
</head>

<body>
    @php
    $categoryCounts = $barangs->groupBy('kategori')->map->count();
    $chartColors = ['#168454', '#e4a72d', '#4f7cac', '#9b6bc4', '#d26464', '#43a6a1', '#d47c3c', '#758c55'];
    @endphp

    <main class="page-shell">
        <header class="page-heading">
            <div>
                <p class="eyebrow">Inventory Management</p>
                <h1>Data Barang</h1>
                <p class="subtitle">Kelola stok, harga, dan kategori barang secara ringkas.</p>
            </div>
            <div class="summary-chip">{{ $barangs->count() }} barang tercatat</div>
        </header>

        <div class="dashboard-grid">
            <section class="glass-panel table-panel" aria-labelledby="table-title">
                <div class="panel-header">
                    <div class="panel-title">
                        <h2 id="table-title">Daftar Barang</h2>
                        <p>Informasi inventori terbaru</p>
                    </div>
                    <a id="add-item-button" href="{{ route('barang.create') }}" class="btn btn-add">
                        <span aria-hidden="true">+</span> Tambah Barang
                    </a>
                </div>

                @if (session('success'))
                <div class="success" role="status">{{ session('success') }}</div>
                @endif

                <div class="table-wrap" tabindex="0" aria-label="Tabel data barang, geser horizontal bila diperlukan">
                    <table>
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Kode Barang</th>
                                <th scope="col">Nama Barang</th>
                                <th scope="col">Kategori</th>
                                <th scope="col">Stok</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($barangs as $barang)
                            <tr>
                                <td class="number-cell">{{ $loop->iteration }}</td>
                                <td class="code-cell">{{ $barang->kode_barang }}</td>
                                <td>{{ $barang->nama_barang }}</td>
                                <td><span class="category-badge">{{ $barang->kategori }}</span></td>
                                <td><span class="stock-badge">{{ $barang->stok }}</span></td>
                                <td class="price-cell">Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>
                                <td>
                                    <div class="actions">
                                        <a id="edit-item-{{ $barang->id }}" href="{{ route('barang.edit', $barang->id) }}" class="btn btn-edit" aria-label="Edit {{ $barang->nama_barang }}">Edit</a>
                                        <form action="{{ route('barang.destroy', $barang->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button id="delete-item-{{ $barang->id }}" type="submit" class="btn btn-delete" aria-label="Hapus {{ $barang->nama_barang }}">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="empty-cell">Belum ada data barang.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            <aside class="glass-panel chart-panel" aria-labelledby="chart-title">
                <div class="panel-header">
                    <div class="panel-title">
                        <h2 id="chart-title">Kategori Barang</h2>
                        <p>Distribusi jumlah per kategori</p>
                    </div>
                </div>

                <div class="chart-wrap">
                    @if ($categoryCounts->isNotEmpty())
                    <canvas
                        id="category-chart"
                        role="img"
                        aria-label="Doughnut chart jumlah barang per kategori"
                        data-labels="{{ $categoryCounts->keys()->values()->toJson() }}"
                        data-values="{{ $categoryCounts->values()->toJson() }}"
                        data-palette="{{ collect($chartColors)->toJson() }}"></canvas>
                    <div class="chart-center" aria-hidden="true">
                        <span class="chart-total">{{ $barangs->count() }}</span>
                        <span class="chart-label">Total Barang</span>
                    </div>
                    @else
                    <div class="chart-empty">Belum ada<br>data kategori</div>
                    @endif
                </div>


            </aside>
        </div>
    </main>

    @if ($categoryCounts->isNotEmpty())
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
    <script>
        const chartCanvas = document.getElementById('category-chart');
        const labels = JSON.parse(chartCanvas.dataset.labels);
        const values = JSON.parse(chartCanvas.dataset.values);
        const palette = JSON.parse(chartCanvas.dataset.palette);

        new Chart(chartCanvas, {
            type: 'doughnut',
            data: {
                labels,
                datasets: [{
                    data: values,
                    backgroundColor: labels.map((_, index) => palette[index % palette.length]),
                    borderColor: '#ffffff',
                    borderWidth: 4,
                    hoverOffset: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                animation: {
                    duration: 700
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        displayColors: true,
                        callbacks: {
                            label: context => ` ${context.label}: ${context.raw} barang`
                        }
                    }
                }
            }
        });
    </script>
    @endif
</body>

</html>