@extends('admin.layouts.default', [
    'title' => 'Courses',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'url' => route('admin.portfolio.index') ],
        [ 'name' => 'Courses' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Course', 'url' => route('admin.portfolio.course.create') ],
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
                    <th>admin</th>
                @endif
                <th>name</th>
                <th class=" has-text-centered">completion<br>date</th>
                <th>academy</th>
                <th>sponsor</th>
                <th class="has-text-centered">featured</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                @if(isRootAdmin())
                    <th>admin</th>
                @endif
                <th>name</th>
                <th class=" has-text-centered">completion<br>date</th>
                <th>academy</th>
                <th>sponsor</th>
                <th class="has-text-centered">featured</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($courses as $course)

                <tr data-id="{{ $course->id }}">
                    @if(isRootAdmin())
                        <td data-field="admin.username">
                            @if(!empty($course->admin))
                                @include('admin.components.link', [
                                    'name' => $course->admin['username'],
                                    'url'  => route('admin.admin.show', $course->admin['id'])
                                ])
                            @endif
                        </td>
                    @endif
                    <td data-field="name">
                        {{ $course->name }}
                    </td>
                    <td data-field="completion_date">
                        {{ shortDate($course->completion_date) }}
                    </td>
                    <td data-field="academy.name">
                        @if (!empty($course->academy))
                            <a href="{{ $course->academy['id'] }}" target="_blank">{{ $course->academy['name'] }}</a>
                        @endif
                    </td>
                    <td data-field="sponsor">
                        {{ $course->sponsor }}
                    </td>
                    <td data-field="featured" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $course->featured ])
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $course->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $course->disabled ])
                    </td>
                    <td class="is-1 white-space-nowrap" style="white-space: nowrap;">
                        <form action="{{ route('admin.portfolio.course.destroy', $course->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.portfolio.course.show', $course->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- Show--}}
                            </a>

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.portfolio.course.edit', $course->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- Edit --}}
                            </a>

                            @if (!empty($course->certificate_url))
                                <a title="open certificate in a new window" class="button is-small px-1 py-0" href="{{ $course->certificate_url }}"
                                   target="_blank">
                                    <i class="fa-solid fa-external-link"></i>{{-- certificate_url --}}
                                </a>
                            @else
                                <a class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link"></i>{{-- certificate_url --}}
                                </a>
                            @endif

                            @if (!empty($course->link))
                                <a title="{{ !empty($course->link_name) ? $course->link_name : 'link' }}link"
                                   class="button is-small px-1 py-0"
                                   href="{{ $course->link }}"
                                   target="_blank">
                                    <i class="fa-solid fa-external-link"></i>{{-- Link --}}
                                </a>
                            @else
                                <a class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link"></i>{{-- Link --}}
                                </a>
                            @endif

                            @csrf
                            @method('DELETE')
                            <button title="delete" type="submit" class="button is-small px-1 py-0">
                                <i class="fa-solid fa-trash"></i>{{-- Delete --}}
                            </button>
                        </form>
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="{{ isRootAdmin() ? '9' : '8' }}">There are no courses.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $courses->links('vendor.pagination.bulma') !!}

    </div>

@endsection
