<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArchiveRequest;
use App\Models\Archive;
use App\Models\Category;
use App\Models\DenmarkEmigration;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $archives = Archive::with('category','organizations')->get();
//        return $archives;
        return view('admin.archives.index', compact('archives'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Category $category)
    {
        //
        return view('admin.archives.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ArchiveRequest $archiveRequest
     * @param Category $category
     * @param Archive $archive
     * @return \Illuminate\Http\Response
     */
    public function store(ArchiveRequest $archiveRequest, Category $category, Archive $archive)
    {
        //
        $category->archives()->create($archiveRequest->all());
        return redirect('/admin/archives')->with('success', 'Archive created!');

    }

    /**
     * Display the specified resource.
     *
     * @param Archive $archive
     * @return Response
     */
    public function show(Archive $archive)
    {
        //
//        return $archive;
        return view('admin.archives.show', compact('archive'));
//        return $archive->denmarkEmigrations;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Archive $archive
     * @return Response
     */
    public function edit(Archive $archive)
    {
        // put html editor
        return view('admin.archives.edit', compact('archive'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ArchiveRequest $archiveRequest
     * @param Archive $archive
     * @return Response
     */
    public function update(ArchiveRequest $archiveRequest,  Archive $archive)
    {
        //
        $archive->update($archiveRequest->all());
        return redirect('/admin/archives')->with('success', 'Archive Updated!');
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
