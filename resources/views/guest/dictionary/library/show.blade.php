@extends('guest.layouts.default', [
    'title'         => $library->name . ' library',
    'breadcrumbs'   => [
        [ 'name' => 'Home',       'href' => route('system.index') ],
        [ 'name' => 'Dictionary', 'href' => route('guest.dictionary.index') ],
        [ 'name' => 'Libraries',  'href' => route('guest.dictionary.library.index') ],
        [ 'name' => $library->name ],
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
            'value' => htmlspecialchars($library->full_name, '')
        ])

        @include('guest.components.show-row', [
            'name'  => 'name',
            'value' => htmlspecialchars($library->name, '')
        ])

        @include('guest.components.show-row', [
            'name'  => 'abbreviation',
            'value' => htmlspecialchars($library->abbreviation ?? '')
        ])

        @include('guest.components.show-row', [
            'name'  => 'definition',
            'value' => $library->definition ?? ''
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'open source',
            'checked' => $library->open_source
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'proprietary',
            'checked' => $library->proprietary
        ])

        @include('guest.components.show-row', [
            'name'  => 'owner',
            'value' => htmlspecialchars($library->owner ?? '')
        ])

        @include('guest.components.show-row-link', [
            'name'   => 'wikipedia',
            'href'   => $library->wikipedia,
            'target' => '_blank'
        ])

        @include('guest.components.show-row-link', [
            'name'   => htmlspecialchars($library->link_name ?? 'link'),
            'href'   => htmlspecialchars($library->link ?? ''),
            'target' => '_blank'
        ])

        @include('guest.components.show-row', [
            'name'  => 'description',
            'value' => $library->description ?? ''
        ])

        @if(!empty($library->image))

            @include('guest.components.show-row-image', [
                'name'  => 'image',
                'src'   => $library->image,
                'alt'   => $library->name,
                'width' => '300px',
            ])

            @include('guest.components.show-row', [
                'name'  => 'image credit',
                'value' => htmlspecialchars($library->image_credit ?? '')
            ])

            @include('guest.components.show-row', [
                'name'  => 'image source',
                'value' => htmlspecialchars($library->image_source ?? '')
            ])

        @endif

    </div>

@endsection
