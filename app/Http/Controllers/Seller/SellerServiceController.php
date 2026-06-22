<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SellerServiceController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $services = Service::with(['category', 'images'])
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(12);

        return view('seller.services.index', compact('services'))
            ->with('active', 'services');
    }

    public function create()
    {
        $categories = Category::all();
        return view('seller.services.create', compact('categories'))
            ->with('active', 'services');
    }

    public function store(StoreServiceRequest $request)
    {
        $data = $request->validated();
        unset($data['images']);
        $data['user_id'] = auth()->id();

        $service = Service::create($data);

        if ($request->hasFile('images')) {
            $this->saveServiceImages($service, $request->file('images'));
        }

        return redirect()->route('seller.services.index')->with('success', 'Service created');
    }

    public function edit(Service $service)
    {
        if ($service->user_id !== auth()->id()) {
            abort(403);
        }
        $categories = Category::all();
        return view('seller.services.edit', compact('service', 'categories'))
            ->with('active', 'services');
    }

    public function update(UpdateServiceRequest $request, Service $service)
    {
        if ($service->user_id !== auth()->id()) {
            abort(403);
        }

        $data = $request->validated();
        unset($data['images'], $data['remove_images']);
        $service->update($data);

        if ($request->filled('remove_images')) {
            $this->removeServiceImages($service, $request->input('remove_images'));
        }

        if ($request->hasFile('images')) {
            $existingCount = $service->images()->count();
            $removedCount = count($request->input('remove_images', []));
            $newImages = count($request->file('images'));

            if ($existingCount - $removedCount + $newImages > 5) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['images' => 'Maximum 5 images allowed']);
            }

            $this->saveServiceImages($service, $request->file('images'));
        }

        return redirect()->route('seller.services.index')->with('success', 'Service updated');
    }

    private function saveServiceImages(Service $service, array $files): void
    {
        $nextOrder = $service->images()->count();

        foreach ($files as $file) {
            $filename = now()->timestamp . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('services/' . $service->id, $filename, 'public');

            $service->images()->create([
                'path' => $path,
                'sort_order' => $nextOrder++,
            ]);
        }
    }

    private function removeServiceImages(Service $service, array $imageIds): void
    {
        $images = $service->images()->whereIn('id', $imageIds)->get();

        foreach ($images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        $service->images()->whereIn('id', $imageIds)->delete();
    }

    public function destroy(Service $service)
    {
        if ($service->user_id !== auth()->id()) {
            abort(403);
        }
        // Delete physical files for service images before deleting DB records
        foreach ($service->images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        $service->delete();
        return redirect()->route('seller.services.index')->with('success', 'Service deleted');
    }
}
