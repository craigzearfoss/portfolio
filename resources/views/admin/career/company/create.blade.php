@extends('admin.layouts.default')

@section('content')

    <div class="app-layout-modern flex flex-auto flex-col">
        <div class="flex flex-auto min-w-0">

            @include('admin.components.nav-left_ORIGINAL')

            <div
                    class="flex flex-col flex-auto min-h-screen min-w-0 relative w-full bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700">

                @include('admin.components.header')

                @include('admin.components.popup')

                <div class="page-container relative h-full flex flex-auto flex-col">
                    <div class="h-full">
                        <h3 class="card-header ml-3">Add Company</h3>
                        <div class="container mx-auto flex flex-col flex-auto items-center justify-center min-w-0">
                            <div class="card min-w-[320px] md:min-w-[450px] card-shadow" role="presentation">
                                <div class="card-body md:p-5">
                                    <div class="text-center">
                                        <div class="mb-4">

                                            <div class="d-grid gap-2 d-md-flex justify-between">

                                                @if (session('success'))
                                                    @include('admin.components.message-success', ['message'=> session('success')])
                                                @endif

                                                @if (session('error'))
                                                    @include('admin.components.message-success', ['message'=> session('danger')])
                                                @endif

                                                @if ($errors->any())
                                                    @include('admin.components.error-message', ['message'=>'Fix the indicated errors before saving.'])
                                                @endif

                                                <div>
                                                    <a class="btn btn-sm btn-solid"
                                                       href="{{ route('admin.career.company.index') }}"><i
                                                                class="fa fa-arrow-left"></i> Back</a>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="form-container">

                                            <form action="{{ route('admin.career.company.store') }}" method="POST">
                                                @csrf

                                                @include('admin.components.form-hidden', [
                                                    'name'  => Auth::guard('admin')->user()->id,
                                                    'value' => '0',
                                                ])

                                                @include('admin.components.form-input-horizontal', [
                                                    'name'      => 'name',
                                                    'value'     => old('name') ?? '',
                                                    'required'  => true,
                                                    'maxlength' => 255,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-input-horizontal', [
                                                    'name'      => 'slug',
                                                    'value'     => old('slug') ?? '',
                                                    'required'  => true,
                                                    'maxlength' => 255,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-select-horizontal', [
                                                    'name'    => 'industry_id',
                                                    'label'   => 'industry',
                                                    'value'   => old('industry_id') ?? 0,
                                                    'list'    => \App\Models\Career\Industry::listOptions(false),
                                                    'message' => $message ?? '',
                                                ])

                                                @include('admin.components.form-input-horizontal', [
                                                    'name'      => 'street',
                                                    'value'     => old('street') ?? '',
                                                    'maxlength' => 255,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-input-horizontal', [
                                                    'name'      => 'street2',
                                                    'value'     => old('street2') ?? '',
                                                    'maxlength' => 255,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-input-horizontal', [
                                                    'name'      => 'city',
                                                    'value'     => old('city') ?? '',
                                                    'maxlength' => 255,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-select-horizontal', [
                                                    'name'    => 'state',
                                                    'value'   => old('state') ?? '',
                                                    'list'    => \App\Models\State::listOptions(true, true),
                                                    'message' => $message ?? '',
                                                ])

                                                @include('admin.components.form-input-horizontal', [
                                                    'name'      => 'zip',
                                                    'value'     => old('zip') ?? '',
                                                    'maxlength' => 20,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-select-horizontal', [
                                                    'name'    => 'country',
                                                    'value'   => old('country') ?? '',
                                                    'list'    => \App\Models\Country::listOptions(true, true),
                                                    'message' => $message ?? '',
                                                ])

                                                @include('admin.components.form-input-horizontal', [
                                                    'name'      => 'phone',
                                                    'value'     => old('phone') ?? '',
                                                    'maxlength' => 20,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-input-horizontal', [
                                                    'name'      => 'phone_label',
                                                    'label'     => 'phone label',
                                                    'value'     => old('phone_label') ?? '',
                                                    'maxlength' => 255,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-input-horizontal', [
                                                    'name'      => 'alt_phone',
                                                    'label'     => 'alt phone',
                                                    'value'     => old('alt_phone') ?? '',
                                                    'maxlength' => 20,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-input-horizontal', [
                                                    'name'      => 'alt_phone_label',
                                                    'label'     => 'alt phone label',
                                                    'value'     => old('alt_phone_label') ?? '',
                                                    'maxlength' => 255,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-input-horizontal', [
                                                    'name'      => 'email',
                                                    'value'     => old('email') ?? '',
                                                    'maxlength' => 20,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-input-horizontal', [
                                                    'name'      => 'email_label',
                                                    'label'     => 'email label',
                                                    'value'     => old('email_label') ?? '',
                                                    'maxlength' => 255,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-input-horizontal', [
                                                    'name'      => 'alt_email',
                                                    'label'     => 'alt email',
                                                    'value'     => old('alt_email') ?? '',
                                                    'maxlength' => 20,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-input-horizontal', [
                                                    'name'      => 'alt_email_label',
                                                    'label'     => 'alt email label',
                                                    'value'     => old('alt_email_label') ?? '',
                                                    'maxlength' => 255,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-input-horizontal', [
                                                    'name'      => 'link',
                                                    'value'     => old('link') ?? '',
                                                    'maxlength' => 255,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-input-horizontal', [
                                                    'name'      => 'link_name',
                                                    'label'     => 'link name',
                                                    'value'     => old('link_name') ?? '',
                                                    'maxlength' => 255,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-textarea-horizontal', [
                                                    'name'    => 'description',
                                                    'id'      => 'inputEditor',
                                                    'value'   => old('description') ?? '',
                                                    'message' => $message ?? '',
                                                ])

                                                @include('admin.components.form-file-upload-horizontal', [
                                                    'name'    => 'image',
                                                    'value'   => old('image') ?? '',
                                                    'message' => $message ?? '',
                                                ])

                                                @include('admin.components.form-input-horizontal', [
                                                    'name'      => 'image_credit',
                                                    'label'     => 'image credit',
                                                    'value'     => old('image_credit') ?? '',
                                                    'maxlength' => 255,
                                                    'message'   => $message ?? '',
                                    ``          ])

                                                @include('admin.components.form-input-horizontal', [
                                                    'name'      => 'image_source',
                                                    'label'     => 'image source',
                                                    'value'     => old('image_source') ?? '',
                                                    'maxlength' => 255,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-file-upload-horizontal', [
                                                    'name'    => 'thumbnail',
                                                    'value'   => old('thumbnail') ?? '',
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
                                                    'name'            => 'readonly',
                                                    'label'           => 'read-only',
                                                    'value'           => 1,
                                                    'unchecked_value' => 0,
                                                    'checked'         => old('readonly') ?? 0,
                                                    'message'         => $message ?? '',
                                                ])

                                                @include('admin.components.form-checkbox-horizontal', [
                                                    'name'            => 'root',
                                                    'value'           => 1,
                                                    'unchecked_value' => 0,
                                                    'checked'         => old('root') ?? 0,
                                                    'disabled'        => !Auth::guard('admin')->user()->root,
                                                    'message'         => $message ?? '',
                                                ])

                                                @include('admin.components.form-checkbox-horizontal', [
                                                    'name'            => 'disabled',
                                                    'value'           => 1,
                                                    'unchecked_value' => 0,
                                                    'checked'         => old('disabled') ?? 0,
                                                    'message'         => $message ?? '',
                                                ])

                                                @include('admin.components.form-button-submit', [
                                                    'label'      => 'Save Company',
                                                    'cancel_url' => route('admin.career.company.index')
                                                ])

                                            </form>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @include('admin.components.footer')

                </div>
            </div>
        </div>
    </div>

@endsection
