<?php

/**
 * AdminNewsController Class
 *
 * This class handles the administration of news in the application.
 * It provides functionality for viewing, creating, editing, updating, and deleting news.
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdminNewsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Logic for retrieving and filtering news based on the search term in $request->input('search')
        $query = $request->input('search');

        // Use the model to get paginated news with a search on title
        $news = News::where('title', 'like', "%$query%")->with('user')->paginate(10);

        return view('admin.news.index', compact('news', 'query'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.news.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::check() && !Auth::user()->hasRole(['super admin', 'admin', 'emiweb admin', 'emiweb staff'])) {
            // User is not logged in or does not have the correct role
            return redirect()->route('login');
        }
        try {
            // Attempt to find an existing news
            $news = News::where('title', $request->input('title'))->firstOrFail();

            // Update existing news
            $news->content = $request->input('content');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Create a new news
            $news = new News;
            $news->title = $request->input('title');
            $news->content = $request->input('content');
            $news->user_id = Auth::user()->id;
            $news->create_time = Carbon::now();
        }

        // Save data to the database
        $news->save();

        return redirect()->route('admin.news.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::check() && !Auth::user()->hasRole(['super admin', 'admin', 'emiweb admin', 'emiweb staff'])) {
            // User is not logged in or does not have the correct role
            return redirect()->route('login');
        }

        $news = News::findOrFail($id);

        return view('admin.news.form', ['news' => $news]);
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
        if (Auth::check() && !Auth::user()->hasRole(['super admin', 'admin', 'emiweb admin', 'emiweb staff'])) {
            // User is not logged in or does not have the correct role
            return redirect()->route('login');
        }

        try {
            // Find the news based on ID
            $news = News::findOrFail($id);

            // Update logic here
            $news->title = $request->input('title');
            $news->content = $request->input('content');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // If there is no post with the specified ID, create a new post
            $news = new News;
            // Update logic here

            // Since we are creating a new post, we can also set user ID and creation time here
            $news->user_id = Auth::user()->id;
        }

        // Update fields that apply to both updating and creating
        $news->title = $request->input('title');
        $news->content = $request->input('content');

        // Fields that apply only to updating
        if (isset($news->id)) {
            $news->update_time = Carbon::now();
        }

        // Save data to the database
        $news->save();

        return redirect()->route('admin.news.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::check() && Auth::user()->hasRole(['super admin', 'admin', 'emiweb admin', 'emiweb staff'])) {
            $news = News::findOrFail($id);

            // Delete the news from the database
            $news->delete();

            // Logic after deletion, if necessary

            return redirect()->route('admin.news.index');
        }

        // User is not logged in or does not have the correct role
        return redirect()->route('login');
    }
}
