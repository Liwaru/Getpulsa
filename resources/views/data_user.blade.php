@include('header')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Data Pembeli</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(145deg, #eef2f6 0%, #dde5ee 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            padding: 1.5rem 1.5rem 2rem;
            display: flex;
            justify-content: center;
            align-items: center;  /* Menengahkan vertikal (opsional) */
        }

        /* Kontainer utama: tengah horizontal, lebar maksimal */
        .page-shell {
            width: 100%;
            max-width: 1160px;
            margin: 0 auto;       /* Tengah horizontal */
        }

        .page-card {
            background: #ffffff;
            border-radius: 1.5rem;
            box-shadow: 0 22px 40px -18px rgba(15, 23, 42, 0.18);
            border: 1px solid rgba(201, 0, 0, 0.08);
        }

        .page-inner {
            padding: 1.45rem 1.45rem 1.3rem;
        }

        .page-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 1.25rem;
        }

        .page-title {
            display: flex;
            align-items: center;
            font-size: 1.55rem;
            font-weight: 800;
            color: #c90000;
            letter-spacing: -0.02em;
        }

        .search-form {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex-wrap: wrap;
            margin-left: auto;
        }

        .search-label {
            font-size: 0.95rem;
            font-weight: 700;
            color: #8f0000;
        }

        .search-input {
            width: 280px;
            max-width: 100%;
            padding: 0.85rem 1rem;
            border-radius: 0.75rem;
            border: 1px solid #e5b8b8;
            font-size: 0.95rem;
            outline: none;
            background: #fffdfd;
        }

        .search-input:focus {
            border-color: #cf1c1c;
            box-shadow: 0 0 0 3px rgba(207, 28, 28, 0.14);
        }

        .search-button {
            background: linear-gradient(180deg, #d90000 0%, #b50000 100%);
            color: #fff;
            border: none;
            border-radius: 0.75rem;
            padding: 0.85rem 1.15rem;
            font-weight: 700;
            cursor: pointer;
        }

        .search-button:hover {
            background: linear-gradient(180deg, #c30000 0%, #980000 100%);
        }

        /* Pembungkus tabel dengan tinggi minimal */
        .table-wrap {
            border-radius: 1.2rem;
            overflow: hidden;
            border: 1px solid #efc6c6;
            background: #fff;
            min-height: 400px;   /* Mencegah tabel menyusut ke bawah */
        }

        .user-table {
            width: 100%;
            border-collapse: collapse;
        }

        .user-table thead th {
            background: linear-gradient(180deg, #df0000 0%, #b90000 100%);
            color: #fff;
            text-align: left;
            padding: 1.05rem 1.05rem;
            font-size: 0.96rem;
            font-weight: 700;
        }

        .user-table tbody td {
            padding: 1.05rem 1.05rem;
            border-bottom: 1px solid #f3dddd;
            color: #32465a;
            font-size: 0.95rem;
        }

        .user-table tbody tr:last-child td {
            border-bottom: none;
        }

        .user-table tbody tr:hover {
            background: #fff7f7;
        }

        .user-name {
            font-weight: 700;
            color: #8f0000;
        }

        .empty-state {
            padding: 2rem 1rem;
            text-align: center;
            color: #7b8794;
        }

        /* Responsif */
        @media (max-width: 768px) {
            body {
                padding: 1rem;
                align-items: flex-start; /* di HP, vertikal tidak perlu tengah */
            }
            .page-shell {
                margin: 0;
            }
            .page-inner {
                padding: 1rem;
            }
            .page-title {
                font-size: 1.3rem;
            }
            .search-form {
                width: 100%;
                margin-left: 0;
            }
            .search-input {
                width: 100%;
            }
            .table-wrap {
                overflow-x: auto;
                min-height: 300px; /* sedikit dikurangi di HP */
            }
            .user-table {
                min-width: 640px;
            }
        }
    </style>
</head>
<body>
<div class="page-shell">
    <div class="page-card">
        <div class="page-inner">
            <div class="page-toolbar">
                <div class="page-title">Data Pembeli</div>

                <form class="search-form" method="GET" action="{{ route('data.user') }}">
                    <label class="search-label" for="searchUser">Nama / No HP :</label>
                    <input
                        class="search-input"
                        type="text"
                        name="search"
                        id="searchUser"
                        value="{{ $search }}"
                        placeholder="Cari nama atau no hp..."
                    >
                    <button type="submit" class="search-button">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </form>
            </div>

            <div class="table-wrap">
                <table class="user-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th><i class="fas fa-user"></i> Nama</th>
                            <th><i class="fas fa-phone"></i> No HP</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $user)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="user-name">{{ $user->nama }}</td>
                                <td>{{ $user->no_hp_user }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="empty-state">
                                    <i class="fas fa-users-slash"></i> tidak ada pembeli dengan nama tersebut
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>
@include('footer')