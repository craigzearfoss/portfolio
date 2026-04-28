@php
    use Illuminate\Support\Number;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;
    $session     = $session ?? null;

    $title    = $pageTitle ?? 'Sessions';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => 'Sessions' ],
    ];

    // set navigation buttons
    $navButtons = [];
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.system-session', [ 'owner_id' => $owner->id ?? null])

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            @include('admin.components.export-buttons-container', [
                'href'     => route('admin.system.session.export', request()->except([ 'page' ])),
                'filename' => 'sessions_' . date("Y-m-d-His") . '.xlsx',
            ])

            <p><i>{{ Number::format($sessions->total()) }} records found.</i></p>

            @if(!empty($pagination_top))
                {!! $sessions->links('vendor.pagination.bulma') !!}
            @endif

            <?php /* <p class="admin-table-caption"></p> */ ?>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        <th>id</th>
                        <th>user_id</th>
                        <th>admin_id</th>
                        <th>ip_address</th>
                        <th>last_activity</th>
                        <th>actions</th>
                    </tr>
                    </thead>
                @endif

                @if($bottom_column_headings)
                    <tfoot>
                    <tr>
                        <th>id</th>
                        <th>user_id</th>
                        <th>admin_id</th>
                        <th>ip_address</th>
                        <th>last_activity</th>
                        <th>actions</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($sessions as $session)

                    <tr data-id="{{ $session->id }}">
                        <td data-field="id">
                            {{ $session['id'] }}
                        </td>
                        <td data-field="user_id">
                            {{ $session->user_id }}
                        </td>
                        <td data-field="admin_id">
                            {{ $session->admin_id }}
                        </td>
                        <td data-field="ip_address">
                            {!! $session->ip_address !!}
                        </td>
                        <td data-field="last_activity">
                            {!! $session->last_activity !!}
                        </td>
                        <td>
                            <?php /* @TODO:
                            <a class="button is-small px-1 py-0" href="{!! route('admin.session.show', $session->id) !!}">
                                <i class="fa-solid fa-list"></i>
                            </a>
                            */ ?>
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="6">No sessions found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            {!! $sessions->links('vendor.pagination.bulma') !!}

        </div>

    </div>

@endsection
