@extends('guest.layouts.default', [
    'title'         => 'Dictionary: ' . $server->name,
    'breadcrumbs'   => [
        [ 'name' => 'Home',       'href' => route('home') ],
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
            'value' => $server->full_name
        ])

        @include('guest.components.show-row', [
            'name'  => 'name',
            'value' => $server->name
        ])

        @include('guest.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $server->abbreviation
        ])

        @include('guest.components.show-row', [
            'name'  => 'definition',
            'value' => nl2br($server->definition)
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'open source',
            'checked' => $server->open_source
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'proprietary',
            'checked' => $server->proprietary
        ])

        @include('guest.components.show-row', [
            'name'  => 'owner',
            'value' => $server->owner
        ])

        @include('guest.components.show-row-link', [
            'name'   => 'wikipedia',
            'href'   => $server->wikipedia,
            'target' => '_blank'
        ])

        @include('guest.components.show-row-link', [
            'name'   => !empty($server->link_name) ? $server->link_name : 'link',
            'href'   => $server->link,
            'target' => '_blank'
        ])

        @include('guest.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($server->description)
        ])

        @if(!empty($server->image))

            @include('guest.components.show-row-image-credited', [
                'name'         => 'image',
                'src'          => $server->image,
                'alt'          => $server->name,
                'width'        => '300px',
                'download'     => true,
                'external'     => true,
                'filename'     => getFileSlug($server->name, $server->image),
                'image_credit' => $server->image_credit,
                'image_source' => $server->image_source,
            ])

        @endif

    </div>

@endsection
