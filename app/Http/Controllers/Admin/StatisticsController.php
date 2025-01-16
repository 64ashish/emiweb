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
    public function index(Request $request)
    {
        $sortName = 'login_at';
        $sortType = 'DESC';
        $ip_address = $request->ip_address;
        if(isset($request->sort)){
            $sortable = explode('-',$request->sort);
            if($sortable[0] == 'user'){
                $sortName = 'user_id';
            }else if($sortable[0] == 'ip'){
                $sortName = 'ip_address';
            }else if($sortable[0] == 'org'){
                $sortName = 'organization_id';
            }else if($sortable[0] == 'date'){
                $sortName = 'login_at';
            }
            $sortType = $sortable[1];
        }
        $statistics = UserLoginHistory::with(['user','organization']);
        if(isset($ip_address) && $ip_address != ''){
            $statistics = $statistics->where('ip_address', 'like', $ip_address)
            ->orWhere('ip_address', 'LIKE', $ip_address . '%');
        }
        $statistics = $statistics->orderBy($sortName, $sortType)->paginate(50);
        $statistics->appends(['ip_address' => $ip_address]);
        return view('admin.statistic.index', compact('statistics', 'ip_address'));
    }

    public function search(Request $request)
    {
        $validated = $request->validate([
            'ip_address' => 'required'
        ]);
    
        if ($validated) {
            $ip_address = $request->ip_address;
            $statistics = UserLoginHistory::where('ip_address', 'like', $ip_address)
                ->orWhere('ip_address', 'LIKE', $ip_address . '%')
                ->paginate(50);
    
            // Append the search query to the pagination links
            $statistics->appends(['ip_address' => $ip_address]);
            
            return view('admin.statistic.index', [
                'statistics' => $statistics,
                'ip_address' => $ip_address
            ]);
        }
    }
}
