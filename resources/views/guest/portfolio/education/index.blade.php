@extends('guest.layouts.default', [
    'title'         => $pageTitle ?? $currentAdmin->name . ' education',
    'breadcrumbs'   => [
        [ 'name' => 'Home',       'href' => route('home') ],
        [ 'name' => 'Users',      'href' => route('home') ],
        [ 'name' => $currentAdmin->name, 'href' => route('guest.admin.show', $currentAdmin)],
        [ 'name' => 'Portfolio',  'href' => route('guest.portfolio.index', $currentAdmin) ],
        [ 'name' => 'Education' ],
    ],
    'buttons'       => [],
    'errorMessages' => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => $currentAdmin ?? null,
])

@section('content')

    <div class="card p-4">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                <th>degree<br>type</th>
                <th>major</th>
                <th>minor</th>
                <th>school</th>
                <th>graduated</th>
                <th>graduation<br>date</th>
                <th>currently<br>enrolled</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>degree<br>type</th>
                <th>major</th>
                <th>minor</th>
                <th>school</th>
                <th>graduated</th>
                <th>graduation<br>date</th>
                <th>currently<br>enrolled</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($educations as $education)

                <tr>
                    <td data-field="degreeType.name">
                        @include('guest.components.link', [
                            'name'  => $education->degreeType->name ?? '',
                            'href'  => route('guest.portfolio.education.show', [$currentAdmin, $education->id]),
                        ])
                    </td>
                    <td data-field="major">
                        @include('guest.components.link', [
                            'name'  => $education->major,
                            'href'  => route('guest.portfolio.education.show', [$currentAdmin, $education->id]),
                        ])
                    </td>
                    <td data-field="minor">
                        @include('guest.components.link', [
                            'name'  => $education->minor,
                            'href'  => route('guest.portfolio.education.show', [$currentAdmin, $education->id]),
                        ])
                    </td>
                    <td data-field="school.name">
                        {!! $education->school->name ?? '' !!}
                    </td>
                    <td data-field="graduated" class="has-text-centered">
                        @include('guest.components.checkmark', [ 'checked' => $education->graduated ])
                    </td>
                    <td data-field="graduation_month|graduation_year">
                        {{ $education->graduation_year }}
                    </td>
                    <td data-field="currently_enrolled" class="has-text-centered">
                        @include('guest.components.checkmark', [ 'checked' => $education->currently_enrolled ])
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
