@extends('guest.layouts.default', [
    'title'         => $stack->name . ' stack',
    'breadcrumbs'   => [
        [ 'name' => 'Home',       'href' => route('system.index') ],
        [ 'name' => 'Dictionary', 'href' => route('guest.dictionary.index') ],
        [ 'name' => 'Stacks',     'href' => route('guest.dictionary.stack.index') ],
        [ 'name' => $stack->name ],
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
            'value' => htmlspecialchars($stack->full_name ?? '')
        ])

        @include('guest.components.show-row', [
            'name'  => 'name',
            'value' => htmlspecialchars($stack->name ?? '')
        ])

        @include('guest.components.show-row', [
            'name'  => 'abbreviation',
            'value' => htmlspecialchars($stack->abbreviation ?? '')
        ])

        @include('guest.components.show-row', [
            'name'  => 'definition',
            'value' => $stack->definition ?? ''
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'open source',
            'checked' => $stack->open_source
        ])

        @include('guest.components.show-row-checkbox', [
            'name'    => 'proprietary',
            'checked' => $stack->proprietary
        ])

        @include('guest.components.show-row', [
            'name'  => 'owner',
            'value' => htmlspecialchars($stack->owner ?? '')
        ])

        @include('guest.components.show-row-link', [
            'name'   => 'wikipedia',
            'href'   => $stack->wikipedia,
            'target' => '_blank'
        ])

        @include('guest.components.show-row-link', [
            'name'   => htmlspecialchars($stack->link_name ?? 'link'),
            'href'   => htmlspecialchars($stack->link ?? ''),
            'target' => '_blank'
        ])

        @include('guest.components.show-row', [
            'name'  => 'description',
            'value' => nl2br($stack->description ?? '')
        ])

        @if(!empty($stack->image))

            @include('guest.components.show-row-image', [
                'name'  => 'image',
                'src'   => $stack->image,
                'alt'   => $stack->name,
                'width' => '300px',
            ])

            @include('guest.components.show-row', [
                'name'  => 'image credit',
                'value' => htmlspecialchars($stack->image_credit >> '')
            ])

            @include('guest.components.show-row', [
                'name'  => 'image source',
                'value' => htmlspecialchars($stack->image_source ?? '')
            ])

        @endif

    </div>

@endsection
