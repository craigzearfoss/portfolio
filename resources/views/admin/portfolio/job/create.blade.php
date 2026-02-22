@php
    use App\Models\Portfolio\JobEmploymentType;
    use App\Models\Portfolio\JobLocationType;
    use App\Models\System\Country;
    use App\Models\System\Owner;
    use App\Models\System\State;

    $title    = $pageTitle ?? 'Add New Job';
    $subtitle = $title;

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
    } else {
        $breadcrumbs[] = [ 'name' => 'Portfolio',  'href' => route('admin.portfolio.index') ];
        $breadcrumbs[] = [ 'name' => 'Jobs',       'href' => route('admin.portfolio.job.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Add' ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', ['href' => referer('admin.portfolio.job.index')])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.portfolio.job.store', request()->all()) }}" method="POST">
            @csrf

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.portfolio.job.index')
            ])

            @if($admin->root)
                @include('admin.components.form-select-horizontal', [
                    'name'     => 'owner_id',
                    'label'    => 'owner',
                    'value'    => old('owner_id') ?? '',
                    'required' => true,
                    'list'     => new Owner()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                    'message'  => $message ?? '',
                ])
            @else
                @include('admin.components.form-hidden', [
                    'name'  => 'owner_id',
                    'value' => Auth::guard('admin')->user()->id
                ])
            @endif

            @include('admin.components.form-input-horizontal', [
                'name'      => 'company',
                'value'     => old('company') ?? '',
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'role',
                'value'     => old('role') ?? '',
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'featured',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('featured') ?? 1,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'summary',
                'value'     => old('name') ?? '',
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @php
                $startMonth = view('admin.components.form-select', [
                    'name'      => 'start_month',
                    'label'     => '',
                    'value'     => old('start_month') ?? '',
                    'list'      => months(true),
                    'message'   => $message ?? '',
                ]);
                $startYear = view('admin.components.form-input', [
                    'type'      => 'number',
                    'name'      => 'start_year',
                    'label'     => '',
                    'value'     => old('start_year') ?? '',
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
                    'value'     => old('end_month') ?? '',
                    'list'      => months(true),
                    'message'   => $message ?? '',
                ]);
                $endYear = view('admin.components.form-input', [
                    'type'      => 'number',
                    'name'      => 'end_year',
                    'label'     => '',
                    'value'     => old('end_year') ?? '',
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
                'value'    => old('job_employment_type_id') ?? '',
                'required' => true,
                'list'     => new JobEmploymentType()->listOptions([], 'id', 'name', true),
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'     => 'job_location_type_id',
                'label'    => 'location type',
                'value'    => old('job_location_type_id') ?? '',
                'required' => true,
                'list'     => new JobLocationType()->listOptions([], 'id', 'name', true),
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-location-horizontal', [
                'street'     => old('street') ?? '',
                'street2'    => old('street2') ?? '',
                'city'       => old('city') ?? '',
                'state_id'   => old('state_id') ?? '',
                'states'     => new State()->listOptions([], 'id', 'name', true),
                'zip'        => old('zip') ?? '',
                'country_id' => old('country_id') ?? '',
                'countries'  => new Country()->listOptions([], 'id', 'name', true),
                'message'    => $message ?? '',
            ])

            @include('admin.components.form-coordinates-horizontal', [
                'latitude'  => old('latitude') ?? '',
                'longitude' => old('longitude') ?? '',
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'notes',
                'value'   => old('notes') ?? '',
                'message' => $message ?? '',
            ])

            @include('admin.components.form-link-horizontal', [
                'link' => old('link') ?? '',
                'name' => old('link_name') ?? '',
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? '',
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'        => 'disclaimer',
                'value'       => old('disclaimer') ?? '',
                'maxlength'   => 500,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-file-upload-horizontal', [
                'name'      => 'logo',
                'src'       => old('logo') ?? '',
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-file-upload-horizontal', [
                'name'      => 'logo_small',
                'src'       => old('logo_small') ?? '',
                'maxlength' => 500,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-visibility-horizontal', [
                'public'      => old('public')   ?? 0,
                'readonly'    => old('readonly') ?? 0,
                'root'        => old('root')     ?? 0,
                'disabled'    => old('disabled') ?? 0,
                'demo'        => old('demo')     ?? 0,
                'sequence'    => old('sequence') ?? 0,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Add Job',
                'cancel_url' => referer('admin.portfolio.job.index')
            ])

        </form>

    </div>

@endsection
