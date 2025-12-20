@extends('admin.layouts.default', [
    'title'         => 'Photography',
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Photography' ],
    ],
    'buttons'       => [
        canCreate('photography')
            ? [ [ 'name' => '<i class="fa fa-plus"></i> Add New Photo', 'href' => route('admin.portfolio.photography.create') ]]
            : [],
    ],
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
                <th>name</th>
                <th class="has-text-centered">featured</th>
                <th>year</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                @if(isRootAdmin())
                    <th>owner</th>
                @endif
                <th>name</th>
                <th class="has-text-centered">featured</th>
                <th>year</th>
                <th class="has-text-centered">public</th>
                <th class="has-text-centered">disabled</th>
                <th>actions</th>
            </tr>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($photos as $photo)

                <tr data-id="{{ $photo->id }}">
                    @if(isRootAdmin())
                        <td data-field="owner.username">
                            {{ $photo->owner->username ?? '' }}
                        </td>
                    @endif
                    <td data-field="featured" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $photo->featured ])
                    </td>
                    <td data-field="year">
                        {{ $photo->year }}
                    </td>
                    <td data-field="public" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $photo->public ])
                    </td>
                    <td data-field="disabled" class="has-text-centered">
                        @include('admin.components.checkmark', [ 'checked' => $photo->disabled ])
                    </td>
                    <td class="is-1" style="white-space: nowrap;">
                        <form action="{{ route('admin.portfolio.photography.destroy', $photo->id) }}" method="POST">

                            @if(canRead($photo))
                                <a title="show" class="button is-small px-1 py-0"
                                   href="{{ route('admin.portfolio.photography.show', $photo->id) }}">
                                    <i class="fa-solid fa-list"></i>
                                </a>
                            @endif

                            @if(canUpdate($photo))
                                <a title="edit" class="button is-small px-1 py-0"
                                   href="{{ route('admin.portfolio.photography.edit', $photo->id) }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            @endif

                            @if (!empty($photo->link))
                                <a title="{{ !empty($photo->link_name) ? $photo->link_name : 'link' }}"
                                   class="button is-small px-1 py-0"
                                   href="{{ $photo->link }}"
                                   target="_blank"
                                >
                                    <i class="fa-solid fa-external-link"></i>
                                </a>
                            @else
                                <a class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                    <i class="fa-solid fa-external-link"></i>
                                </a>
                            @endif

                            @if(canDelete($photo))
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
                    <td colspan="{{ isRootAdmin() ? '7' : '6' }}">There is are no photos.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $photos->links('vendor.pagination.bulma') !!}

    </div>

@endsection
