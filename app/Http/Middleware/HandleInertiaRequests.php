<?php

namespace App\Http\Middleware;

use App\Models\Contact;
use App\Models\Listing;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            //
            'auth' => Auth::user() ? [
                'user' => [
                    'id' => Auth::user()->id,
                    'firstname' => Auth::user()->firstname,
                    'email' => Auth::user()->email,
                    'lastname' => Auth::user()->lastname,
                    'address' => Auth::user()->address,
                    'phone_number' => Auth::user()->phone_number,
                    'phone_number_verified' => Auth::user()->phone_number_verified,
                    'profile_pic' => Auth::user()->profile_pic,
                    'role' => Auth::user()->role
                ]
            ] : null,

            'activity_summary' => [
                'reported_guests' => Report::count(),
                'listing_requests' => Listing::where('status', 'For approval')->count(),
                'contact_us_subs' => Contact::count()
            ]
        ]);
    }
}
