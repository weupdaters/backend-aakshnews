@extends('admin.layouts.app')

@section('content')
<div class="box-heading mb-4">
    <div class="box-title">
        <h3 class="mb-1">Publish News Article</h3>
        <p class="text-muted mb-0 font-sm">Create and publish a new news article with AI translation and verification features.</p>
    </div>
    <div class="box-breadcrumb">
        <div class="breadcrumbs">
            <ul>
                <li><a class="icon-home" href="/admin/dashboard">Dashboard</a></li>
                <li><a href="/admin/post">News Articles</a></li>
                <li><span>Publish News</span></li>
            </ul>
        </div>
    </div>
</div>

<div class="row">
    <form id="post-create-form" class="row">
        <!-- Left Column: News Editor -->
        <div class="col-xxl-9 col-xl-8 col-lg-8 mb-4">
            <div class="panel-white h-100">
                <div class="panel-body p-4">
                    <h5 class="color-brand-1 mb-4" style="font-weight: 700;">Article Details</h5>
                    
                    <!-- Title -->
                    <div class="mb-4">
                        <div class="input-group d-block">
                            <label class="font-sm color-text-mutted mb-2">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="post-title" class="form-control w-100" required placeholder="Enter article title...">
                        </div>
                    </div>

                    <!-- Category & Author Row -->
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <div class="input-group d-block">
                                <label class="font-sm color-text-mutted mb-2">Category <span class="text-danger">*</span></label>
                                <select name="category" id="post-category" class="form-control w-100" style="height: 46px;" required>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                                    @endforeach
                                    @if($categories->isEmpty())
                                        <option value="National">National</option>
                                        <option value="Sports">Sports</option>
                                        <option value="State">State</option>
                                        <option value="Politics">Politics</option>
                                        <option value="Business">Business</option>
                                        <option value="Technology">Technology</option>
                                        <option value="Entertainment">Entertainment</option>
                                        <option value="World">World</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group d-block">
                                <label class="font-sm color-text-mutted mb-2">Author Name</label>
                                <input type="text" name="author_name" id="post-author" class="form-control w-100" placeholder="Anonymous or enter your name">
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="mb-4">
                        <div class="input-group d-block">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="font-sm color-text-mutted mb-0">Description <span class="text-danger">*</span></label>
                                <button type="button" class="btn btn-sm btn-success text-white px-3 py-1 font-xs border-0" id="btn-ai-desc" style="background-color: var(--success-color); border-radius: 6px; font-weight: 700; height: auto;">
                                    <i data-feather="zap" class="me-1"></i> Generate Description
                                </button>
                            </div>
                            <textarea name="content" id="post-content" class="form-control w-100" rows="12" required placeholder="Write detailed content here..."></textarea>
                        </div>
                    </div>

                    <!-- Multilingual Translations -->
                    <div class="mt-4 border-top pt-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h5 class="color-brand-1 mb-1" style="font-weight: 700;">Multilingual Translations</h5>
                                <p class="text-muted font-xs mb-0">Translate or edit translations in English, Hindi, and Punjabi versions.</p>
                            </div>
                            <button type="button" class="btn btn-sm text-white px-3 py-2 font-xs border-0 d-inline-flex align-items-center" id="btn-auto-translate" style="background-color: #3b82f6; border-radius: 6px; font-weight: 700; height: auto;">
                                <i data-feather="globe" class="me-1" style="font-size: 14px;"></i> Auto-Translate
                            </button>
                        </div>
                        <div class="row">
                            <!-- English Translation -->
                            <div class="col-12 mb-3">
                                <div class="card p-3" style="border: 1px solid #cbd5e1; background-color: #f8fafc; border-radius: 8px;">
                                    <h6 class="mb-3 font-sm" style="font-weight: 700; color: #1e293b;"><img src="https://flagcdn.com/16x12/us.png" alt="US" class="me-1"> English Version</h6>
                                    <div class="mb-2">
                                        <label class="font-xs text-muted mb-1">English Title</label>
                                        <input type="text" name="title_en" id="post-title-en" class="form-control font-sm" placeholder="English title will appear here..." style="height: 38px; border-radius: 6px;">
                                    </div>
                                    <div>
                                        <label class="font-xs text-muted mb-1">English Content</label>
                                        <textarea name="content_en" id="post-content-en" class="form-control font-sm" rows="4" placeholder="English content will appear here..." style="border-radius: 6px;"></textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Hindi Translation -->
                            <div class="col-md-6 mb-3">
                                <div class="card p-3" style="border: 1px solid #cbd5e1; background-color: #f8fafc; border-radius: 8px;">
                                    <h6 class="mb-3 font-sm" style="font-weight: 700; color: #1e293b;"><img src="https://flagcdn.com/16x12/in.png" alt="India" class="me-1"> Hindi Version</h6>
                                    <div class="mb-2">
                                        <label class="font-xs text-muted mb-1">Hindi Title</label>
                                        <input type="text" name="title_hi" id="post-title-hi" class="form-control font-sm" placeholder="Hindi title will appear here..." style="height: 38px; border-radius: 6px;">
                                    </div>
                                    <div>
                                        <label class="font-xs text-muted mb-1">Hindi Content</label>
                                        <textarea name="content_hi" id="post-content-hi" class="form-control font-sm" rows="4" placeholder="Hindi content will appear here..." style="border-radius: 6px;"></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Punjabi Translation -->
                            <div class="col-md-6 mb-3">
                                <div class="card p-3" style="border: 1px solid #cbd5e1; background-color: #f8fafc; border-radius: 8px;">
                                    <h6 class="mb-3 font-sm" style="font-weight: 700; color: #1e293b;"><img src="https://flagcdn.com/16x12/in.png" alt="India" class="me-1"> Punjabi Version</h6>
                                    <div class="mb-2">
                                        <label class="font-xs text-muted mb-1">Punjabi Title</label>
                                        <input type="text" name="title_pb" id="post-title-pb" class="form-control font-sm" placeholder="Punjabi title will appear here..." style="height: 38px; border-radius: 6px;">
                                    </div>
                                    <div>
                                        <label class="font-xs text-muted mb-1">Punjabi Content</label>
                                        <textarea name="content_pb" id="post-content-pb" class="form-control font-sm" rows="4" placeholder="Punjabi content will appear here..." style="border-radius: 6px;"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Settings and Media -->
        <div class="col-xxl-3 col-xl-4 col-lg-4 mb-4">
            <div class="panel-white h-100 d-flex flex-column">
                <div class="panel-body p-4 d-flex flex-column flex-grow-1">
                    <h5 class="color-brand-1 mb-4" style="font-weight: 700;">Settings</h5>

                    <!-- Status -->
                    <div class="mb-4">
                        <div class="input-group d-block">
                            <label class="font-sm color-text-mutted mb-2">Status</label>
                            <select name="status" id="post-status" class="form-control w-100" style="height: 46px;">
                                <option value="published">Published</option>
                                <option value="pending">Pending</option>
                                <option value="rejected">Rejected</option>
                                <option value="hidden">Hidden</option>
                            </select>
                        </div>
                    </div>

                    <!-- Article Image Cover -->
                    <div class="mb-4">
                        <label class="font-sm color-text-mutted mb-2">Article Image *</label>
                        <div class="border rounded p-3 mb-2 text-center" style="background:#f8fafc; min-height: 140px; display:flex; align-items:center; justify-content:center; flex-direction:column; border-color:#cbd5e1 !important;">
                            <img id="image-preview" src="{{ asset('assets/imgs/page/dashboard/img3.png') }}" alt="News Image" style="max-height: 100px; max-width: 100%; object-fit: contain; border-radius: 4px;">
                            <span id="upload-status" class="font-xs text-muted mt-2 d-none">Uploading...</span>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-primary btn-sm flex-grow-1 text-white border-0" id="btn-ai-image" style="background-color: var(--primary-color); font-weight:700;">
                                <i data-feather="cpu"></i> AI Image
                            </button>
                            <label class="btn btn-outline-secondary btn-sm flex-grow-1 mb-0 d-flex align-items-center justify-content-center" style="cursor: pointer; font-weight:700;">
                                <i data-feather="upload" class="me-1"></i> Upload
                                <input type="file" id="post-image-file" accept="image/*" class="d-none">
                            </label>
                        </div>
                        <div class="input-group d-block mt-3">
                            <input type="text" name="image_url" id="post-image-url" class="form-control w-100 font-xs" placeholder="Or enter Image URL (https://...)">
                        </div>
                    </div>

                    <!-- Video URL -->
                    <div class="mb-4">
                        <div class="input-group d-block">
                            <label class="font-sm color-text-mutted mb-2">Video URL</label>
                            <input type="url" name="video_url" id="post-video-url" class="form-control w-100" placeholder="https://www.youtube.com/watch?v=...">
                        </div>
                    </div>

                    <!-- Duration & Views -->
                    <div class="row mb-4">
                        <div class="col-6">
                            <div class="input-group d-block">
                                <label class="font-sm color-text-mutted mb-2">Duration</label>
                                <input type="text" name="duration" id="post-duration" class="form-control w-100" placeholder="e.g. 02:30">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="input-group d-block">
                                <label class="font-sm color-text-mutted mb-2">Views</label>
                                <input type="number" name="views_count" id="post-views" class="form-control w-100" value="0">
                            </div>
                        </div>
                    </div>

                    <!-- Features -->
                    <div class="mb-4">
                        <label class="font-sm color-text-mutted mb-2 d-block">Features</label>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="is_hero" id="post-is-hero" style="width:18px; height:18px; margin-right:8px; border:1px solid #cbd5e1;">
                            <label class="form-check-label font-sm" for="post-is-hero" style="font-weight:600; padding-top:2px;">Hero Article?</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_middle_stack" id="post-is-middle-stack" style="width:18px; height:18px; margin-right:8px; border:1px solid #cbd5e1;">
                            <label class="form-check-label font-sm" for="post-is-middle-stack" style="font-weight:600; padding-top:2px;">Middle Stack?</label>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-auto pt-3 border-top d-flex gap-2">
                        <a href="/admin/post" class="submit-btn bg-secondary text-white text-decoration-none justify-content-center flex-grow-1" style="padding: 12px;">
                            Cancel
                        </a>
                        <button type="submit" class="submit-btn justify-content-center flex-grow-1" style="background-color: var(--primary-color); padding: 12px;">
                            <i data-feather="send"></i> Publish
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Setup CSRF token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // 1. AI Description Generation
        $('#btn-ai-desc').on('click', function() {
            var title = $('#post-title').val();
            if (!title) {
                alert('Please enter a title first to generate AI description.');
                return;
            }
            var $btn = $(this);
            var originalText = $btn.html();
            $btn.html('<i data-feather="loader" class="feather-spin"></i> Generating...').prop('disabled', true);
            
            $.post('/api/generate-description', { title: title })
             .done(function(res) {
                 if (res.success) {
                     $('#post-content').val(res.description);
                 } else {
                     alert('Error generating content: ' + res.message);
                 }
             })
             .fail(function() {
                 alert('Unable to contact server.');
             })
             .always(function() {
                 $btn.html(originalText).prop('disabled', false);
             });
        });

        // 2. AI Image Generation
        $('#btn-ai-image').on('click', function() {
            var title = $('#post-title').val();
            if (!title) {
                alert('Please enter a title first to generate AI image.');
                return;
            }
            var $btn = $(this);
            var originalText = $btn.html();
            $btn.html('<i data-feather="loader" class="feather-spin"></i> Generating...').prop('disabled', true);
            
            $.post('/api/generate-ai-image', { title: title })
             .done(function(res) {
                 if (res.success) {
                     $('#post-image-url').val(res.url);
                     $('#image-preview').attr('src', res.url);
                 } else {
                     alert('Error generating image: ' + res.message);
                 }
             })
             .fail(function() {
                 alert('Unable to contact server.');
             })
             .always(function() {
                 $btn.html(originalText).prop('disabled', false);
             });
        });

        // 3. File Upload Handler (News Article Image)
        $('#post-image-file').on('change', function() {
            var file = this.files[0];
            if (!file) return;

            var formData = new FormData();
            formData.append('image', file);

            var $inputLabel = $(this).parent();
            var $status = $('#upload-status');
            $status.removeClass('d-none');
            $inputLabel.addClass('disabled').css('pointer-events', 'none');

            $.ajax({
                url: '/api/admin/upload-image',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(res) {
                    if (res.success) {
                        $('#post-image-url').val(res.url);
                        $('#image-preview').attr('src', res.url);
                    } else {
                        alert('Upload error: ' + res.message);
                    }
                },
                error: function() {
                    alert('Failed to upload file.');
                },
                complete: function() {
                    $status.addClass('d-none');
                    $inputLabel.removeClass('disabled').css('pointer-events', 'auto');
                }
            });
        });

        // Image URL Manual Input Preview
        $('#post-image-url').on('input', function() {
            var val = $(this).val();
            if (val) {
                $('#image-preview').attr('src', val);
            } else {
                $('#image-preview').attr('src', '{{ asset('assets/imgs/page/dashboard/img3.png') }}');
            }
        });

        // 4. Form Submit
        $('#post-create-form').on('submit', function(e) {
            e.preventDefault();
            
            var payload = {
                title: $('#post-title').val(),
                category: $('#post-category').val(),
                author_name: $('#post-author').val(),
                video_url: $('#post-video-url').val(),
                image_url: $('#post-image-url').val(),
                duration: $('#post-duration').val(),
                views_count: $('#post-views').val(),
                status: $('#post-status').val(),
                is_hero: $('#post-is-hero').is(':checked') ? 1 : 0,
                is_middle_stack: $('#post-is-middle-stack').is(':checked') ? 1 : 0,
                is_admin_post: 1,
                content: $('#post-content').val()
            };

            $.post('/api/posts', payload)
             .done(function(res) {
                 if (res.success) {
                     alert('Article published successfully!');
                     window.location.href = '/admin/post';
                 } else {
                     alert('AI Review Notice: ' + res.message);
                     window.location.href = '/admin/post';
                 }
             })
             .fail(function(xhr) {
                 var msg = xhr.responseJSON ? xhr.responseJSON.message : 'Failed to save article.';
                 alert(msg);
             });
        });
    });
</script>
@endsection
