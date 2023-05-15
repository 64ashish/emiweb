<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Archive;
use App\Models\Category;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;

class  DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user = auth()->user()->load('roles', 'organization','organization.archives.category');

        if(!$user->organization)
        {
            $user->syncRoles('regular user');
            return redirect('/home');
        }else{

            $catArchives =  $user->organization->archives()
                ->with('category')
                ->orderByRaw("FIELD(category_id, 2, 8, 9, 3, 5, 7, 1, 4, 6, 10)")
                ->get()
                ->groupBy('category.name');

            return view('dashboard.dashboard', compact('catArchives'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
