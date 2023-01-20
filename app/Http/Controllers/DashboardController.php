<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use App\Models\Mbarang;
use App\Models\Tpembelianbarang;
use App\Models\Tpembelian;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = User::count();
        $profile = Profile::count();
        $mbarang = Mbarang::count();
        $tpembelianbarang = Tpembelianbarang::count();
        $tpembelian = Tpembelian::count();

        return view('dashboard', compact('user', 'profile','mbarang','tpembelianbarang','tpembelian'));
    }
}