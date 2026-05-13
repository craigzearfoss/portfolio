@php
    use App\Models\Career\Resume;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $resume      = $resume ?? null;

    $title    = 'Edit ' . getResourcePageTitle($resume);
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',                                            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard',                                 'href' => route('admin.dashboard') ],
    ];
    if ($isRootAdmin) {
        $breadcrumbs[] = [ 'name' => 'Admins',                         'href' => route('admin.system.admin.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Career',                             'href' => route('admin.career.index') ];
    $breadcrumbs[] = [ 'name' => 'Resumes',                            'href' => route('admin.career.resume.index') ];
    $breadcrumbs[] = [ 'name' => getResourcePageTitle($resume, false), 'href' => route('admin.career.resume.show', $resume) ];
    $breadcrumbs[] = [ 'name' => 'Edit' ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', [ 'href' => referer('admin.career.resume.index') ])->render(),
    ];

    $fileExtension = !empty($coverLetter->filepath)
        ? Illuminate\Support\Facades\File::extension($coverLetter->filepath)
        : '';
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.career.resume.update', array_merge([$resume], request()->all())) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.career.resume.index')
            ])

            @include('admin.components.form-text-horizontal', [
                'name'  => 'id',
                'value' => $resume->id,
                'hide'  => !$isRootAdmin,
            ])

            <?php /* note that you CANNOT change the owner of a resume */ ?>
            @include('admin.components.form-hidden', [
                'name'  => 'owner_id',
                'value' => $resume->owner_id
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? $resume->name,
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'active',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('active') ?? $resume->active,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'primary',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('primary') ?? $resume->primary,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'      => 'date',
                'name'      => 'resume_date',
                'label'     => 'date',
                'value'     => old('resume_date') ?? $resume->resume_date,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'content',
                'value'   => old('content') ?? $resume->content,
                'message' => $message ?? '',
            ])

            <div class="field is-horizontal">
                <div class="field-label">
                    <strong>PDF file</strong>:
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control ">

                            @if (!empty($resume->pdf_filepath))
                                {{ substr(strrchr($resume->pdf_filepath, DIRECTORY_SEPARATOR), 1) }}
                                @include('admin.components.download-links', [
                                    'name'     => 'image',
                                    'href'     => imageUrl($resume->pdf_filepath),
                                    'filename' => Str::slug(str_replace('Resume: ', '', getResourcePageTitle($resume)))
                                                      . '.' . substr(strrchr($resume->pdf_filepath, '.'), 1),
                                    'download' => true,
                                    'external' => true,
                                ])
                            @else
                                <i>none (Add via the show page.)</i>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="field is-horizontal">
                <div class="field-label">
                    <strong>MS Word file</strong>:
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control ">
                            @if (!empty($resume->doc_filepath))
                                {{ substr(strrchr($resume->doc_filepath, DIRECTORY_SEPARATOR), 1) }}
                                @include('admin.components.download-links', [
                                    'name'     => 'image',
                                    'href'     => imageUrl($resume->doc_filepath),
                                    'filename' => Str::slug(str_replace('Resume: ', '', getResourcePageTitle($resume)))
                                                      . '.' . substr(strrchr($resume->pdf_filepath, '.'), 1),
                                    'download' => true,
                                    'external' => false,
                                ])
                            @else
                                <i>none (Add via the show page.)</i>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="field is-horizontal">
                <div class="field-label">
                    <strong>other file</strong>:
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control ">

                            @if (!empty($resume->other_filepath))
                                {{ substr(strrchr($resume->other_filepath, DIRECTORY_SEPARATOR), 1) }}
                                @include('admin.components.download-links', [
                                    'name'     => 'image',
                                    'href'     => imageUrl($resume->other_filepath),
                                    'filename' => Str::slug(str_replace('Resume: ', '', getResourcePageTitle($resume)))
                                                      . '.' . substr(strrchr($resume->other_filepath, '.'), 1),
                                    'download' => true,
                                    'external' => true,
                                ])
                            @else
                                <i>none (Add via the show page.)</i>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @include('admin.components.form-link-horizontal', [
                'link' => old('link') ?? $resume->link,
                'name' => old('link_name') ?? $resume->link_name,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $resume->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'        => 'disclaimer',
                'value'       => old('disclaimer') ?? $resume->disclaimer,
                'maxlength'   => 500,
                'message'     => $message ?? '',
            ])

            @include('admin.components.show-row-images', [
                'resource' => $resume,
                'upload'   => false,
                'download' => true,
                'external' => true,
                'editPage' => true,
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'notes',
                'value'   => old('notes') ?? $resume->notes,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-visibility-horizontal', [
                'is_public'   => old('is_public')   ?? $resume->is_public,
                'is_readonly' => old('is_readonly') ?? $resume->is_readonly,
                'is_root'     => old('is_root')     ?? $resume->root,
                'is_disabled' => old('is_disabled') ?? $resume->is_disabled,
                'is_demo'     => old('is_demo')     ?? $resume->is_demo,
                'sequence'    => old('sequence')    ?? $resume->sequence,
                'message'     => $message           ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.career.resume.index')
            ])

        </form>

    </div>

@endsection
