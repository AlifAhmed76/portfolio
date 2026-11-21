<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSkillRequest;
use App\Models\ActivityLog;
use App\Models\Skill;
use App\Models\SkillCategory;
use App\Services\CacheInvalidationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SkillController extends Controller
{
    public function index(): View
    {
        $categories = SkillCategory::with('skills')->orderBy('sort_order')->get();

        return view('admin.skills.index', compact('categories'));
    }

    public function storeCategory(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $category = SkillCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        ActivityLog::log('skill_category.create', ['name' => $category->name], $category);
        CacheInvalidationService::invalidateSkills();

        return back()->with('success', "Skill category '{$category->name}' created.");
    }

    public function destroyCategory(SkillCategory $category): RedirectResponse
    {
        $name = $category->name;
        $category->delete();

        ActivityLog::log('skill_category.delete', ['name' => $name]);
        CacheInvalidationService::invalidateSkills();

        return back()->with('success', "Skill category '{$name}' deleted.");
    }

    public function store(StoreSkillRequest $request): RedirectResponse
    {
        $skill = Skill::create($request->validated());

        ActivityLog::log('skill.create', ['name' => $skill->name], $skill);
        CacheInvalidationService::invalidateSkills();

        return back()->with('success', "Skill '{$skill->name}' added successfully.");
    }

    public function update(StoreSkillRequest $request, Skill $skill): RedirectResponse
    {
        $skill->update($request->validated());

        ActivityLog::log('skill.update', ['name' => $skill->name], $skill);
        CacheInvalidationService::invalidateSkills();

        return back()->with('success', "Skill '{$skill->name}' updated successfully.");
    }

    public function destroy(Skill $skill): RedirectResponse
    {
        $name = $skill->name;
        $skill->delete();

        ActivityLog::log('skill.delete', ['name' => $name]);
        CacheInvalidationService::invalidateSkills();

        return back()->with('success', "Skill '{$name}' deleted successfully.");
    }
}
