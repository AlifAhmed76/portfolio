<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreServiceRequest;
use App\Models\ActivityLog;
use App\Models\Service;
use App\Services\CacheInvalidationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        $services = Service::orderBy('sort_order')->get();

        return view('admin.services.index', compact('services'));
    }

    public function store(StoreServiceRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_enabled'] = $request->boolean('is_enabled', true);

        $service = Service::create($data);

        ActivityLog::log('service.create', ['title' => $service->title], $service);
        CacheInvalidationService::invalidateServices();

        return back()->with('success', "Service '{$service->title}' created successfully.");
    }

    public function update(StoreServiceRequest $request, Service $service): RedirectResponse
    {
        $data = $request->validated();
        $data['is_enabled'] = $request->boolean('is_enabled', true);

        $service->update($data);

        ActivityLog::log('service.update', ['title' => $service->title], $service);
        CacheInvalidationService::invalidateServices();

        return back()->with('success', "Service '{$service->title}' updated successfully.");
    }

    public function destroy(Service $service): RedirectResponse
    {
        $title = $service->title;
        $service->delete();

        ActivityLog::log('service.delete', ['title' => $title]);
        CacheInvalidationService::invalidateServices();

        return back()->with('success', "Service '{$title}' deleted successfully.");
    }
}
