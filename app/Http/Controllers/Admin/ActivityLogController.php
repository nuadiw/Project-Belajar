<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function index()
    {
        // ambil log terbaru
        $logs = Activity::latest()->paginate(20);
        return view('admin.logs.index', compact('logs'));
    }
}
