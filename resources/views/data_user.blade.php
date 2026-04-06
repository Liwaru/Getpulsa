@include('header')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Data Pembeli</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(145deg, #e9eef3 0%, #dce2ea 100%);
            font-family: 'Inter', system-ui, sans-serif;
            min-height: 100vh;
            padding: 1.5rem;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        .page-shell {
            width: 100%;
            max-width: 900px;
            margin: 2rem auto 0;
        }

        .page-card {
            background: #ffffff;
            border-radius: 2rem;
            box-shadow: 0 20px 35px -12px rgba(0, 0, 0, 0.12);
            overflow: hidden;
        }

        .page-inner {
            padding: 2rem;
        }

        .page-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 1.5rem;
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #c90000;
            border-left: 4px solid #c90000;
            padding-left: 0.75rem;
        }

        .search-form {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            flex-wrap: wrap;
        }

        .search-label {
            font-size: 0.9rem;
            font-weight: 600;
            color: #1e2f41;
            white-space: nowrap;
        }

        .search-input {
            width: 240px;
            max-width: 100%;
            padding: 0.6rem 0.9rem;
            border-radius: 0.65rem;
            border: 1px solid #d0d7e2;
            font-size: 0.9rem;
            font-family: 'Inter', sans-serif;
            outline: none;
            background: #fff;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .search-input:focus {
            border-color: #c90000;
            box-shadow: 0 0 0 3px rgba(201, 0, 0, 0.08);
        }

        .search-button {
            background: #c90000;
            color: #fff;
            border: none;
            border-radius: 0.65rem;
            padding: 0.6rem 1rem;
            font-size: 0.9rem;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            transition: background 0.2s;
            white-space: nowrap;
        }

        .search-button:hover {
            background: #a50000;
        }

        .table-wrap {
            border-radius: 1rem;
            overflow: hidden;
            border: 1px solid #edf2f7;
        }

        .user-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .user-table thead th {
            background: #c90000;
            color: #fff;
            text-align: left;
            padding: 0.9rem 1.25rem;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .user-table thead th:nth-child(1) { width: 80px; }
        .user-table thead th:nth-child(2) { width: auto; }
        .user-table thead th:nth-child(3) { width: 200px; }

        .user-table tbody td {
            padding: 0.9rem 1.25rem;
            border-bottom: 1px solid #f0f4f9;
            font-size: 0.92rem;
            color: #2c3e4e;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .user-table tbody tr:last-child td {
            border-bottom: none;
        }

        .user-table tbody tr:hover {
            background: #fff7f7;
        }

        .user-table tbody tr:nth-child(even) {
            background: #fafbfd;
        }

        .user-table tbody tr:nth-child(even):hover {
            background: #fff7f7;
        }

        .col-no {
            color: #8f9bb3;
            font-weight: 500;
            text-align: center;
        }

        .user-name {
            font-weight: 600;
            color: #1e2f41;
        }

        .nohp-text {
            color: #5e7a9a;
            font-size: 0.9rem;
        }

        .empty-state {
            padding: 3rem 1rem;
            text-align: center;
            color: #8f9bb3;
            font-size: 0.95rem;
        }

        .empty-state i {
            display: block;
            font-size: 2rem;
            margin-bottom: 0.75rem;
            color: #d0d7e2;
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }
            .page-shell {
                margin-top: 1rem;
            }
            .page-inner {
                padding: 1.25rem;
            }
            .page-toolbar {
                flex-direction: column;
                align-items: flex-start;
            }
            .search-form {
                width: 100%;
            }
            .search-input {
                width: 100%;
                flex: 1;
            }
            .table-wrap {
                overflow-x: auto;
                min-height: 300px;
            }
            .user-table {
                min-width: 480px;
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
                            <th style="text-align:center;">No</th>
                            <th><i class="fas fa-user" style="margin-right:6px;"></i>Nama</th>
                            <th><i class="fas fa-phone" style="margin-right:6px;"></i>No HP</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $user)
                            <tr>
                                <td class="col-no">{{ $index + 1 }}</td>
                                <td class="user-name">{{ $user->nama }}</td>
                                <td class="nohp-text">{{ $user->no_hp_user }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="empty-state">
                                    <i class="fas fa-users-slash"></i>
                                    Tidak ada pembeli dengan nama tersebut
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