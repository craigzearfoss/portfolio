@php
    $buttons = [];
    if (canCreate('education', currentAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Education', 'href' => route('admin.portfolio.education.create') ];
    }
@endphp
@extends('admin.layouts.default', [
    'title'         => 'Education',
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Education' ],
    ],
    'buttons'       => $buttons,
    'errorMessages' => $errors->messages() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => Auth::guard('admin')->user(),
])

@section('content')

    <div class="card p-4">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                @if(isRootAdmin())
                    <th>owner</th>
                @endif
                <th>degree<br>type</th>
                <th>major</th>
                <th>minor</th>
                <th>school</th>
                <th>enrollment<br>date</th>
                <th>graduated</th>
                <th>graduation<br>date</th>
                <th>currently<br>enrolled</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                @if(isRootAdmin())
                    <th>owner</th>
                @endif
                <th>degree<br>type</th>
                <th>major</th>
                <th>minor</th>
                <th>school</th>
                <th>enrollment<br>date</th>
                <th>graduated</th>
                <th>graduation<br>date</th>
                <th>currently<br>enrolled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($educations as $education)

                <tr data-id="{{ $education->id }}">
                    @if(isRootAdmin())
                        <td data-field="owner.username">
                            {{ $education->owner->username ?? '' }}
                        </td>
                    @endif
                    <td data-field="degreeType.name">
                        {{ htmlspecialchars($education->degreeType->name ?? '') }}
                    </td>
                    <td data-field="major">
                        {{ htmlspecialchars($education->major ?? '') }}
                    </td>
                    <td data-field="minor">
                        {{ htmlspecialchars($education->minor ?? '') }}
                    </td>
                    <td data-field="school.name">
                        {{ htmlspecialchars($education->school->name ?? '') }}
                    </td>
                    <td data-field="enrollment_month|enrollment_year">
                        {{ $education->enrollment_year }}
                    </td>
                    <td data-field="graduated" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $education->graduated ])
                    </td>
                    <td data-field="graduation_month|graduation_year">
                        {{ $education->graduation_year }}
                    </td>
                    <td data-field="currently_enrolled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $education->currently_enrolled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">

                        <form action="{{ route('admin.portfolio.education.destroy', $education->id) }}" method="POST">

                            @if(canRead($education))
                                @include('admin.components.link-icon', [
                                    'title' => 'show',
                                    'href'  => route('admin.portfolio.education.show', $education->id),
                                    'icon'  => 'fa-list'
                                ])
                            @endif

                            @if(canUpdate($education))
                                @include('admin.components.link-icon', [
                                    'title' => 'edit',
                                    'href'  => route('admin.portfolio.education.edit', $education->id),
                                    'icon'  => 'fa-pen-to-square'
                                ])
                            @endif

                            @if (!empty($education->link))
                                @include('admin.components.link-icon', [
                                    'title'  => htmlspecialchars((!empty($education->link_name) ? $education->link_name : 'link') ?? ''),
                                    'href'   => $education->link,
                                    'icon'   => 'fa-external-link',
                                    'target' => '_blank'
                                ])
                            @else
                                @include('admin.components.link-icon', [
                                    'title'    => 'link',
                                    'icon'     => 'fa-external-link',
                                    'disabled' => true
                                ])
                            @endif

                            @if(canDelete($education))
                                @csrf
                                @method('DELETE')
                                @include('admin.components.button-icon', [
                                    'title' => 'delete',
                                    'class' => 'delete-btn',
                                    'icon'  => 'fa-trash'
                                ])
                            @endif


                        </form>

                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="{{ isRootAdmin() ? '10' : '9' }}">There is no education.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $educations->links('vendor.pagination.bulma') !!}

    </div>

@endsection
