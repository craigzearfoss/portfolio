@php
    $buttons = [];
    if (canCreate('message', currentAdminId())) {
        $buttons[] = [ 'name' => '<i class="fa fa-plus"></i> Add New Message', 'href' => route('admin.system.message.create') ];
    }
@endphp
@extends('admin.layouts.default', [
    'title'         => 'Message',
    'breadcrumbs'   => [
        [ 'name' => 'Home',            'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'System',          'href' => route('admin.system.index') ],
        [ 'name' => 'Messages' ],
    ],
    'buttons'       => $buttons,
    'errorMessages' => $errors->any() ?? [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => Auth::guard('admin')->user(),
])

@section('content')

    <div class="card p-4">

        <table class="table is-bordered is-striped is-narrow is-hoverable mb-2">
            <thead>
            <tr>
                <th>name</th>
                <th>email</th>
                <th>subject</th>
                <th>created at</th>
                <th>actions</th>
            </tr>
            </thead>
            <?php /*
            <tfoot>
            <tr>
                <th>name</th>
                <th>email</th>
                <th>subject</th>
                <th>created at</th>
                <th>actions</th>
            </tr>
            </tfoot>
            */ ?>
            <tbody>

            @forelse ($messages as $message)

                <tr data-id="{{ $message->id }}">
                    <td data-field="name">
                        {!! $message->name !!}
                    </td>
                    <td data-field="email">
                        {!! $message->email !!}
                    </td>
                    <td data-field="subject">
                        {!! $message->subject !!}
                    </td>
                    <td data-field="created_at">
                        {{ shortDateTime($message->created_at) }}
                    </td>
                    <td style="white-space: nowrap;">

                        @if(canRead($art))
                            @include('admin.components.link-icon', [
                                'title' => 'show',
                                'href'  => route('admin.system.message.show', $message->id),
                                'icon'  => 'fa-list'
                            ])
                        @endif

                        @if(canUpdate($message))
                            @include('admin.components.link-icon', [
                                'title' => 'edit',
                                'href'  => route('admin.system.message.edit', $message->id),
                                'icon'  => 'fa-pen-to-square'
                            ])
                        @endif

                        @if(canDelete($message))
                            @csrf
                            @method('DELETE')
                            @include('admin.components.button-icon', [
                                'title' => 'delete',
                                'class' => 'delete-btn',
                                'icon'  => 'fa-trash'
                            ])
                        @endif

                        @if(canDelete($message))
                            <form action="{!! route('admin.system.message.destroy', $message->id) !!}"
                                  method="POST"
                                  style="display: inline-block;"
                            >
                                @csrf
                                @method('DELETE')
                                @include('admin.components.button-icon', [
                                    'title' => 'delete',
                                    'class' => 'delete-btn',
                                    'icon'  => 'fa-trash'
                                ])
                            </form>
                        @endif

                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="5">There are no messages.</td>
                </tr>

            @endforelse

            </tbody>
        </table>

        {!! $messages->links('vendor.pagination.bulma') !!}

    </div>

@endsection
