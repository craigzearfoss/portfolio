@extends('guest.layouts.default', [
    'title'         => 'Dictionary: ' . $framework->name,
    'breadcrumbs'   => [
        [ 'name' => 'Home',       'href' => route('home') ],
        [ 'name' => 'Dictionary', 'href' => route('guest.dictionary.index') ],
        [ 'name' => 'Frameworks', 'href' => route('guest.dictionary.framework.index') ],
        [ 'name' => $framework->name ],
    ],
    'buttons'       => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('guest.dictionary.index') ],
    ],
    'errorMessages' => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => $admin,
])

@section('content')

    <div class="show-container card p-4">

        @include('guest.components.show-row', [
            'name'  => 'full name',
            'value' => $framework->full_name
        ])

        @include('guest.components.show-row', [
            'name'  => 'name',
            'value' => $framework->name
        ])

        @include('guest.components.show-row', [
            'name'  => 'abbreviation',
            'value' => $framework->abbreviation
        ])

        @include('guest.components.show-row', [
            'name'  => 'definition',
            'value' => nl2br($framework->definition)
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'open source',
            'checked' => $framework->open_source
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'proprietary',
            'checked' => $framework->proprietary
        ])

        @include('guest.components.show-row', [
            'name'  => 'owner',
            'value' => $framework->owner
        ])

        @include('guest.components.show-row-link', [
            'name'   => 'wikipedia',
            'href'   => $framework->wikipedia,
            'target' => '_blank'
        ])

        @include('guest.components.show-row-link', [
            'name'   => !empty($framework->link_name) ? $framework->link_name : 'link',
            'href'   => $framework->link,
            'target' => '_blank'
        ])

        @include('guest.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($framework->description)
        ])

        @if(!empty($framework->image))

            @include('guest.components.show-row-image-credited', [
                'name'         => 'image',
                'src'          => $framework->image,
                'alt'          => $framework->name,
                'width'        => '300px',
                'download'     => true,
                'external'     => true,
                'filename'     => getFileSlug($framework->name, $framework->image),
                'image_credit' => $framework->image_credit,
                'image_source' => $framework->image_source,
            ])

        @endif

    </div>

@endsection
