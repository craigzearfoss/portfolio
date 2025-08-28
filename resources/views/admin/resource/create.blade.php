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
                        <h3 class="card-header ml-3">Add Resource</h3>
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
                                                       href="{{ route('admin.resource.index') }}"><i
                                                            class="fa fa-arrow-left"></i> Back</a>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="form-container">

                                            <form action="{{ route('admin.resource.store') }}" method="POST">
                                                @csrf

                                                @include('admin.components.form-hidden', [
                                                    'name'  => Auth::guard('admin')->user()->id,
                                                    'value' => '0',
                                                ])

                                                @include('admin.components.form-input', [
                                                    'name'      => 'type',
                                                    'value'     => old('type') ?? '',
                                                    'required'  => true,
                                                    'maxlength' => 50,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-input', [
                                                    'name'      => 'name',
                                                    'value'     => old('name') ?? '',
                                                    'maxlength' => 50,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-input', [
                                                    'name'      => 'plural',
                                                    'value'     => old('plural') ?? '',
                                                    'maxlength' => 50,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-input', [
                                                    'name'      => 'section',
                                                    'value'     => old('section') ?? '',
                                                    'maxlength' => 50,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-input', [
                                                    'name'      => 'icon',
                                                    'value'     => old('icon') ?? '',
                                                    'maxlength' => 50,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-select', [
                                                    'name'     => 'resource_database_id',
                                                    'label'    => 'database',
                                                    'value'    => old('resource_database_id') ?? '',
                                                    'required' => true,
                                                    'list'     => \App\Models\Database::listOptions(false),
                                                    'message'  => $message ?? '',
                                                ])

                                                @include('admin.components.form-input', [
                                                    'type'        => 'number',
                                                    'name'        => 'sequence',
                                                    'value'       => old('sequence') ?? 0,
                                                    'min'         => 0,
                                                    'message'     => $message ?? '',
                                                ])

                                                @include('admin.components.form-checkbox', [
                                                    'name'            => 'public',
                                                    'value'           => 1,
                                                    'unchecked_value' => 0,
                                                    'checked'         => old('public') ?? 0,
                                                    'message'         => $message ?? '',
                                                ])

                                                @include('admin.components.form-checkbox', [
                                                    'name'            => 'disabled',
                                                    'value'           => 1,
                                                    'unchecked_value' => 0,
                                                    'checked'         => old('disabled') ?? 0,
                                                    'message'         => $message ?? '',
                                                ])

                                                @include('admin.components.form-button-submit', [
                                                    'label'      => 'Save',
                                                    'cancel_url' => route('admin.resource.index')
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
