@extends('admin.layouts.default', [
    'title' => $title ?? 'Edit Event',
    'breadcrumbs' => [
        [ 'name' => 'Home',                    'href' => route('system.index') ],
        [ 'name' => 'Admin Dashboard',         'href' => route('admin.dashboard') ],
        [ 'name' => 'Career',                  'href' => route('admin.career.index') ],
        [ 'name' => 'Applications',            'href' => route('admin.career.application.index') ],
        [ 'name' => $event->application->name, 'href' => route('admin.career.application.show', $event->application->id) ],
        [ 'name' => 'Events',                  'href' => route('admin.career.communication.index', ['application_id' => $event->application->id]) ],
        [ 'name' => 'Event' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.career.event.index') ],
    ],
    'errorMessages' => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.career.event.update', $event->id) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.career.event.index')
            ])

            @include('admin.components.form-text-horizontal', [
                'name'  => 'id',
                'value' => $event->id
            ])

            @if(isRootAdmin())
                @include('admin.components.form-select-horizontal', [
                    'name'     => 'owner_id',
                    'label'    => 'owner',
                    'value'    => old('owner_id') ?? $event->owner_id,
                    'required' => true,
                    'list'     => \App\Models\System\Owner::listOptions([], 'id', 'username', true, false, ['username', 'asc']),
                    'message'  => $message ?? '',
                ])
            @else
                @include('admin.components.form-hidden', [
                    'name'  => 'owner_id',
                    'value' => $event->owner_id
                ])
            @endif

            @include('admin.components.form-select-horizontal', [
                'name'    => 'application_id',
                'label'   => 'application',
                'value'   => old('application_id') ?? $event->application_id,
                'list'    => \App\Models\Career\Application::listOptions([], 'id', 'name', true),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? $event->name,
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'    => 'date',
                'name'    => 'date',
                'value'   => old('timestamp') ?? $event->date,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'    => 'time',
                'name'    => 'time',
                'value'   => old('time') ?? $event->time,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'location',
                'value'     => old('location') ?? $event->location,
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'link',
                'value'     => old('link') ?? $event->link,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'link_name',
                'label'     => 'link name',
                'value'     => old('link_name') ?? $event->link_name,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'text',
                'id'      => 'inputEditor',
                'value'   => old('text') ?? $event->text,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'    => 'number',
                'name'    => 'sequence',
                'value'   => old('sequence') ?? $event->sequence,
                'min'     => 0,
                'message' => $message ?? '',
            ])

            <div class="field is-horizontal">
                <div class="field-label is-normal">
                </div>
                <div class="field-body">
                    <div class="field" style="flex-grow: 0;">

                        <div class="checkbox-container card form-container p-4">

                            @include('admin.components.form-checkbox', [
                                'name'            => 'public',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('public') ?? $event->public,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'readonly',
                                'label'           => 'read-only',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('readonly') ?? $event->readonly,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'root',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('root') ?? $event->root,
                                'disabled'        => !isRootAdmin(),
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'disabled',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('disabled') ?? $event->disabled,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'demo',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('demo') ?? $event->demo,
                                'message'         => $message ?? '',
                            ])

                            <div style="display: inline-block; width: 10em;">
                                <label class="label" style="display: inline-block !important;">sequence</label>
                                <span class="control ">
                                    <input class="input"
                                           style="margin-top: -4px;"
                                           type="number"
                                           id="inputSequence"
                                           name="sequence"
                                           min="0"
                                           value="{{ old('sequence') ?? $event->sequence }}"
                                    >
                                </span>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => referer('admin.career.event.index')
            ])

        </form>

    </div>

@endsection
