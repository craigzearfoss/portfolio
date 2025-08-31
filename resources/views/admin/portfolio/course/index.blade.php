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
    'errors' => $errors ?? [],
])

@section('content')

    <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
        <thead>
        <tr>
            <th>name</th>
            <th>completed</th>
            <th class="text-center">professional</th>
            <th class="text-center">personal</th>
            <th>academy</th>
            <th>instructor</th>
            <th class="text-center">sequence</th>
            <th class="text-center">public</th>
            <th class="text-center">read-only</th>
            <th class="text-center">root</th>
            <th class="text-center">disabled</th>
            <th>actions</th>
        </tr>
        </thead>
        <?php /*
        <tfoot>
        <tr>
            <th>name</th>
            <th>completed</th>
            <th class="text-center">professional</th>
            <th class="text-center">personal</th>
            <th>academy</th>
            <th>instructor</th>
            <th class="text-center">sequence</th>
            <th class="text-center">public</th>
            <th class="text-center">read-only</th>
            <th class="text-center">root</th>
            <th class="text-center">disabled</th>
            <th>actions</th>
        </tr>
        </tfoot>
        */ ?>
        <tbody>

        @forelse ($courses as $course)

            <tr>
                <td class="py-0">
                    {{ $course->name }}
                </td>
                <td class="py-0">
                    {{ shortDate($course->completed) }}
                </td>
                <td class="py-0 text-center">
                    @include('admin.components.checkmark', [ 'checked' => $course->professional ])
                </td>
                <td class="py-0 text-center">
                    @include('admin.components.checkmark', [ 'checked' => $course->personal ])
                </td>
                <td class="py-0">
                    {{ $course->academy->name }}
                </td>
                <td class="py-0">
                    {{ $course->instructor }}
                </td>
                <td class="py-0">
                    {{ $course->name }}
                </td>
                <td class="py-0">
                    {{ $course->sequence }}
                </td>
                <td class="py-0 text-center">
                    @include('admin.components.checkmark', [ 'checked' => $course->public ])
                </td>
                <td class="py-0 text-center">
                    @include('admin.components.checkmark', [ 'checked' => $course->readonly ])
                </td>
                <td class="py-0 text-center">
                    @include('admin.components.checkmark', [ 'checked' => $course->root ])
                </td>
                <td class="py-0 text-center">
                    @include('admin.components.checkmark', [ 'checked' => $course->disabled ])
                </td>
                <td class="is-1 white-space-nowrap py-0" style="white-space: nowrap;">
                    <form action="{{ route('admin.portfolio.course.destroy', $course->id) }}" method="POST">

                        <a title="show" class="button is-small px-1 py-0"
                           href="{{ route('admin.portfolio.course.show', $course->id) }}">
                            <i class="fa-solid fa-list"></i>{{-- Show--}}
                        </a>

                        <a title="edit" class="button is-small px-1 py-0"
                           href="{{ route('admin.portfolio.course.edit', $course->id) }}">
                            <i class="fa-solid fa-pen-to-square"></i>{{-- Edit--}}
                        </a>

                        @if (!empty($course->website))
                            <a title="website" class="button is-small px-1 py-0" href="{{ $course->website }}"
                               target="_blank">
                                <i class="fa-solid fa-external-link"></i>{{-- website--}}
                            </a>
                        @else
                            <a title="website" class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                <i class="fa-solid fa-external-link"></i>{{-- website--}}
                            </a>
                        @endif

                        @csrf
                        @method('DELETE')
                        <button title="delete" type="submit" class="button is-small px-1 py-0">
                            <i class="fa-solid fa-trash"></i>{{--  Delete--}}
                        </button>
                    </form>
                </td>
            </tr>

        @empty

            <tr>
                <td colspan="12">There are no courses.</td>
            </tr>

        @endforelse

        </tbody>
    </table>

    {!! $courses->links('vendor.pagination.bulma') !!}

@endsection
