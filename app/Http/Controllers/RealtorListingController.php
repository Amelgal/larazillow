<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RealtorListingController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Listing::class, 'listing');
    }

    public function index(Request $request) {

        $filters = [
            'published' => $request->boolean('published'),
            'deleted' => $request->boolean('deleted'),
            ...$request->only([
                'by',
                'order'
            ]),
        ];

        return inertia('Realtor/Index', [
            'filters' => $filters,
            'listings' => Auth::user()
                              ->listings()
                              ->withCount('images')
                              ->withCount('offers')
                              ->filter($filters)
                              ->paginate(6)
                              ->withQueryString(),
            ]);
    }

    public function show(Listing $listing)
    {
        $offers = $listing->offers()->get();

        return inertia('Realtor/Show',
            [
                'listing' => $listing,
                'offers' => $offers->load('bidder'),
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response|\Inertia\Response|\Inertia\ResponseFactory
     */
    public function create()
    {
        return inertia('Realtor/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $listing = $request->user()->listings()->create(
            $request->validate([
                'beds' => 'required|integer|min:1|max:20',
                'baths'=> 'required|integer|min:1|max:20',
                'area'=> 'required|integer|min:50|max:1000',
                'city'=> 'required|string',
                'code'=> 'required|string',
                'street'=> 'required|string',
                'street_nr'=> 'required|string',
                'price'=> 'required|integer|min:1|max:10000000',
            ]),
        );

        //return $this->show( $listing );

        return redirect()->route('listing.show',
            ['listing' => $listing->id]
        )->with('success', 'Listing created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Listing  $listing
     *
     * @return \Illuminate\Http\Response|\Inertia\Response|\Inertia\ResponseFactory
     */
    public function edit(Listing $listing)
    {
        return inertia('Realtor/Edit',
            [
                'listing' => $listing
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Listing  $listing
     */
    public function update(Request $request, Listing $listing)
    {
        $listing->update(
            $request->validate([
                'beds' => 'required|integer|min:1|max:20',
                'baths'=> 'required|integer|min:1|max:20',
                'area'=> 'required|integer|min:50|max:1000',
                'city'=> 'required|string',
                'code'=> 'required|string',
                'street'=> 'required|string',
                'street_nr'=> 'required|string',
                'price'=> 'required|integer|min:1|max:10000000',
            ]),
        );

        //return $this->show( $listing );

        return redirect()->route('realtor.listing.index')
                         ->with('success', 'Listing updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Listing $listing
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function destroy(Listing $listing)
    {
        $listing->deleteOrFail();

        return redirect()
            ->back()
            ->with('success', 'Listing trashed successfully');
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param Listing $listing
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function restore(Listing $listing)
    {
        $listing->restore();

        return redirect()
            ->back()
            ->with('success', 'Listing restored successfully');
    }

    /**
     * Force Delete the specified resource from storage.
     *
     * @param Listing $listing
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function forceDelete(Listing $listing)
    {
        $this->authorize('forceDelete', $listing);

        foreach($listing->images as $image) {
            Storage::disk('public')->delete($image->filename);
            $image->delete();
        }

        $listing->forceDelete();

        return redirect()
            ->back()
            ->with('success', 'Listing destroyed successfully');
    }
}
