<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\ListingImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RealtorListingImageController extends Controller
{
    public function __construct()
    {
        //$this->authorizeResource(ListingImage::class, 'ListingImage');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response|\Inertia\Response|\Inertia\ResponseFactory
     */
    public function create(Listing $listing)
    {
        $this->authorize('createListingImages', $listing);

        $listing->load(['images']);

        return inertia('Realtor/ListingImage/Create',
        [
            'listing' => $listing,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function store(Listing $listing, Request $request)
    {
        $this->authorize('createListingImages', $listing);

        $request->validate([
            'images.*' => 'mimes:jpg,jpeg,png|max:1024',
        ], [
            'images.*.mimes' => 'Only jpeg, jpg, and png images are allowed.',
            'images.*.max'   => 'Sorry! Maximum allowed size for an image is 1MB.',
        ]);

        if (! $request->hasFile('images')) {
            return redirect()->route('realtor.listing.image.create',
                ['listing' => $listing->id]
            );
        }

        foreach ($request->file('images') as $file) {
            $path = $file->store('images', 'public');

            $listing->images()->save(new ListingImage([
                'filename' => $path,
            ]));
        }

        return redirect()->route('realtor.listing.image.create',
            ['listing' => $listing->id]
        )->with('success', 'Images uploaded successfully.');
    }

    public function destroy(Listing $listing, ListingImage $image)
    {
        $this->authorize('deleteListingImages', $listing);

        Storage::disk('public')->delete($image->filename);
        $image->delete();

        return redirect()->route('realtor.listing.image.create',
            ['listing' => $listing->id]
        )->with('success', 'Image deleted successfully.');
    }
}

