<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListingController extends Controller
{
    public function __construct()
    {
        /*$this->middleware('auth')
            ->except('index', 'show');*/

        $this->authorizeResource(Listing::class, 'listing');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     *
     * @return \Illuminate\Http\Response|\Inertia\Response|\Inertia\ResponseFactory
     */
    public function index(Request $request)
    {
        $filters = $request->only([
            'beds',
            'baths',
            'areaMax',
            'areaMin',
            'priceMax',
            'priceMin',
        ]);

        return inertia('Listing/Index',
            [
                'filters'  => $filters,
                'listings' => Listing::latest()
                                     ->filter($filters)
                                     ->withoutSold()
                                     ->paginate(12)
                                     ->withQueryString(),
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Listing  $listing
     *
     * @return \Illuminate\Http\Response|\Inertia\Response|\Inertia\ResponseFactory
     */
    public function show(Listing $listing)
    {
        $listing->load(['images']);

        $offer = !Auth::user() ? null : $listing->offers()->byUser()->first();

        return inertia('Listing/Show',
            [
                'listing' => $listing,
                'offer' => $offer,
            ]);
    }
}
