<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Response;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     *
     * @return \Illuminate\Http\Response|\Inertia\Response|\Inertia\ResponseFactory
     */
    public function index(Request $request): Response
    {
        return inertia('Notification/Index',
            [
                'notifications' => $request->user()->notifications()->paginate(12)
            ]);
    }
}
