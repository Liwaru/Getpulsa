<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Session;

class PermissionHelper
{
    /**
     * Check apakah user memiliki permission untuk menu tertentu
     * 
     * @param string $menuKey Kunci menu yang diinginkan (data_user, data_admin, data_transaksi, dll)
     * @return bool
     */
    public static function hasPermission(string $menuKey): bool
    {
        $permissions = Session::get('permissions', []);
        
        // Jika permissions kosong (belum di-load), anggap user punya akses ke semua
        // Ini untuk backward compatibility
        if (count($permissions) === 0) {
            return true;
        }
        
        return in_array($menuKey, $permissions);
    }

    /**
     * Get all permissions untuk user saat ini
     * 
     * @return array
     */
    public static function getPermissions(): array
    {
        return Session::get('permissions', []);
    }

    /**
     * Check multiple permissions (semua harus true)
     * 
     * @param array $menuKeys
     * @return bool
     */
    public static function hasAllPermissions(array $menuKeys): bool
    {
        foreach ($menuKeys as $menuKey) {
            if (!self::hasPermission($menuKey)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Check multiple permissions (minimal satu harus true)
     * 
     * @param array $menuKeys
     * @return bool
     */
    public static function hasAnyPermission(array $menuKeys): bool
    {
        foreach ($menuKeys as $menuKey) {
            if (self::hasPermission($menuKey)) {
                return true;
            }
        }
        return false;
    }
}
