@extends('guest.layouts.default', [
    'title'         => $title ?? 'Education: ' . $education->degreeType->name . ' ' . $education->major,
    'breadcrumbs'   => [
        [ 'name' => 'Home',           'href' => route('system.index') ],
        [ 'name' => 'Users',          'href' => route('guest.admin.index') ],
        [ 'name' => $admin->name,     'href' => route('guest.admin.show', $admin) ],
        [ 'name' => 'Portfolio',      'href' => route('guest.admin.portfolio.show', $education->owner) ],
        [ 'name' => 'Education',      'href' => route('guest.admin.portfolio.education.index', $education->owner) ],
        [ 'name' => $education->degreeType->name . ' ' . $education->major ],
    ],
    'buttons'       => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('guest.admin.portfolio.education.index', $education->owner) ],
    ],
    'errorMessages' => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => null,
])

@section('content')

    @include('guest.components.disclaimer', [ 'value' => $education->disclaimer ?? null ])

    <div class="show-container card p-4">

        @if(!empty($education->degreeType))
            @include('guest.components.show-row', [
                'name'  => 'degree type',
                'value' => $education->degreeType->name
            ])
        @endif

        @if(!empty($education->major))
            @include('guest.components.show-row', [
                'name'  => 'major',
                'value' => $education->major
            ])
        @endif

        @if(!empty($education->minor))
            @include('guest.components.show-row', [
                'name'  => 'minor',
                'value' => $education->minor
            ])
        @endif

        @if(!empty($education->school))
            @include('guest.components.show-row', [
                'name'  => 'school',
                'value' => $education->school->name ?? ''
            ])
        @endif

        @if(!empty($education->enrollment_month) || !empty($education->enrollment_year))
            @include('guest.components.show-row', [
                'name'  => 'enrollment',
                'value' => (!empty($education->enrollment_month) ? date('F', mktime(0, 0, 0, $education->enrollment_month, 10)) : '') . ' ' . $education->enrollment_year
            ])
        @endif

        @include('guest.components.show-row-checkbox', [
            'name'    => 'graduated',
            'checked' => $education->graduated
        ])

        @if(!empty($education->graduation_month) || !empty($education->graduation_year))
            @include('guest.components.show-row', [
                'name'  => 'graduation',
                'value' => (!empty($education->graduation_month) ? date('F', mktime(0, 0, 0, $education->graduation_month, 10)) : '') . ' ' . $education->graduation_year
            ])
        @endif

        @if(!empty($education->currently_enrolled))
            @include('guest.components.show-row-checkbox', [
                'name'    => 'currently enrolled',
                'checked' => $education->currently_enrolled
            ])
        @endif

        @if(!empty($education->summary))
            @include('guest.components.show-row', [
                'name'  => 'summary',
                'value' => $education->summary
            ])
        @endif

        @if(!empty($education->link))
            @include('guest.components.show-row-link', [
                'name'   => $education->link_name ?? 'link',
                'href'   => $education->link,
                'target' => '_blank'
            ])
        @endif

        @if(!empty($education->description))
            @include('guest.components.show-row', [
                'name'  => 'description',
                'value' => nl2br($education->description ?? '')
            ])
        @endif

        @if(!empty($education->image))
            @include('guest.components.show-row-image-credited', [
                'name'         => 'image',
                'src'          => $education->image,
                'alt'          => $education->name,
                'width'        => '300px',
                'download'     => true,
                'external'     => true,
                'filename'     => getFileSlug($education->name, $education->image),
                'image_credit' => $education->image_credit,
                'image_source' => $education->image_source,
            ])
        @endif

        @if(!empty($education->thumbnail))
            @include('guest.components.show-row-image', [
                'name'     => 'thumbnail',
                'src'      => $education->thumbnail,
                'alt'      => $education->name . ', ' . ' thumbnail',
                'width'    => '40px',
                'download' => true,
                'external' => true,
                'filename' => getFileSlug($education->name . '-thumbnail', $education->thumbnail)
            ])
        @endif

    </div>

@endsection
