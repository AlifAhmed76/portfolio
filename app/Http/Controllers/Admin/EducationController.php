<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreEducationRequest;
use App\Models\ActivityLog;
use App\Models\Education;
use App\Services\CacheInvalidationService;
use Illuminate\Http\RedirectResponse;

class EducationController extends Controller
{
    public function store(StoreEducationRequest $request): RedirectResponse
    {
        $education = Education::create($request->validated());

        ActivityLog::log('education.create', ['institution' => $education->institution], $education);
        CacheInvalidationService::invalidateProfile();

        return back()->with('success', "Education at '{$education->institution}' created successfully.");
    }

    public function update(StoreEducationRequest $request, Education $education): RedirectResponse
    {
        $education->update($request->validated());

        ActivityLog::log('education.update', ['institution' => $education->institution], $education);
        CacheInvalidationService::invalidateProfile();

        return back()->with('success', "Education at '{$education->institution}' updated successfully.");
    }

    public function destroy(Education $education): RedirectResponse
    {
        $inst = $education->institution;
        $education->delete();

        ActivityLog::log('education.delete', ['institution' => $inst]);
        CacheInvalidationService::invalidateProfile();

        return back()->with('success', "Education at '{$inst}' deleted successfully.");
    }
}
