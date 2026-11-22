@extends('layouts.admin')

@section('title', 'Identity & Contacts')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom border-secondary-subtle">
        <div>
            <h1 class="h3 fw-bold mb-1">Portfolio Identity & Contacts</h1>
            <p class="text-secondary small mb-0">Manage personal branding, bio, contact channels, and dynamic social platform links.</p>
        </div>
    </div>

    <!-- Nav Tabs -->
    <ul class="nav nav-pills mb-4" id="identityTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="profile-tab" data-bs-toggle="pill" data-bs-target="#profile-pane" type="button" role="tab">
                <i data-lucide="user" class="me-1" style="width: 16px; height: 16px;"></i> Profile & Branding
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="contact-tab" data-bs-toggle="pill" data-bs-target="#contact-pane" type="button" role="tab">
                <i data-lucide="phone" class="me-1" style="width: 16px; height: 16px;"></i> Contact Details
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="social-tab" data-bs-toggle="pill" data-bs-target="#social-pane" type="button" role="tab">
                <i data-lucide="share-2" class="me-1" style="width: 16px; height: 16px;"></i> Social Links
            </button>
        </li>
    </ul>

    <div class="tab-content" id="identityTabContent">
        <!-- 1. Profile Tab -->
        <div class="tab-pane fade show active" id="profile-pane" role="tabpanel">
            <div class="admin-card p-4">
                <form action="{{ route('admin.identity.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label small text-secondary">Full Name / Public Display Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $profile->name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="designation" class="form-label small text-secondary">
                                Professional Title <small class="text-warning">(Never include "Sr.")</small>
                            </label>
                            <input type="text" name="designation" id="designation" class="form-control" value="{{ old('designation', $profile->designation) }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="headline" class="form-label small text-secondary">Hero Positioning Headline</label>
                        <input type="text" name="headline" id="headline" class="form-control" value="{{ old('headline', $profile->headline) }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="bio" class="form-label small text-secondary">Professional Biography</label>
                        <textarea name="bio" id="bio" rows="5" class="form-control">{{ old('bio', $profile->bio) }}</textarea>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6 col-lg-4">
                            <x-admin.image-picker 
                                name="profile_image_id" 
                                label="Profile Portrait Photo" 
                                :value="$profile->profile_image_id" 
                                :selectedImage="$profile->profileImage"
                                :images="$images" 
                                helpText="Shown in hero & about" />
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <x-admin.image-picker 
                                name="avatar_image_id" 
                                label="Technical Avatar / 3D Hologram" 
                                :value="$profile->avatar_image_id" 
                                :selectedImage="$profile->avatar"
                                :images="$images" 
                                helpText="Shown in 3D prism orb" />
                        </div>
                        <div class="col-md-12 col-lg-4">
                            <label for="resume_media_id" class="form-label small text-secondary">Downloadable CV / Resume Document</label>
                            <div class="p-3 border rounded-3 bg-dark-subtle border-secondary-subtle">
                                <select name="resume_media_id" id="resume_media_id" class="form-select bg-dark border-secondary-subtle">
                                    <option value="">-- No CV Document Selected --</option>
                                    @foreach ($documents as $doc)
                                        <option value="{{ $doc->id }}" {{ $profile->resume_media_id == $doc->id ? 'selected' : '' }}>
                                            📄 {{ $doc->original_name }} ({{ round($doc->size / 1024) }} KB)
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-secondary d-block mt-2">Manage PDFs and DOCX in Media Manager.</small>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-emerald px-4">
                        <i data-lucide="save" class="me-1" style="width: 16px; height: 16px;"></i> Save Profile Changes
                    </button>
                </form>
            </div>
        </div>

        <!-- 2. Contact Details Tab -->
        <div class="tab-pane fade" id="contact-pane" role="tabpanel">
            <div class="admin-card p-4">
                <form action="{{ route('admin.identity.contact.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="contact_email" class="form-label small text-secondary">Public Inquiries Email</label>
                            <input type="email" name="email" id="contact_email" class="form-control" value="{{ old('email', $contact->email) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="location" class="form-label small text-secondary">Location</label>
                            <input type="text" name="location" id="location" class="form-control" value="{{ old('location', $contact->location) }}" placeholder="e.g. Dhaka, Bangladesh (Remote Worldwide)">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="phone" class="form-label small text-secondary">Phone Number</label>
                            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $contact->phone) }}" placeholder="+880 1XXX-XXXXXX">
                        </div>
                        <div class="col-md-6">
                            <label for="whatsapp" class="form-label small text-secondary">WhatsApp Direct Number/Link</label>
                            <input type="text" name="whatsapp" id="whatsapp" class="form-control" value="{{ old('whatsapp', $contact->whatsapp) }}" placeholder="+880 1XXX-XXXXXX">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="availability_status" class="form-label small text-secondary">Availability Status Label</label>
                        <input type="text" name="availability_status" id="availability_status" class="form-control" value="{{ old('availability_status', $contact->availability_status) }}" placeholder="Available for Select Projects & Leadership Roles">
                    </div>

                    <button type="submit" class="btn btn-emerald px-4">
                        <i data-lucide="save" class="me-1" style="width: 16px; height: 16px;"></i> Save Contact Details
                    </button>
                </form>
            </div>
        </div>

        <!-- 3. Social Links Tab -->
        <div class="tab-pane fade" id="social-pane" role="tabpanel">
            <div class="admin-card p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">Dynamic Social Platforms</h5>
                    <button class="btn btn-sm btn-emerald" type="button" data-bs-toggle="modal" data-bs-target="#addSocialModal">
                        <i data-lucide="plus" class="me-1" style="width: 14px; height: 14px;"></i> Add Platform Link
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 small">
                        <thead class="text-secondary">
                            <tr>
                                <th>Order</th>
                                <th>Platform</th>
                                <th>Label</th>
                                <th>URL</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($socialLinks as $link)
                                <tr>
                                    <td>{{ $link->sort_order }}</td>
                                    <td>
                                        <span class="badge bg-body-secondary text-body text-uppercase">{{ $link->platform }}</span>
                                    </td>
                                    <td class="fw-semibold">{{ $link->label }}</td>
                                    <td>
                                        <a href="{{ $link->url }}" target="_blank" class="text-truncate d-inline-block text-secondary" style="max-width: 250px;">
                                            {{ $link->url }}
                                        </a>
                                    </td>
                                    <td>
                                        @if ($link->is_enabled)
                                            <span class="badge bg-success-subtle text-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary">Disabled</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <form action="{{ route('admin.identity.social.destroy', $link) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this social link?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                <i data-lucide="trash-2" style="width: 14px; height: 14px;"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-secondary">No social platform links configured yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Social Link Modal -->
