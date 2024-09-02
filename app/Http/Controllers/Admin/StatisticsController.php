<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\UserLoginHistory;

/**
 *
 */
class StatisticsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statistics = UserLoginHistory::with(['user','organization'])->orderBy('login_at', 'DESC')->paginate(50);
        return view('admin.statistic.index', compact('statistics'));
    }
}
