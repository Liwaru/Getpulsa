@include('header')

<style>
    body {
        margin: 0 !important;
        padding: 0 !important;
    }

    .access-card {
        width: 100%;
        max-width: 900px;
        margin: 0 auto;
        background: #ffffff;
        border-radius: 1rem;
        box-shadow: 0 10px 25px -8px rgba(0, 0, 0, 0.15);
        overflow: hidden;
    }

    .access-header {
        background: #c90000;
        color: white;
        padding: 0.8rem 1.5rem;
        font-size: 1.1rem;
        font-weight: 700;
    }

    .access-body {
        padding: 1rem 1.5rem;
        background: #ffffff;
    }

    .access-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 400px;
    }

    .access-table th,
    .access-table td {
        padding: 0.6rem 1rem;
        text-align: center;
        border-bottom: 1px solid #edf2f7;
        vertical-align: middle;
    }

    .access-table th:first-child,
    .access-table td:first-child {
        text-align: left;
        font-weight: 600;
        background-color: #fffaf5 !important;
        min-width: 200px;
        width: 40%;
    }

    .access-table th {
        background: #c90000 !important;
        color: white !important;
        font-weight: 600;
    }

    .access-table th:first-child {
        background-color: #c90000 !important;
        color: #ffffff !important;
    }

    .access-table tr:hover td {
        background-color: #fff5f5 !important;
    }

    .checkbox-style {
        transform: scale(1.2);
        cursor: pointer;
        accent-color: #c90000;
    }

    .btn-save {
        margin-top: 1rem;
        background: #c90000 !important;
        color: white !important;
        padding: 0.5rem 1.5rem;
        border: none !important;
        border-radius: 2rem;
        font-weight: 600;
        float: right;
        cursor: pointer;
    }

    .btn-save:hover {
        background: #a50000 !important;
    }

    @media (max-width: 768px) {
        .access-table th,
        .access-table td {
            padding: 0.4rem 0.5rem;
            font-size: 0.8rem;
        }
        .btn-save {
            float: none;
            width: 100%;
        }
    }
</style>

<div class="content-area">
    <div class="access-card">
        <div class="access-header">
            <i class="bi bi-shield-lock"></i> Pengaturan Hak Akses Menu
        </div>
        <div class="access-body">
            <form method="POST" action="{{ route('hak_akses.update') }}">
                @csrf
                <div style="overflow-x: auto;">
                    <table class="access-table">
                        <thead>
                            <tr>
                                <th>Menu</th>
                                @foreach($levels as $levelId => $levelName)
                                    <th>{{ $levelName }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($menus as $menu)
                            <tr>
                                <td>{{ ucwords(str_replace('_', ' ', $menu)) }}</td>
                                @foreach($levels as $levelId => $levelName)
                                    <td>
                                        <input type="checkbox"
                                               class="checkbox-style"
                                               name="permissions[{{ $levelId }}][]"
                                               value="{{ $menu }}"
                                               {{ isset($permissions[$levelId][$menu]) ? 'checked' : '' }}>
                                    </td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <button type="submit" class="btn-save">
                    <i class="bi bi-save"></i> Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
</div>

@include('footer')