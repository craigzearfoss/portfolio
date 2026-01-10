@extends('guest.layouts.default', [
    'title'         => $server->name . ' server',
    'breadcrumbs'   => [
        [ 'name' => 'Home',       'href' => route('system.index') ],
        [ 'name' => 'Dictionary', 'href' => route('guest.dictionary.index') ],
        [ 'name' => 'Servers',    'href' => route('guest.dictionary.server.index') ],
        [ 'name' => $server->name ],
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
            'value' => htmlspecialchars($server->full_name ?? '')
        ])

        @include('guest.components.show-row', [
            'name'  => 'name',
            'value' => htmlspecialchars($server->name ?? '')
        ])

        @include('guest.components.show-row', [
            'name'  => 'abbreviation',
            'value' => htmlspecialchars($server->abbreviation ?? '')
        ])

        @include('guest.components.show-row', [
            'name'  => 'definition',
            'value' => $server->definition ?? ''
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'open source',
            'checked' => htmlspecialchars($server->open_source ?? '')
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'proprietary',
            'checked' => $server->proprietary
        ])

        @include('guest.components.show-row', [
            'name'  => 'owner',
            'value' => htmlspecialchars($server->owner ?? '')
        ])

        @include('guest.components.show-row-link', [
            'name'   => 'wikipedia',
            'href'   => $server->wikipedia,
            'target' => '_blank'
        ])

        @include('guest.components.show-row-link', [
            'name'   => htmlspecialchars($server->link_name ?? 'link'),
            'href'   => htmlspecialchars($server->link ?? ''),
            'target' => '_blank'
        ])

        @include('guest.components.show-row', [
            'name'  => 'description',
            'value' => $server->description ?? ''
        ])

        @if(!empty($server->image))

            @include('guest.components.show-row-image', [
                'name'  => 'image',
                'src'   => $server->image,
                'alt'   => $server->name,
                'width' => '300px',
            ])

            @include('guest.components.show-row', [
                'name'  => 'image credit',
                'value' => htmlspecialchars($server->image_credit ?? '')
            ])

            @include('guest.components.show-row', [
                'name'  => 'image source',
                'value' => htmlspecialchars($server->image_source ?? '')
            ])

        @endif

    </div>

@endsection
