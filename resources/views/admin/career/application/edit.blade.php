@extends('admin.layouts.default', [
    'title' => 'Edit Application',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'url' => route('admin.career.index') ],
        [ 'name' => 'Applications',    'url' => route('admin.career.application.index') ],
        [ 'name' => 'Edit' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'url' => route('admin.career.application.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div class="form">

        <form action="{{ route('admin.career.application.update', $application) }}"
              method="POST">
            @csrf
            @method('PUT')

            @include('admin.components.form-hidden', [
                'name'  => old('admin_id') ?? Auth::guard('admin')->user()->id,
                'value' => '0',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'        => 'role',
                'value'       => old('role') ?? $application->role,
                'required'    => true,
                'maxlength'   => 255,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'        => 'number',
                'name'        => 'rating',
                'value'       => old('rating') ?? $application->rating,
                'placeholder' => "0, 1, 2, 3, or 4",
                'min'         => 1,
                'max'         => 4,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'active',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('active') ?? $application->active,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'    => 'date',
                'label'   => 'post date',
                'name'    => 'post_date',
                'value'   => old('post_date') ?? $application->post_date,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'    => 'date',
                'label'   => 'apply date',
                'name'    => 'apply_date',
                'value'   => old('apply_date') ?? $application->apply_date,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'    => 'date',
                'label'   => 'close date',
                'name'    => 'close_date',
                'value'   => old('close_date') ?? $application->close_date,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'    => 'number',
                'name'    => 'compensation',
                'value'   => old('compensation') ?? $application->compensation,
                'min'     => 0,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'label'   => 'compensation unit',
                'name'    => 'compensation_unit',
                'value'   => old('compensation_unit') ?? $application->compensation_unit,
                'list'    => \App\Models\Career\Application::compensationUnitListOptions(true, true),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'duration',
                'value'     => old('duration') ?? $application->duration,
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'    => 'type',
                'value'   => old('type') ?? $application->type,
                'list'    => \App\Models\Career\Application::typeListOptions(),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'    => 'office',
                'value'   => old('office') ?? $application->office,
                'list'    => \App\Models\Career\Application::officeListOptions(),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'city',
                'value'     => old('city') ?? $application->city,
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'    => 'state',
                'value'   => old('state') ?? $application->state,
                'list'    => \App\Models\State::listOptions(true),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'bonus',
                'value'     => old('bonus') ?? $application->bonus,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'w2',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('w2') ?? $application->w2,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'relocation',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('relocation') ?? $application->relocation,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'benefits',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('benefits') ?? $application->benefits,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'vacation',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('vacation') ?? $application->vacation,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'health',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('health') ?? $application->health,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'    => 'source',
                'value'   => old('source') ?? $application->source,
                'list'    => \App\Models\Career\JobBoard::listOptions(true, true),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'link',
                'value'     => old('link') ?? $application->link,
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'label'     => 'contact(s)',
                'name'      => 'contacts',
                'value'     => old('contacts') ?? $application->contacts,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'label'     => 'phone(s)',
                'name'      => 'phones',
                'value'     => old('phones') ?? $application->phones,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'label'     => 'email(s)',
                'name'      => 'emails',
                'value'     => old('emails') ?? $application->emails,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'website',
                'value'     => old('website') ?? $application->website,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? $application->description,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'        => 'number',
                'name'        => 'sequence',
                'value'       => old('sequence') ?? $application->sequence,
                'min'         => 0,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'public',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('public') ?? $application->public,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'disabled',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('disabled') ?? $application->disabled,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Save',
                'cancel_url' => route('admin.career.application.index')
            ])

        </form>

    </div>

@endsection
