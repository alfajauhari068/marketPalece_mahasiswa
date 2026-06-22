<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function create(Service $service)
    {
        $service->load(['user', 'category', 'images']);

        if ($service->status !== 'live') {
            abort(404);
        }

        return view('klien.checkout.create', compact('service'));
    }
}
