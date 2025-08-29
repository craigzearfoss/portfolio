@extends('admin.layouts.default', [
    'title' =>'Add New Application',
    'breadcrumbs' => [
        [ 'name' => 'Admin Dashboard', 'url' => route('admin.dashboard') ],
        [ 'name' => 'Career',          'url' => route('admin.career.index') ],
        [ 'name' => 'Applications',    'url' => route('admin.career.application.index') ],
        [ 'name' => 'Create' ],
    ],
    'buttons' => [
        [ 'name' => '<i class="fa fa-arrow-left"></i> Back', 'url' => route('admin.career.application.index') ],
    ],
    'errors' => $errors ?? [],
])

@section('content')

    <div class="form">

        <form action="{{ route('admin.career.application.store') }}" method="POST">
            @csrf

            @include('admin.components.form-hidden', [
                'name'  => Auth::guard('admin')->user()->id,
                'value' => '0',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'        => 'role',
                'value'       => old('role') ?? '',
                'required'    => true,
                'maxlength'   => 255,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'    => 'company',
                'value'   => old('company_id') ?? '',
                'list'    => \App\Models\Career\Company::listOptions(true),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'        => 'number',
                'name'        => 'rating',
                'value'       => old('rating') ?? 0,
                'placeholder' => "0, 1, 2, 3, or 4",
                'min'         => 1,
                'max'         => 4,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'active',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('active') ?? 1,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'    => 'date',
                'label'   => 'post date',
                'name'    => 'post_date',
                'value'   => old('post_date') ?? null,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'    => 'date',
                'label'   => 'apply date',
                'name'    => 'apply_date',
                'value'   => old('apply_date') ?? null,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'    => 'date',
                'label'   => 'close date',
                'name'    => 'close_date',
                'value'   => old('close_date') ?? null,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'    => 'number',
                'name'    => 'compensation',
                'value'   => old('compensation') ?? 0,
                'min'     => 0,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'label'   => 'compensation unit',
                'name'    => 'compensation_unit',
                'value'   => old('compensation_unit') ?? '',
                'list'    => \App\Models\Career\Application::compensationUnitListOptions(true, true),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'duration',
                'value'     => old('duration') ?? 0,
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'    => 'type',
                'value'   => old('type') ?? 'permanent' ,
                'list'    => \App\Models\Career\Application::typeListOptions(),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'    => 'office',
                'value'   => old('office') ?? 'onsite',
                'list'    => \App\Models\Career\Application::officeListOptions(),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'city',
                'value'     => old('city') ?? '',
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'    => 'state',
                'value'   => old('state') ?? '',
                'list'    => \App\Models\State::listOptions(true),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'bonus',
                'value'     => old('bonus') ?? '',
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'w2',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('w2') ?? 0,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'relocation',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('relocation') ?? 0,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'benefits',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('benefits') ?? 0,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'vacation',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('vacation') ?? 0,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'health',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('health') ?? 0,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-select-horizontal', [
                'name'    => 'source',
                'value'   => old('source') ?? '',
                'list'    => \App\Models\Career\JobBoard::listOptions(true, true),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'link',
                'value'     => old('link') ?? '',
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'label'     => 'contact(s)',
                'name'      => 'contacts',
                'value'     => old('contacts') ?? '',
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'label'     => 'phone(s)',
                'name'      => 'phones',
                'value'     => old('phones') ?? '',
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'label'     => 'email(s)',
                'name'      => 'emails',
                'value'     => old('emails') ?? '',
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'website',
                'value'     => old('website') ?? '',
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'description',
                'id'      => 'inputEditor',
                'value'   => old('description') ?? '',
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'        => 'number',
                'name'        => 'sequence',
                'value'       => old('sequence') ?? 0,
                'min'         => 0,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'public',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('public') ?? 0,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-checkbox-horizontal', [
                'name'            => 'disabled',
                'value'           => 1,
                'unchecked_value' => 0,
                'checked'         => old('disabled') ?? 0,
                'message'         => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Add Application',
                'cancel_url' => route('admin.career.application.index')
            ])

        </form>

    </div>

@endsection
