@extends('guest.layouts.default', [
    'title'         => $operatingSystem->name . ' operating system',
    'breadcrumbs'   => [
        [ 'name' => 'Home',              'href' => route('system.index') ],
        [ 'name' => 'Dictionary',        'href' => route('guest.dictionary.index') ],
        [ 'name' => 'Operating Systems', 'href' => route('guest.dictionary.operating-system.index') ],
        [ 'name' => $operatingSystem->name ],
    ],
    'buttons'       => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('guest.dictionary.index') ],
    ],
    'errorMessages' => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => $admin ?? null,
])

@section('content')

    <div class="show-container card p-4">

        @include('guest.components.show-row', [
            'name'  => 'full name',
            'value' => $operatingSystem->full_name
        ])

        @include('guest.components.show-row', [
            'name'  => 'name',
            'value' => $operatingSystem->name
        ])

        @include('guest.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $operatingSystem->abbreviation
        ])

        @include('guest.components.show-row', [
            'name'  => 'definition',
            'value' => nl2br($operatingSystem->definition)
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'open source',
            'checked' => $operatingSystem->open_source
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'proprietary',
            'checked' => $operatingSystem->proprietary
        ])

        @include('guest.components.show-row', [
            'name'  => 'owner',
            'value' => $operatingSystem->owner
        ])

        @include('guest.components.show-row-link', [
            'name'   => 'wikipedia',
            'href'   => $operatingSystem->wikipedia,
            'target' => '_blank'
        ])

        @include('guest.components.show-row-link', [
            'name'   => $operatingSystem->link_name,
            'href'   => $operatingSystem->link,
            'target' => '_blank'
        ])

        @include('guest.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($operatingSystem->description)
        ])

        @if(!empty($operatingSystem->image))

            @include('guest.components.show-row-image-credited', [
                'name'         => 'image',
                'src'          => $operatingSystem->image,
                'alt'          => $operatingSystem->name,
                'width'        => '300px',
                'download'     => true,
                'external'     => true,
                'filename'     => getFileSlug($operatingSystem->name, $operatingSystem->image),
                'image_credit' => $operatingSystem->image_credit,
                'image_source' => $operatingSystem->image_source,
            ])

        @endif

    </div>

@endsection
