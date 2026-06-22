<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function show(Service $service)
    {
        $service->load(['user', 'category', 'images']);

        if ($service->status !== 'live') {
            abort(404);
        }

        return view('klien.services.show', compact('service'));
    }
}
