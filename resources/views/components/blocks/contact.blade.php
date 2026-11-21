@props(['settings' => []])
@php
    $title = $settings['title'] ?? 'Get In Touch';
    $subtitle = $settings['subtitle'] ?? 'Available for Technical Projects & Leadership';
    $formEnabled = (bool) ($settings['form_enabled'] ?? true);
    $showSocials = (bool) ($settings['show_socials'] ?? true);
    
    $profile = \App\Models\Profile::first();
    $contact = \App\Models\ContactDetail::first();
    $socials = $showSocials ? \App\Models\SocialLink::active()->orderBy('sort_order')->get() : collect();
@endphp

<section class="block-contact py-5" id="contact">
    <div class="container">
        <div class="text-center mb-5">
            <span class="text-uppercase text-success small fw-bold tracking-wider">{{ $subtitle }}</span>
            <h2 class="h1 fw-bold mt-1">{{ $title }}</h2>
        </div>
        <div class="row g-5 justify-content-center">
            <div class="col-lg-5">
                <div class="card p-4 p-md-5 border-0 rounded-4 shadow-sm h-100" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08) !important;">
                    <h3 class="h4 fw-bold mb-4">Direct Contact</h3>
                    @if ($contact && $contact->email_primary)
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <i data-lucide="mail" class="text-success"></i>
                            <div>
                                <small class="text-secondary d-block">Email</small>
                                <a href="mailto:{{ $contact->email_primary }}" class="fw-semibold text-decoration-none text-light">{{ $contact->email_primary }}</a>
                            </div>
                        </div>
                    @endif
                    @if ($contact && $contact->location_city)
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <i data-lucide="map-pin" class="text-success"></i>
                            <div>
                                <small class="text-secondary d-block">Location</small>
                                <span class="fw-semibold text-light">{{ $contact->location_city }}, {{ $contact->location_country }}</span>
                            </div>
                        </div>
                    @endif
                    @if ($socials->isNotEmpty())
                        <div class="border-top pt-4 mt-4" style="border-color: rgba(255,255,255,0.08) !important;">
                            <h6 class="text-uppercase text-secondary small fw-bold mb-3">Connected Networks</h6>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach ($socials as $social)
                                    <a href="{{ $social->url }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-secondary px-3">
                                        {{ $social->platform }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            @if ($formEnabled)
                <div class="col-lg-6">
                    <div class="card p-4 p-md-5 border-0 rounded-4 shadow-sm" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08) !important;">
                        <h3 class="h4 fw-bold mb-4">Send a Message</h3>
                        <form action="{{ route('home') }}#contact" method="POST">
                            @csrf
                            <input type="text" name="hp_website" style="display:none !important;" tabindex="-1" autocomplete="off">
                            <div class="mb-3">
                                <label class="form-label small fw-semibold text-secondary">Your Name</label>
                                <input type="text" name="name" class="form-control bg-transparent text-light border-secondary" required placeholder="John Doe">
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-semibold text-secondary">Your Email</label>
                                <input type="email" name="email" class="form-control bg-transparent text-light border-secondary" required placeholder="john@example.com">
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-semibold text-secondary">Subject</label>
                                <input type="text" name="subject" class="form-control bg-transparent text-light border-secondary" placeholder="Project Inquiry">
                            </div>
                            <div class="mb-4">
                                <label class="form-label small fw-semibold text-secondary">Message</label>
                                <textarea name="message" rows="4" class="form-control bg-transparent text-light border-secondary" required placeholder="Tell me about your project..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-success w-100 py-2 fw-semibold">
                                Submit Message
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
