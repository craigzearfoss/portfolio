@php
    use App\Models\Career\JobBoard;
    use Illuminate\Support\Number;

    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className   = 'App\Models\Career\JobBoard';
    $admin       = $admin ?? null;
    $owner       = $owner ?? null;
    $isRootAdmin = $isRootAdmin ?? false;

    $title    = $pageTitle ?? 'Job Boards';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'href' => route('admin.career.index', ['owner_id'=>$owner->id]) ],
        [ 'name' => 'Job Boards' ]
    ];

    // set navigation buttons
    $navButtons = [];
    if (canCreate(JobBoard::class, $admin)) {
        $navButtons[] = view('admin.components.nav-button-add', ['name' => 'Add New Job Board', 'href' => route('admin.career.job-board.create')])->render();
    }
@endphp

@extends('admin.layouts.default')

@section('content')

    @include('admin.components.search-panel.career-job-board')

    <div class="floating-div-container">

        <div class="show-container card floating-div">

            @include('admin.components.export-buttons-container', [
                'href'     => route('admin.career.job-board.export', request()->except([ 'page' ])),
                'filename' => 'job_boards_' . date("Y-m-d-His") . '.xlsx',
            ])

            <p><i>{{ Number::format($jobBoards->total()) }} records found.</i></p>

            @if(!empty($pagination_top))
                {!! $jobBoards->links('vendor.pagination.bulma') !!}
            @endif

            <?php /* <p class="admin-table-caption"></p> */ ?>

            <table class="table admin-table {{ $adminTableClasses ?? '' }}">

                @if($top_column_headings)
                    <thead>
                    <tr>
                        <th>name</th>
                        <th class="has-text-centered">primary</th>
                        <th>coverage area</th>
                        <th class="has-text-centered" style="display: none;">public</th>
                        <th class="has-text-centered" style="display: none;">disabled</th>
                        <th>actions</th>
                    </tr>
                    </thead>
                @endif

                @if($bottom_column_headings)
                    <tfoot>
                    <tr>
                        <th>name</th>
                        <th class="has-text-centered">primary</th>
                        <th>coverage area</th>
                        <th class="has-text-centered" style="display: none;">public</th>
                        <th class="has-text-centered" style="display: none;">disabled</th>
                        <th>actions</th>
                    </tr>
                    </tfoot>
                @endif

                <tbody>

                @forelse ($jobBoards as $jobBoard)

                    <tr data-id="{{ $jobBoard->id }}">
                        <td data-field="name" style="white-space: nowrap;">
                            {!! $jobBoard->name !!}
                        </td>
                        <td data-field="primary" class="has-text-centered">
                            @include('admin.components.checkmark', [ 'checked' => $jobBoard->primary ])
                        </td>
                        <td data-field="international|national|regional|local" style="white-space: nowrap;">
                            {!! implode(', ', $jobBoard->coverageAreas ?? []) !!}
                        </td>
                        <td data-field="is_public" class="has-text-centered" style="display: none;">
                            @include('admin.components.checkmark', [ 'checked' => $jobBoard->is_public ])
                        </td>
                        <td data-field="is_disabled" class="has-text-centered" style="display: none;">
                            @include('admin.components.checkmark', [ 'checked' => $jobBoard->is_disabled ])
                        </td>
                        <td class="is-1">

                            <div class="action-button-panel">

                                @if(canRead($jobBoard, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'show',
                                        'href'  => route('admin.career.job-board.show', $jobBoard),
                                        'icon'  => 'fa-list'
                                    ])
                                @endif

                                @if(canUpdate($jobBoard, $admin))
                                    @include('admin.components.link-icon', [
                                        'title' => 'edit',
                                        'href'  => route('admin.career.job-board.edit', $jobBoard),
                                        'icon'  => 'fa-pen-to-square'
                                    ])
                                @endif

                                @if (!empty($jobBoard->link))
                                    @include('admin.components.link-icon', [
                                        'title'  => !empty($jobBoard->link_name) ? $jobBoard->link_name : 'link',
                                        'href'   => $jobBoard->link,
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

                                @if(canDelete($jobBoard, $admin))
                                    <form class="delete-resource" action="{!! route('admin.career.job-board.destroy', $jobBoard) !!}" method="POST">
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
                        <td colspan="6">No job boards found.</td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            @if(!empty($pagination_bottom))
                {!! $jobBoards->links('vendor.pagination.bulma') !!}
            @endif

        </div>

    </div>

@endsection
