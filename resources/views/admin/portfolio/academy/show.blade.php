@php
    use App\Enums\PermissionEntityTypes;

    $title = $pageTitle ?? 'Academy: ' . $academy->name;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Academies',       'href' => route('admin.portfolio.academy.index') ],
        [ 'name' => $academy->name ],
    ];

    // set navigation buttons
    $navButtons = [];
    if (canUpdate($academy, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', ['href' => route('admin.portfolio.academy.edit', $academy)])->render();
    }
    if (canCreate($academy, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Academy', 'href' => route('admin.portfolio.academy.create')])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', ['href' => referer('admin.portfolio.academy.index')])->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            @include('admin.components.show-row', [
                'name'  => 'id',
                'value' => $academy->id,
                'hide'  => !$isRootAdmin,
            ])

            @include('admin.components.show-row', [
                'name'  => 'name',
                'value' => $academy->name
            ])

            @include('admin.components.show-row', [
                'name'  => 'slug',
                'value' => $academy->slug
            ])

            @include('admin.components.show-row-link', [
                'name'   => 'link',
                'href'   => $academy->link,
                'target' => '_blank'
            ])

            @include('admin.components.show-row', [
                'name'   => 'link name',
                'label'  => 'link_name',
                'value'  => $academy->link_name,
            ])

            @include('admin.components.show-row', [
                'name'  => 'description',
                'value' => $academy->description
            ])

            @include('admin.components.show-row-images', [
                'resource' => $academy,
                'download' => true,
                'external' => true,
            ])

            @include('admin.components.show-row-visibility', [
                'resource' => $academy,
            ])

            @include('admin.components.show-row', [
                'name'  => 'created at',
                'value' => longDateTime($academy->created_at)
            ])

            @include('admin.components.show-row', [
                'name'  => 'updated at',
                'value' => longDateTime($academy->updated_at)
            ])

        </div>
    </div>

@endsection
