@php
    use App\Models\Portfolio\JobEmploymentType;
    use App\Models\Portfolio\JobLocationType;
    use App\Models\System\Country;
    use App\Models\System\Owner;
    use App\Models\System\State;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (!empty($owner) && !empty($admin) && $admin->root) {
        $breadcrumbs[] = [ 'name' => 'Admins',     'href' => route('admin.system.admin.index') ];
        $breadcrumbs[] = [ 'name' => $owner->name, 'href' => route('admin.system.admin.show', $owner) ];
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index', ['owner_id'=>$owner->id]) ];
        $breadcrumbs[] = [ 'name' => 'Jobs',       'href' => route('admin.portfolio.job.index', ['owner_id'=>$owner->id]) ];
        $breadcrumbs[] = [ 'name' => $job->name,   'href' => route('admin.portfolio.job.show', [$job, 'owner_id'=>$owner->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index') ];
        $breadcrumbs[] = [ 'name' => 'Jobs',       'href' => route('admin.portfolio.job.index') ];
        $breadcrumbs[] = [ 'name' => $job->name,   'href' => route('admin.portfolio.job.show', $job) ];
    }
    $breadcrumbs[] = [ 'name' => 'Edit' ];

    // set navigation buttons
    $buttons = [
        view('admin.components.nav-button-back', ['href' => referer('admin.portfolio.job.index')])->render(),
    ];
@endphp
@extends('admin.layouts.default', [
    'title'            => $pageTitle ?? 'Job: ' . $job->name,
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => $buttons,
    'errorMessages'    => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.portfolio.job.update', array_merge([$job], request()->all())) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.portfolio.job.index')
            ])

            @include('admin.components.form-text-horizontal', [
                'name'  => 'id',
                'value' => $job->id
            ])

            @if($admin->root)
                @include('admin.components.form-select-horizontal', [
                    'name'     => 'owner_id',
                    'label'    => 'owner',
                    'value'    => old('owner_id') ?? $job->owner_id,
                    'required' => true,
                    'list'     => new Owner()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                    'message'  => $message ?? '',
                ])
            @else
                @include('admin.components.form-hidden', [
                    'name'  => 'owner_id',
                    'value' => $job->owner_id
                ])
            @endif

            @include('admin.components.form-input-horizontal', [
                'name'      => 'company',
                'value'     => old('company') ?? $job->company,
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'role',
                'value'     => old('role') ?? $job->role,
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'featured',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('featured') ?? $job->featured,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'summary',
                'value'     => old('summary') ?? $job->summary,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @php
                $startMonth = view('admin.components.form-select', [
                    'name'      => 'start_month',
                    'label'     => '',
                    'value'     => old('start_month') ?? $job->start_month,
                    'list'      => months(true),
                    'message'   => $message ?? '',
                ]);
                $startYear = view('admin.components.form-input', [
                    'type'      => 'number',
                    'name'      => 'start_year',
                    'label'     => '',
                    'value'     => old('start_year') ?? $job->start_year,
                    'min'       => 1980,
                    'max'       => 2050,
                    'message'   => $message ?? '',
                ]);
            @endphp

            @include('admin.components.form-text-horizontal', [
                'name'  => 'start',
                'value' => '<div style="display: flex; gap: 0.4em; margin-left: -0.5em; margin-top: -0.5em;">'
                            . '<div>'
                                . $startMonth
                            . '</div><div>'
                                . $startYear
                            . '</div></div>',
                'raw'   => true
            ])

            @php
                $endMonth = view('admin.components.form-select', [
                    'name'      => 'end_month',
                    'label'     => '',
                    'value'     => old('end_month') ?? $job->end_month,
                    'list'      => months(true),
                    'message'   => $message ?? '',
                ]);
                $endYear = view('admin.components.form-input', [
                    'type'      => 'number',
                    'name'      => 'end_year',
                    'label'     => '',
                    'value'     => old('end_year') ?? $job->end_year,
                    'min'       => 1980,
                    'max'       => 2050,
                    'message'   => $message ?? '',
                ]);
            @endphp

            @include('admin.components.form-text-horizontal', [
                'name'  => 'end',
                'value' => '<div style="display: flex; gap: 0.4em; margin-left: -0.5em; margin-top: -0.5em;">'
                            . '<div>'
                                . $endMonth
                            . '</div><div>'
                                . $endYear
                            . '</div></div>',
                'raw'   => true
            ])

            @include('admin.components.form-select-horizontal', [
                'name'     => 'job_employment_type_id',
                'label'    => 'employment type',
                'value'    => old('job_employment_type_id') ?? $job->job_employment_type_id,
                'required' => true,
                'list'     => new JobEmploymentType()->listOptions([], 'id', 'name', true),
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'     => 'job_location_type_id',
                'label'    => 'location type',
                'value'    => old('job_location_type_id') ?? $job->job_location_type_id,
                'required' => true,
                'list'     => new JobLocationType()->listOptions([], 'id', 'name', true),
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-location-horizontal', [
                'street'     => old('street') ?? $job->street,
                'street2'    => old('street2') ?? $job->street2,
                'city'       => old('city') ?? $job->city,
                'state_id'   => old('state_id') ?? $job->state_id,
                'states'     => new State()->listOptions([], 'id', 'name', true),
                'zip'        => old('zip') ?? $job->zip,
                'country_id' => old('country_id') ?? $job->country_id,
                'countries'  => new Country()->listOptions([], 'id', 'name', true),
                'message'    => $message ?? '',
            ])

            @include('admin.components.form-coordinates-horizontal', [
                'latitude'  => old('latitude') ?? $job->latitude,
                'longitude' => old('longitude') ?? $job->longitude,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'notes',
                'value'   => old('notes') ?? $job->notes,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-link-horizontal', [
                'link' => old('link') ?? $job->link,
                'name' => old('link_name') ?? $job->link_name,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $job->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'        => 'disclaimer',
                'value'       => old('disclaimer') ?? $job->disclaimer,
                'maxlength'   => 500,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'src'     => old('image') ?? $job->image,
                'credit'  => old('image_credit') ?? $job->image_credit,
                'source'  => old('image_source') ?? $job->image_source,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-image-horizontal', [
                'name'      => 'thumbnail',
                'src'       => old('thumbnail') ?? $job->thumbnail,
                'credit'    => false,
                'source'    => false,
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-file-upload-horizontal', [
                'name'      => 'logo',
                'src'       => old('logo') ?? $job->logo,
                'maxlength' => 500,
                'credit'    => false,
                'source'    => false,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-file-upload-horizontal', [
                'name'      => 'logo_small',
                'src'       => old('logo_small') ?? $job->logo_small,
                'maxlength' => 500,
                'credit'    => false,
                'source'    => false,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-visibility-horizontal', [
                'public'      => old('public')   ?? $job->public,
                'readonly'    => old('readonly') ?? $job->readonly,
                'root'        => old('root')     ?? $job->root,
                'disabled'    => old('disabled') ?? $job->disabled,
                'demo'        => old('demo')     ?? $job->demo,
                'sequence'    => old('sequence') ?? $job->sequence,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.portfolio.job-task.index')
            ])

        </form>

    </div>

@endsection
