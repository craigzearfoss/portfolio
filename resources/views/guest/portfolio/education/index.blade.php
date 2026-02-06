@php
    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',       'href' => route('guest.index') ],
        [ 'name' => 'Candidates', 'href' => route('guest.admin.index') ],
        [ 'name' => $owner->name, 'href' => route('guest.admin.show', $owner)],
        [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $owner) ],
        [ 'name' => 'Education' ],
    ];

    // set navigation buttons
    $buttons = [];
@endphp
@extends('guest.layouts.default', [
    'title'            => $pageTitle ?? $owner->name . ' education',
    'breadcrumbs'      => $breadcrumbs,
    'buttons'          => $buttons,
    'errorMessages'    => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'          => session('success') ?? null,
    'error'            => session('error') ?? null,
    'menuService'      => $menuService,
    'currentRouteName' => Route::currentRouteName(),
    'menuService'      => $menuService,
    'admin'            => $admin,
    'user'             => $user,
    'owner'            => $owner,
])

@section('content')

    @if($owner->demo)
        @include('guest.components.disclaimer')
    @endif

    <div class="card p-4">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                <th>major</th>
                <th>degree</th>
                <th>school</th>
                <th class="has-text-centered">graduated</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>major</th>
                <th>degree</th>
                <th>school</th>
                <th class="has-text-centered">graduated</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($educations as $education)

                <tr>
                    <td data-field="major">
                        {{ $education->major }}
                        @if(!empty($education->minor)) {
                            ({{ $education->minor }} minor)
                        @endif
                    </td>
                    <td data-field="degreeType.name">
                        {{ $education->degreeType->name }}
                    </td>
                    <td data-field="school.name">
                        {!! $education->school->name ?? '' !!}
                    </td>
                    <td data-field="graduation_month|graduation_year" class="has-text-centered">
                        {{ $education->graduation_year }}
                        @if(!empty($education->currently_enrolled))
                            (currently enrolled)
                        @endif
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="7">There is no education.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $educations->links('vendor.pagination.bulma') !!}

    </div>

@endsection
