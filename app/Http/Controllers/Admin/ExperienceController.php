<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreEducationRequest;
use App\Http\Requests\Admin\StoreExperienceRequest;
use App\Models\ActivityLog;
use App\Models\Education;
use App\Models\Experience;
use App\Services\CacheInvalidationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ExperienceController extends Controller
{
    public function index(): View
    {
        $experiences = Experience::orderBy('sort_order')->orderByDesc('start_date')->get();
        $educations = Education::orderBy('sort_order')->orderByDesc('start_date')->get();

        return view('admin.experience.index', compact('experiences', 'educations'));
    }

    public function store(StoreExperienceRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_current'] = $request->boolean('is_current');
        if ($data['is_current']) {
            $data['end_date'] = null;
        }

        $experience = Experience::create($data);

        ActivityLog::log('experience.create', ['company' => $experience->company], $experience);
        CacheInvalidationService::invalidateProfile();

        return back()->with('success', "Experience at '{$experience->company}' created successfully.");
    }

    public function update(StoreExperienceRequest $request, Experience $experience): RedirectResponse
    {
        $data = $request->validated();
        $data['is_current'] = $request->boolean('is_current');
        if ($data['is_current']) {
            $data['end_date'] = null;
        }

        $experience->update($data);

        ActivityLog::log('experience.update', ['company' => $experience->company], $experience);
        CacheInvalidationService::invalidateProfile();

        return back()->with('success', "Experience at '{$experience->company}' updated successfully.");
    }

    public function destroy(Experience $experience): RedirectResponse
    {
        $company = $experience->company;
        $experience->delete();

        ActivityLog::log('experience.delete', ['company' => $company]);
        CacheInvalidationService::invalidateProfile();

        return back()->with('success', "Experience at '{$company}' deleted successfully.");
    }
}
