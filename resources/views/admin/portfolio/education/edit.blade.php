@php
    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (!empty($owner) && !empty($admin) && $admin->root) {
        $breadcrumbs[] = [ 'name' => 'Admins',         'href' => route('admin.system.admin.index') ];
        $breadcrumbs[] = [ 'name' => $owner->name,     'href' => route('admin.system.admin.show', $owner) ];
        $breadcrumbs[] = [ 'name' => 'Portfolio',      'href' => route('admin.portfolio.index', ['owner_id'=>$owner->id]) ];
        $breadcrumbs[] = [ 'name' => 'Education',      'href' => route('admin.portfolio.education.index', ['owner_id'=>$owner->id]) ];
        $breadcrumbs[] = [ 'name' => $education->name, 'href' => route('admin.portfolio.education.show', [$education->id, 'owner_id'=>$owner->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Portfolio',      'href' => route('admin.portfolio.index') ];
        $breadcrumbs[] = [ 'name' => 'Education',      'href' => route('admin.portfolio.education.index') ];
        $breadcrumbs[] = [ 'name' => $education->name, 'href' => route('admin.portfolio.education.show', $education->id) ];
    }
    $breadcrumbs[] = [ 'name' => 'Edit' ];

    // set navigation buttons
    $buttons = [
        view('admin.components.nav-button-back', ['href' => referer('admin.portfolio.education.index')])->render(),
    ];
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Education: ' . $education->degreeType->name . ' ' . $education->major,
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => $buttons,
    'errorMessages'    => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.portfolio.education.update', $education->id) }}"
              method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.portfolio.education.index')
            ])

            @include('admin.components.form-text-horizontal', [
                'name'  => 'id',
                'value' => $education->id
            ])

            @if($admin->root)
                @include('admin.components.form-select-horizontal', [
                    'name'     => 'owner_id',
                    'label'    => 'owner',
                    'value'    => old('owner_id') ?? $education->owner_id,
                    'required' => true,
                    'list'     => \App\Models\System\Owner::listOptions([], 'id', 'username', true, false, ['username', 'asc']),
                    'message'  => $message ?? '',
                ])
            @else
                @include('admin.components.form-hidden', [
                    'name'  => 'owner_id',
                    'value' => $education->owner_id
                ])
            @endif

            @include('admin.components.form-select-horizontal', [
                'name'     => 'degree_type_id',
                'label'    => 'degree type',
                'value'    => old('degree_type_id') ?? $education->degree_type_id,
                'required' => true,
                'list'     => \App\Models\Portfolio\DegreeType::listOptions([], 'id', 'name', true, false, ['name', 'asc']),
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'major',
                'value'     => old('major') ?? $education->major,
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'minor',
                'value'     => old('minor') ?? $education->minor,
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'      => 'school_id',
                'label'     => 'school',
                'value'     => old('school_id') ?? $education->school_id,
                'list'      => \App\Models\Portfolio\School::listOptions([], 'id', 'name', true),
                'required'  => true,
                'message'   => $message ?? '',
            ])

            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label class="label">enrollment date</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control">

                            @include('admin.components.form-select', [
                                'name'      => 'enrollment_month',
                                'label'     => '',
                                'value'     => old('enrollment_month') ?? $education->enrollment_month,
                                'list'      => months(true),
                                'message'   => $message ?? '',
                            ])

                            @include('admin.components.form-input', [
                                'type'      => 'number',
                                'name'      => 'enrollment_year',
                                'label'     => '',
                                'value'     => old('enrollment_year') ?? $education->enrollment_year,
                                'min'       => 1980,
                                'max'       => date("Y"),
                                'message'   => $message ?? '',
                            ])

                        </div>
                    </div>
                </div>
            </div>

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'graduated',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('graduated') ?? $education->graduated,
                'message'         => $message ?? '',
            ])

            <div class="field is-horizontal">
                <div class="field-label is-normal">
                    <label class="label">enrollment date</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <div class="control">

                            @include('admin.components.form-select', [
                                'name'      => 'graduation_month',
                                'label'     => '',
                                'value'     => old('graduation_month') ?? $education->graduation_month,
                                'list'      => months(true),
                                'message'   => $message ?? '',
                            ])

                            @include('admin.components.form-input', [
                                'type'      => 'number',
                                'name'      => 'graduation_year',
                                'label'     => '',
                                'value'     => old('graduation_year') ?? $education->graduation_year,
                                'min'       => 1980,
                                'max'       => date("Y"),
                                'message'   => $message ?? '',
                            ])

                        </div>
                    </div>
                </div>
            </div>

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'currently_enrolled',
                'label'           => 'currently enrolled',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('currently_enrolled') ?? $education->currently_enrolled,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'summary',
                'value'     => old('summary') ?? $education->summary,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'notes',
                'value'   => old('notes') ?? $education->notes,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-link-horizontal', [
                'link' => old('link') ?? $education->link,
                'name' => old('link_name') ?? $education->link_name,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $education->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'        => 'disclaimer',
                'value'       => old('disclaimer') ?? $education->disclaimer,
                'maxlength'   => 500,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'image'   => old('image') ?? $education->image,
                'credit'  => old('image_credit') ?? $education->image_credit,
                'source'  => old('image_source') ?? $education->image_source,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-file-upload-horizontal', [
                'name'      => 'thumbnail',
                'value'     => old('thumbnail') ?? $education->thumbnail,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-settings-horizontal', [
                'public'   => old('public') ?? $education->public,
                'readonly' => old('readonly') ?? $education->readonly,
                'root'     => old('root') ?? $education->root,
                'disabled' => old('disabled') ?? $education->disabled,
                'demo'     => old('demo') ?? $education->demo,
                'sequence' => old('sequence') ?? $education->sequence,
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.portfolio.education.index')
            ])

        </form>

    </div>

@endsection
