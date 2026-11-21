<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSocialLinkRequest;
use App\Http\Requests\Admin\UpdateContactRequest;
use App\Http\Requests\Admin\UpdateProfileRequest;
use App\Models\ActivityLog;
use App\Models\ContactDetail;
use App\Models\Media;
use App\Models\Profile;
use App\Models\SocialLink;
use App\Services\CacheInvalidationService;
use App\Services\WorkspaceResolver;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class IdentityController extends Controller
{
    public function index(): View
    {
        $workspace = WorkspaceResolver::resolve();
        $profile = Profile::firstOrCreate(
            ['workspace_id' => $workspace?->id],
            [
                'name' => 'Md. Alif Ahmed',
                'designation' => 'Web Developer | Technical Project Lead | E-commerce Solutions Specialist',
                'headline' => 'Building Digital Experiences. Engineering Business Solutions.',
            ]
        );

        $contact = ContactDetail::firstOrCreate(
            ['workspace_id' => $workspace?->id],
            [
                'email' => 'admin@alifahmed.com',
                'availability_status' => 'Available for Select Projects',
            ]
        );

        $socialLinks = SocialLink::orderBy('sort_order')->get();
        $images = Media::where('mime_type', 'like', 'image/%')->latest()->get();
        $documents = Media::where('mime_type', 'not like', 'image/%')->latest()->get();

        return view('admin.identity.index', compact('profile', 'contact', 'socialLinks', 'images', 'documents'));
    }

    public function updateProfile(UpdateProfileRequest $request): RedirectResponse
    {
        $workspace = WorkspaceResolver::resolve();
        $profile = Profile::firstOrNew(['workspace_id' => $workspace?->id]);

        $profile->fill($request->validated());
        $profile->save();

        ActivityLog::log('profile.update', ['name' => $profile->name], $profile);
        CacheInvalidationService::invalidateProfile();

        return redirect()->route('admin.identity.index')->with('success', 'Profile identity updated successfully.');
    }

    public function updateContact(UpdateContactRequest $request): RedirectResponse
    {
        $workspace = WorkspaceResolver::resolve();
        $contact = ContactDetail::firstOrNew(['workspace_id' => $workspace?->id]);

        $contact->fill($request->validated());
        $contact->save();

        ActivityLog::log('contact.update', ['email' => $contact->email], $contact);
        CacheInvalidationService::invalidateProfile();

        return redirect()->route('admin.identity.index')->with('success', 'Contact details updated successfully.');
    }

    public function storeSocialLink(StoreSocialLinkRequest $request): RedirectResponse
    {
        $link = SocialLink::create($request->validated());

        ActivityLog::log('social_link.create', ['platform' => $link->platform], $link);
        CacheInvalidationService::invalidateProfile();

        return redirect()->route('admin.identity.index')->with('success', 'Social link added successfully.');
    }

    public function updateSocialLink(StoreSocialLinkRequest $request, SocialLink $socialLink): RedirectResponse
    {
        $socialLink->update($request->validated());

        ActivityLog::log('social_link.update', ['platform' => $socialLink->platform], $socialLink);
        CacheInvalidationService::invalidateProfile();

        return redirect()->route('admin.identity.index')->with('success', 'Social link updated successfully.');
    }

    public function destroySocialLink(SocialLink $socialLink): RedirectResponse
    {
        $platform = $socialLink->platform;
        $socialLink->delete();

        ActivityLog::log('social_link.delete', ['platform' => $platform]);
        CacheInvalidationService::invalidateProfile();

        return redirect()->route('admin.identity.index')->with('success', 'Social link deleted successfully.');
    }
}
