@props([
    'name',
    'id' => null,
    'label' => 'Select Image',
    'value' => null,
    'selectedImage' => null,
    'images' => [],
    'helpText' => null,
])

@php
    $pickerId = $id ?? $name;
    $modalId = 'modal_picker_' . str_replace(['[', ']', '.'], '_', $pickerId);
    $currentVal = old($name, $value);
    $resolvedImage = $selectedImage;

    // If selectedImage wasn't explicitly passed, attempt to find in $images collection
    if (! $resolvedImage && $currentVal && count($images) > 0) {
        $resolvedImage = collect($images)->firstWhere('id', (int) $currentVal);
    }
@endphp

<div class="mb-3 image-picker-wrapper" id="wrapper_{{ $pickerId }}">
    <label class="form-label small text-secondary d-flex justify-content-between align-items-center">
        <span>{{ $label }}</span>
        @if ($helpText)
            <small class="text-secondary opacity-75">{{ $helpText }}</small>
        @endif
    </label>

    <!-- Hidden input holding actual media ID -->
    <input type="hidden" name="{{ $name }}" id="{{ $pickerId }}" value="{{ $currentVal }}">

    <!-- Preview Container -->
    <div class="p-3 border rounded-3 bg-dark-subtle border-secondary-subtle">
        <div id="{{ $pickerId }}_selected_box" class="{{ $resolvedImage ? '' : 'd-none' }}">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <img id="{{ $pickerId }}_preview_img" 
                         src="{{ $resolvedImage?->url ?? '' }}" 
                         alt="Preview" 
                         class="rounded border border-secondary shadow-sm object-fit-cover" 
                         style="width: 72px; height: 72px;">
                    <div>
                        <div id="{{ $pickerId }}_preview_name" class="fw-semibold text-body small text-truncate" style="max-width: 180px;">
                            {{ $resolvedImage?->original_name ?? 'Selected Image' }}
                        </div>
                        <div id="{{ $pickerId }}_preview_dim" class="text-secondary" style="font-size: 0.75rem;">
                            {{ $resolvedImage?->width ? ($resolvedImage->width . 'x' . $resolvedImage->height . ' px') : '' }}
                        </div>
                        <span class="badge bg-emerald-subtle text-emerald" style="font-size: 0.7rem;">Active Selection</span>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-sm btn-outline-light" data-bs-toggle="modal" data-bs-target="#{{ $modalId }}">
                        <i data-lucide="refresh-cw" style="width: 14px; height: 14px;" class="me-1"></i> Change
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="clearImagePicker('{{ $pickerId }}')">
                        <i data-lucide="trash-2" style="width: 14px; height: 14px;"></i>
                    </button>
                </div>
            </div>
        </div>

        <div id="{{ $pickerId }}_empty_box" class="text-center py-3 {{ $resolvedImage ? 'd-none' : '' }}">
            <div class="text-secondary mb-2">
                <i data-lucide="image-plus" style="width: 32px; height: 32px;" class="opacity-50"></i>
            </div>
            <p class="small text-secondary mb-2">No image currently selected</p>
            <button type="button" class="btn btn-sm btn-emerald" data-bs-toggle="modal" data-bs-target="#{{ $modalId }}">
                <i data-lucide="grid" style="width: 14px; height: 14px;" class="me-1"></i> Select from Media Library
            </button>
        </div>
    </div>

    <!-- Media Library Selection Modal -->
    <div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="{{ $modalId }}Label" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content admin-card">
                <div class="modal-header border-secondary-subtle">
                    <div>
                        <h5 class="modal-title h6 fw-bold mb-0" id="{{ $modalId }}Label">Select {{ $label }}</h5>
                        <small class="text-secondary">Click on any visual thumbnail card to assign it instantly.</small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <a href="{{ route('admin.media.index') }}" target="_blank" class="btn btn-xs btn-outline-emerald text-decoration-none py-1 px-2" style="font-size: 0.75rem;">
                            <i data-lucide="upload" style="width: 12px; height: 12px;" class="me-1"></i> Upload New
                        </a>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>

                <div class="modal-body p-3">
                    <!-- Search Filter inside Modal -->
                    <div class="mb-3">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-dark-subtle border-secondary-subtle"><i data-lucide="search" style="width: 14px; height: 14px;"></i></span>
                            <input type="text" class="form-control bg-dark-subtle border-secondary-subtle" placeholder="Search images by name..." onkeyup="filterMediaThumbnails(this, '{{ $modalId }}_grid')">
                        </div>
                    </div>

                    <div class="row g-3" id="{{ $modalId }}_grid">
                        @forelse ($images as $img)
                            <div class="col-6 col-sm-4 col-md-3 media-thumbnail-item" data-name="{{ strtolower($img->original_name) }}">
                                <div class="card h-100 p-2 text-center border-secondary-subtle bg-dark position-relative cursor-pointer media-select-card"
                                     style="cursor: pointer; transition: all 0.2s;"
                                     onclick="selectImageForPicker('{{ $pickerId }}', '{{ $img->id }}', '{{ addslashes($img->url) }}', '{{ addslashes($img->original_name) }}', '{{ $img->width ? ($img->width . 'x' . $img->height . ' px') : '' }}', '{{ $modalId }}')">
                                    <div class="position-relative overflow-hidden rounded mb-2" style="height: 90px; background: #1e293b;">
                                        <img src="{{ $img->url }}" alt="{{ $img->original_name }}" class="w-100 h-100 object-fit-cover">
                                    </div>
                                    <div class="small text-truncate text-body fw-medium" title="{{ $img->original_name }}" style="font-size: 0.78rem;">
                                        {{ $img->original_name }}
                                    </div>
                                    <div class="text-secondary" style="font-size: 0.70rem;">
                                        {{ $img->width ? ($img->width . 'x' . $img->height) : '' }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-5">
                                <i data-lucide="image" style="width: 40px; height: 40px;" class="text-secondary mb-2 opacity-50"></i>
                                <p class="text-secondary small mb-2">No image media files found in your library.</p>
                                <a href="{{ route('admin.media.index') }}" target="_blank" class="btn btn-sm btn-emerald">
                                    Go to Media Manager &amp; Upload
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="modal-footer border-secondary-subtle">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

@once
    @push('scripts')
        <script>
            function selectImageForPicker(pickerId, id, url, name, dim, modalId) {
                // Update hidden input value
                const input = document.getElementById(pickerId);
                if (input) input.value = id;

                // Update preview image
                const img = document.getElementById(pickerId + '_preview_img');
                if (img) img.src = url;

                // Update labels
                const nameEl = document.getElementById(pickerId + '_preview_name');
                if (nameEl) nameEl.textContent = name;

                const dimEl = document.getElementById(pickerId + '_preview_dim');
                if (dimEl) dimEl.textContent = dim;

                // Toggle visibility
                const selectedBox = document.getElementById(pickerId + '_selected_box');
                const emptyBox = document.getElementById(pickerId + '_empty_box');
                if (selectedBox) selectedBox.classList.remove('d-none');
                if (emptyBox) emptyBox.classList.add('d-none');

                // Close modal
                const modalEl = document.getElementById(modalId);
                if (modalEl) {
                    const modalInstance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                    modalInstance.hide();
                }

                if (window.lucide) {
                    lucide.createIcons();
                }
            }

            function clearImagePicker(pickerId) {
                const input = document.getElementById(pickerId);
                if (input) input.value = '';

                const selectedBox = document.getElementById(pickerId + '_selected_box');
                const emptyBox = document.getElementById(pickerId + '_empty_box');
                if (selectedBox) selectedBox.classList.add('d-none');
                if (emptyBox) emptyBox.classList.remove('d-none');
            }

            function filterMediaThumbnails(input, gridId) {
                const query = input.value.toLowerCase();
                const grid = document.getElementById(gridId);
                if (!grid) return;
                const items = grid.querySelectorAll('.media-thumbnail-item');
                items.forEach(item => {
                    const name = item.getAttribute('data-name') || '';
                    if (name.includes(query)) {
                        item.classList.remove('d-none');
                    } else {
                        item.classList.add('d-none');
                    }
                });
            }
        </script>
        <style>
            .media-select-card:hover {
                border-color: #10b981 !important;
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
            }
        </style>
    @endpush
@endonce