<div class="modal fade" id="addSocialModal" tabindex="-1" aria-labelledby="addSocialModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.identity.social.store') }}" method="POST" class="modal-content admin-card">
            @csrf
            <div class="modal-header border-secondary-subtle">
                <h5 class="modal-title h6 fw-bold" id="addSocialModalLabel">Add Social Platform Link</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="platform" class="form-label small text-secondary">Platform Key (e.g. github, linkedin, x, facebook)</label>
                    <input type="text" name="platform" id="platform" class="form-control" required placeholder="github">
                </div>
                <div class="mb-3">
                    <label for="label" class="form-label small text-secondary">Display Label</label>
                    <input type="text" name="label" id="label" class="form-control" required placeholder="GitHub">
                </div>
                <div class="mb-3">
                    <label for="url" class="form-label small text-secondary">Full Profile URL</label>
                    <input type="url" name="url" id="url" class="form-control" required placeholder="https://github.com/username">
                </div>
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label for="sort_order" class="form-label small text-secondary">Sort Order</label>
                        <input type="number" name="sort_order" id="sort_order" class="form-control" value="0">
                    </div>
                    <div class="col-6 d-flex align-items-center mt-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_enabled" id="is_enabled" value="1" checked>
                            <label class="form-check-label small" for="is_enabled">Enabled</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-secondary-subtle">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-sm btn-emerald">Add Platform</button>
            </div>
        </form>
    </div>
</div>
@endsection
