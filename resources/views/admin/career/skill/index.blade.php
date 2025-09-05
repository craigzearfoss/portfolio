@extends('admin.layouts.default', [
    'title' => 'Skills',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'url' => route('admin.career.index') ],
        [ 'name' => 'Skills' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Skill', 'url' => route('admin.career.skill.create') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div class="card">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                <th>name</th>
                <th class="text-center">public</th>
                <th class="text-center">disabled</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>name</th>
                <th class="text-center">public</th>
                <th class="text-center">disabled</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($skills as $skill)

                <tr>
                    <td>
                        {{ $skill->name }}
                    </td>
                    <td class="text-center">
                        @include('admin.components.checkmark', [ 'checked' => $skill->public ])
                    </td>
                    <td class="text-center">
                        @include('admin.components.checkmark', [ 'checked' => $skill->disabled ])
                    </td>
                    <td class="is-1 white-space-nowrap py-0" style="white-space: nowrap;">
                        <form action="{{ route('admin.career.skill.destroy', $skill->id) }}" method="POST">

                            <a title="show" class="button is-small px-1 py-0"
                               href="{{ route('admin.career.skill.show', $skill->id) }}">
                                <i class="fa-solid fa-list"></i>{{-- Show--}}
                            </a>

                            <a title="edit" class="button is-small px-1 py-0"
                               href="{{ route('admin.career.skill.edit', $skill->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>{{-- Edit--}}
                            </a>

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
                    <td colspan="4">There are no skills.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $skills->links('vendor.pagination.bulma') !!}

    </div>

@endsection
