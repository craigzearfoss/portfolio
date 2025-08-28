@extends('admin.layouts.default', [
    'title' => 'Certifications',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard')],
        [ 'name' => 'Certifications']
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-plus"></i> Add New Certification', 'url' => route('admin.portfolio.certification.create') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
        <thead>
        <tr>
            <th>name</th>
            <th>organization</th>
            <th>received</th>
            <th>expiration</th>
            <th class="text-center">professional</th>
            <th class="text-center">personal</th>
            <th class="text-center">public</th>
            <th class="text-center">disabled</th>
            <th>actions</th>
        </tr>
        </thead>
        <?php /*
        <tfoot>
        <tr>
            <th>name</th>
            <th>organization</th>
            <th>received</th>
            <th>expiration</th>
            <th class="text-center">professional</th>
            <th class="text-center">personal</th>
            <th class="text-center">public</th>
            <th class="text-center">disabled</th>
            <th>actions</th>
        </tr>
        </tfoot>
        */ ?>
        <tbody>

        @forelse ($certifications as $certification)

            <tr>
                <td>
                    {{ $certification->name }}
                </td>
                <td>
                    {{ $certification->organization }}
                </td>
                <td class="text-nowrap">
                    {{ shortDate($certification->received) }}
                </td>
                <td class="text-nowrap">
                    {{ shortDate($certification->expiration) }}
                </td>
                <td class="text-center">
                    @include('admin.components.checkmark', [ 'checked' => $certification->professional ])
                </td>
                <td class="text-center">
                    @include('admin.components.checkmark', [ 'checked' => $certification->personal ])
                </td>
                <td class="text-center">
                    @include('admin.components.checkmark', [ 'checked' => $certification->public ])
                </td>
                <td class="text-center">
                    @include('admin.components.checkmark', [ 'checked' => $certification->disabled ])
                </td>
                <td class="is-1 white-space-nowrap py-0" style="white-space: nowrap;">
                    <form action="{{ route('admin.portfolio.certification.destroy', $certification->id) }}" method="POST">

                        <a title="show" class="button is-small px-1 py-0"
                           href="{{ route('admin.portfolio.certification.show', $certification->id) }}">
                            <i class="fa-solid fa-list"></i>{{-- Show--}}
                        </a>

                        <a title="edit" class="button is-small px-1 py-0"
                           href="{{ route('admin.portfolio.certification.edit', $certification->id) }}">
                            <i class="fa-solid fa-pen-to-square"></i>{{-- Edit--}}
                        </a>

                        @if (!empty($certification->link))
                            <a title="link" class="button is-small px-1 py-0" href="{{ $certification->link }}"
                               target="_blank">
                                <i class="fa-solid fa-external-link"></i>{{-- link--}}
                            </a>
                        @else
                            <a title="link" class="button is-small px-1 py-0" style="cursor: default; opacity: 0.5;">
                                <i class="fa-solid fa-external-link"></i>{{-- link--}}
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
                <td colspan="9">There are no certifications.</td>
            </tr>

        @endforelse

        </tbody>
    </table>


    {!! $certifications->links('vendor.pagination.bulma') !!}

@endsection
