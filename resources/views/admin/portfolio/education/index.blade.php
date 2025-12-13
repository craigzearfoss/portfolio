@extends('admin.layouts.default', [
    'breadcrumbs' => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Education' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Education', 'href' => route('admin.portfolio.education.create') ],
    ],
    'errorMessages'=> $errors->messages() ?? [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
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
                        {{ $education->degreeType->name }}
                    </td>
                    <td data-field="major">
                        {{ $education->major }}
                    </td>
                    <td data-field="minor">
                        {{ $education->minor }}
                    </td>
                    <td data-field="school.name">
                        {{ $education->school->name }}
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
                                <a title="show" class="button is-small px-1 py-0"
                                   href="{{ route('admin.portfolio.education.show', $education->id) }}">
                                    <i class="fa-solid fa-list"></i>
                                </a>
                            @endif

                            @if(canUpdate($education))
                                <a title="edit" class="button is-small px-1 py-0"
                                   href="{{ route('admin.portfolio.education.edit', $education->id) }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            @endif

                            @if (!empty($education->link))
                                <a title="{{ !empty($education->link_name) ? $education->link_name : 'link' }}"
                                   class="button is-small px-1 py-0"
                                   href="{{ $education->link }}"
                                   target="_blank"
                                >
                                    <i class="fa-solid fa-external-link"></i>
                                </a>
                            @else
                                <a class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link"></i>
                                </a>
                            @endif

                            @if(canDelete($education))
                                @csrf
                                @method('DELETE')
                                <button title="delete" type="submit" class="delete-btn button is-small px-1 py-0">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
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
