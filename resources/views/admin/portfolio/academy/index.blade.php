@php
    use App\Models\Portfolio\Academy;
    use Illuminate\Support\Number;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title    = $pageTitle ?? 'Academies';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Portfolio',       'href' => route('admin.portfolio.index') ],
        [ 'name' => 'Academies' ],
    ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(Academy::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Academy', 'href' => route('admin.portfolio.academy.create', $owner ??  $admin)])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="floating-div-container" style="max-width: 40em !important;">

        <div class="show-container card floating-div">

            @include('admin.components.export-buttons-container', [
                'href'     => route('admin.portfolio.academy.export', request()->except([ 'page' ])),
                'filename' => 'academies_' . date("Y-m-d-His") . '.xlsx',
            ])

            <p><i>{{ Number::format($academies->total()) }} records found.</i></p>

            @if(!empty($pagination_top))
                {!! $academies->links('vendor.pagination.bulma') !!}
            @endif

            <?php /* <p class="admin-table-caption"></p> */ ?>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        <th>name</th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </thead>
                @endif

                @if($bottom_column_headings)
                    <tfoot>
                    <tr>
                        <th>name</th>
                        <th class="has-text-centered">public</th>
                        <th class="has-text-centered">disabled</th>
                        <th>actions</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($academies as $academy)

                    <tr data-id="{{ $academy->id }}">
                        <td data-field="name">
                            {!! $academy->name !!}
                        </td>
                        <td data-field="is_public" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $academy->is_public ])
                        </td>
                        <td data-field="is_disabled" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $academy->is_disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead($academy, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.portfolio.academy.show', $academy),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate($academy, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.portfolio.academy.edit', $academy),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (!empty($academy->link))
                                    @include('admin.components.link-icon', [
                                        'title'  => $academy->link_name ?? 'link',
                                        'href'   => $academy->link,
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

                                @if(canDelete($academy, $admin))
                                    <form class="delete-resource" action="{!! route('admin.portfolio.academy.destroy', $academy) !!}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        @include('admin.components.button-icon', [
                                            'title' => 'delete',
                                            'class' => 'delete-btn',
                                            'icon'  => 'fa-trash'
                                        ])
                                    </form>
                                @endif

                            </div>

                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="4">No academies found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if(!empty($pagination_bottom))
                {!! $academies->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
