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
    if (canUpdate(PermissionEntityTypes::RESOURCE, $academy, $admin)) {
        $navButtons[] = view('admin.components.nav-button-edit', ['href' => route('admin.portfolio.academy.edit', $academy)])->render();
    }
    if (canCreate(PermissionEntityTypes::RESOURCE, 'academy', $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Academy', 'href' => route('admin.portfolio.academy.create')])->render();
    }
    $navButtons[] = view('admin.components.nav-button-back', ['href' => referer('admin.portfolio.academy.index')])->render();
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container">
        <div class="show-container card floating-div">

            <div class="m-2" style="display: inline-block; position: absolute; top: 0; right: 0;">
                @include('admin.components.nav-prev-next', [ 'prev' => $prev, 'next' => $next ])
            </div>

            @include('admin.components.show-row', [
                'name'  => 'id',
                'value' => $academy->id
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
                'name'   => !empty($academy->link_name) ? $academy->link_name : 'link',
                'href'   => $academy->link,
                'target' => '_blank'
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
