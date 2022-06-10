<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Models\ImageCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Nette\Utils\Image;

class ImageCollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $ImageFolders = ImageCollection::all();
        return $ImageFolders;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('dashboard.imagecollection.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Archive $archive)
    {
        //

        $archive->imageCollections()->create($request->all());
        return "the collection has been created";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ImageCollection $ImageCollection)
    {
        //

        $images = Storage::disk('s3')->allFiles('collections/1');

        return view('dashboard.imagecollection.view', compact('ImageCollection', 'images'));
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

    public function upload(Request $request, ImageCollection $ImageCollection)
    {

//        return $request->image->getClientOriginalName();

//        return $request->all();

        $folder = 'collections/'.$ImageCollection->id;
//
        try {
            foreach ($request->images as $image){
                $path = $image->storeAs(
                    $folder,
                    $image->getClientOriginalName(),
                    's3'
                );
            }

            return redirect(route('ImageCollections.show', $ImageCollection));

        } catch (\Exception $e) {

            return $e->getMessage();
        }



    }
}
