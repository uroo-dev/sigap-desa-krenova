<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Surat;
use App\Models\User;
use App\Models\Warga;
use Illuminate\View\View;

class DashboardAdminController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'totalUser' => User::count(),
            'totalWarga' => Warga::count(),
            'totalLaporan' => Laporan::count(),
            'totalSurat' => Surat::count(),
        ]);
    }
}
