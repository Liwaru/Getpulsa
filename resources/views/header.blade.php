<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Getpulsa</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* Sidebar Left Styling */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 280px;
            height: 100vh;
            background: linear-gradient(135deg, #eb0000 0%, #bd0000 100%);
            overflow-y: auto;
            padding-top: 20px;
            z-index: 1000;
            box-shadow: 2px 0 15px rgba(0, 0, 0, 0.2);
        }
        
        /* Sidebar Brand */
        .sidebar-brand {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 20px;
            margin-bottom: 30px;
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
            text-decoration: none !important;
        }
        
        .sidebar-brand img {
            width: 50px;
            height: 50px;
            object-fit: contain;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
            border-radius: 14px;
        }
        
        .sidebar-brand-text {
            color: white;
            font-weight: 800;
            font-size: 1.3rem;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
            letter-spacing: 0.5px;
        }
        
        /* User Info in Sidebar */
        .sidebar-user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px 20px;
            margin: 0 10px 20px 10px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .sidebar-avatar {
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
            border: 2px solid rgba(255, 255, 255, 0.5);
        }
        
        .sidebar-user-details {
            color: white;
            min-width: 0;
        }
        
        .sidebar-user-name {
            font-weight: 700;
            font-size: 0.9rem;
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .sidebar-user-role {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
        }
        
        /* Sidebar Menu */
        .sidebar-nav {
            list-style: none;
            padding: 0 10px;
            margin: 0;
        }
        
        .sidebar-nav li {
            margin-bottom: 8px;
        }
        
        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(255, 255, 255, 0.85) !important;
            padding: 12px 15px;
            border-radius: 8px;
            text-decoration: none !important;
            transition: all 0.3s ease;
            font-weight: 500;
            font-size: 0.95rem;
        }
        
        .sidebar-nav a:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white !important;
            padding-left: 20px;
        }
        
        .sidebar-nav a.active {
            background: rgba(255, 255, 255, 0.25);
            color: white !important;
            border-left: 4px solid white;
            padding-left: 11px;
            font-weight: 600;
        }
        
        .sidebar-nav i {
            font-size: 1.2rem;
            width: 25px;
            text-align: center;
        }
        
        /* =============================================
           CONTENT AREA — FIXED
           ============================================= */
        .content-area {
            margin-left: 280px;
            padding: 20px;
            min-height: 100vh;
            background-color: #f5f7fa;
        }

        /* DIHAPUS: Jangan pernah pakai ini — merusak semua child element!
        .content-area * {
            background-color: transparent !important;
            box-shadow: none !important;
            border: none !important;
        }
        */
        /* ============================================= */

        body {
            background-color: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
            margin: 0;
            padding: 0;
        }
        
        /* Flash Messages */
        .alert {
            margin: 20px 0;
            border-radius: 10px;
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 250px;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .content-area {
                margin-left: 0;
            }
            
            .sidebar-brand img {
                width: 40px;
                height: 40px;
            }
            
            .sidebar-brand-text {
                font-size: 1.1rem;
            }
        }
        
        @media (max-width: 576px) {
            .sidebar {
                width: 220px;
            }
            
            .sidebar-user-info {
                padding: 10px 15px;
                margin: 0 8px 15px 8px;
            }
            
            .sidebar-nav a {
                padding: 10px 12px;
                font-size: 0.9rem;
            }
            
            .sidebar-brand {
                padding: 15px;
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
<!-- Left Sidebar -->
<aside class="sidebar">
    <!-- Brand -->
    <a class="sidebar-brand" href="/home">
        <img src="{{ asset('images/getpulsa.png.png') }}" alt="Logo getpulsa">
        <span class="sidebar-brand-text">Getpulsa</span>
    </a>
    
    <!-- Navigation Menu -->
    <ul class="sidebar-nav">
        @php
            // Helper function untuk check permission
            $hasPermission = function($menuKey) {
                $permissions = session('permissions', []);
                return in_array($menuKey, $permissions);
            };
        @endphp

        @if(session('level') == 1)
            <!-- Customer (Level 1) Menu -->
            @if($hasPermission('profil') || count(session('permissions', [])) === 0)
            <li>
                <a href="/profil">
                    <i class="bi bi-person-circle"></i> Profil
                </a>
            </li>
            @endif

            @if($hasPermission('paket_data') || count(session('permissions', [])) === 0)
            <li>
                <a href="/paket_data">
                    <i class="bi bi-box"></i> Paket Data
                </a>
            </li>
            @endif

            @if($hasPermission('data_transaksi') || count(session('permissions', [])) === 0)
            <li>
                <a href="/riwayat-transaksi">
                    <i class="bi bi-file-earmark-text"></i> Riwayat Transaksi
                </a>
            </li>
            @endif
        @elseif(session('level') == 2)
            <!-- Admin (Level 2) Menu -->
            @if($hasPermission('profil') || count(session('permissions', [])) === 0)
            <li>
                <a href="/profil">
                    <i class="bi bi-person-circle"></i> Profil
                </a>
            </li>
            @endif

            @if($hasPermission('paket_data') || count(session('permissions', [])) === 0)
            <li>
                <a href="/paket_data">
                    <i class="bi bi-box"></i> Paket Data
                </a>
            </li>
            @endif

            @if($hasPermission('data_user') || count(session('permissions', [])) === 0)
            <li>
                <a href="/data-user">
                    <i class="bi bi-people-fill"></i> Data User
                </a>
            </li>
            @endif

            @if($hasPermission('data_transaksi') || count(session('permissions', [])) === 0)
            <li>
                <a href="/riwayat-transaksi">
                     <i class="bi bi-file-earmark-text"></i> Data Transaksi
                </a>
            </li>
            @endif

            @if($hasPermission('statistik_produk') || count(session('permissions', [])) === 0)
            <li>
                <a href="/statistik-produk">
                    <i class="bi bi-bar-chart"></i> Statistik Produk
                </a>
            </li>
            @endif
        @elseif(session('level') == 3)
            <!-- Super Admin (Level 3) Menu -->
            @if($hasPermission('paket_data') || count(session('permissions', [])) === 0)
            <li>
                <a href="/paket_data">
                    <i class="bi bi-box"></i> Paket Data
                </a>
            </li>
            @endif

            @if($hasPermission('data_user') || count(session('permissions', [])) === 0)
            <li>
                <a href="/data-user">
                    <i class="bi bi-people-fill"></i> Data User
                </a>
            </li>
            @endif

            @if($hasPermission('data_admin') || count(session('permissions', [])) === 0)
            <li>
                <a href="/data-admin">
                    <i class="bi bi-person-badge"></i> Data Admin
                </a>
            </li>
            @endif

             @if($hasPermission('data_transaksi') || count(session('permissions', [])) === 0)
            <li>
                <a href="/riwayat-transaksi">
                     <i class="bi bi-file-earmark-text"></i> Data Transaksi
                </a>
            </li>
            @endif

            @if($hasPermission('laporan_penjualan') || count(session('permissions', [])) === 0)
            <li>
                <a href="/laporan-penjualan">
                    <i class="bi bi-graph-up"></i> Laporan Penjualan
                </a>
            </li>
            @endif

            @if($hasPermission('statistik_produk') || count(session('permissions', [])) === 0)
            <li>
                <a href="/statistik-produk">
                    <i class="bi bi-bar-chart"></i> Statistik Produk
                </a>
            </li>
            @endif

            <li>
                <a href="/hak-akses">
                    <i class="bi bi-shield-lock"></i> Hak Akses
                </a>
            </li>
        @elseif(session('level') == 4)
            <!-- Owner (Level 4) Menu -->
            <li>
                <a href="/laporan-penjualan">
                    <i class="bi bi-graph-up"></i> Laporan Penjualan
                </a>
            </li>
            <li>
                <a href="/statistik-produk">
                    <i class="bi bi-bar-chart"></i> Statistik Produk
                </a>
            </li>
        @endif
        
        <!-- Logout for all levels -->
        <li style="margin-top: auto; border-top: 1px solid rgba(255, 255, 255, 0.2); padding-top: 10px;">
            <a href="/logout">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </li>
    </ul>
</aside>

<!-- Konten utama -->

<script>
    // Script untuk sidebar active state
    document.addEventListener('DOMContentLoaded', function() {
        const currentPath = window.location.pathname;
        const sidebarLinks = document.querySelectorAll('.sidebar-nav a');
        
        sidebarLinks.forEach(link => {
            if (link.getAttribute('href') === currentPath) {
                link.classList.add('active');
            }
        });
    });
</script>
</body>
</html>