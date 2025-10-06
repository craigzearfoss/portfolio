@extends('admin.layouts.default', [
    'title' => 'Add Resource',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
        [ 'name' => 'Resources',       'href' => route('admin.resource.index') ],
        [ 'name' => 'Add' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'href' => referer('admin.resource.index') ],
    ],
    'errorMessages' => $errors->any() ? ['Fix the indicated errors before saving.'] : [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.resource.store') }}" method="POST">
            @csrf

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.resource.index')
            ])

            @if(isRootAdmin())
                @include('admin.components.form-select-horizontal', [
                    'name'     => 'owner_id',
                    'label'    => 'owner',
                    'value'    => old('owner_id') ?? '',
                    'required' => true,
                    'list'     => \App\Models\Owner::listOptions(
                        ['root' => 1], 'id', 'username', true, false, ['username', 'asc']
                    ),
                    'message'  => $message ?? '',
                ])
            @endif

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? '',
                'unique'    => true,
                'maxlength' => 50,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'     => 'resource_database_id',
                'label'    => 'database',
                'value'    => old('resource_database_id') ?? '',
                'required' => true,
                'list'     => \App\Models\Database::listOptions([], true),
                'message'  => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'table',
                'value'     => old('table') ?? '',
                'required'  => true,
                'maxlength' => 50,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'title',
                'value'     => old('title') ?? '',
                'required'  => true,
                'maxlength' => 50,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'plural',
                'value'     => old('plural') ?? '',
                'maxlength' => 50,
                'message'   => $message ?? '',
            ])

            <div class="field is-horizontal">
                <div class="field-label is-normal">
                </div>
                <div class="field-body">
                    <div class="field">

                        <div class="checkbox-container card form-container p-4">

                            @include('admin.components.form-checkbox', [
                                'name'            => 'guest',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('guest') ?? 0,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'user',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('user') ?? 0,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'admin',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('admin') ?? 0,
                                'message'         => $message ?? '',
                            ])

                        </div>

                    </div>
                </div>
            </div>

            @include('admin.components.form-input-horizontal', [
                'name'      => 'icon',
                'value'     => old('icon') ?? '',
                'maxlength' => 50,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'        => 'number',
                'name'        => 'sequence',
                'value'       => old('sequence') ?? 0,
                'min'         => 0,
                'message'     => $message ?? '',
            ])

            <div class="field is-horizontal">
                <div class="field-label is-normal">
                </div>
                <div class="field-body">
                    <div class="field">

                        <div class="checkbox-container card form-container p-4">

                            @include('admin.components.form-checkbox', [
                                'name'            => 'public',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('public') ?? 0,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'readonly',
                                'label'           => 'read-only',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('readonly') ?? 0,
                                'message'         => $message ?? '',
                            ])

                            @if(isRootAdmin())
                                @include('admin.components.form-checkbox', [
                                    'name'            => 'root',
                                    'value'           => 1,
                                    'unchecked_value' => 0,
                                    'checked'         => old('root') ?? 0,
                                    'disabled'        => 0,
                                    'message'         => $message ?? '',
                                ])
                            @endif

                            @include('admin.components.form-checkbox', [
                                'name'            => 'disabled',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('disabled') ?? 0,
                                'message'         => $message ?? '',
                            ])

                        </div>

                    </div>
                </div>
            </div>

            @include('admin.components.form-button-submit', [
                'label'      => 'Add Resource',
                'cancel_url' => referer('admin.resource.index')
            ])

        </form>

    </div>

@endsection
