@extends('admin.layouts.default')

@section('content')

    <div class="app-layout-modern flex flex-auto flex-col">
        <div class="flex flex-auto min-w-0">

            @include('admin.components.nav-left')

            <div
                class="flex flex-col flex-auto min-h-screen min-w-0 relative w-full bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700">

                @include('admin.components.header')

                @include('admin.components.popup')

                <div class="page-container relative h-full flex flex-auto flex-col">
                    <div class="h-full">
                        <h3 class="card-header ml-3">Add Course</h3>
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
                                                    <a class="btn btn-sm btn-solid" href="{{ route('admin.course.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="form-container">

                                            <form action="{{ route('admin.course.store') }}" method="POST">
                                                @csrf

                                                @include('admin.components.form-hidden', [
                                                    'name'  => Auth::guard('admin')->user()->id,
                                                    'value' => '0',
                                                ])

                                                @include('admin.components.form-input', [
                                                    'name'      => 'name',
                                                    'value'     => old('name') ?? '',
                                                    'required'  => true,
                                                    'maxlength' => 255,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-input', [
                                                    'name'      => 'slug',
                                                    'value'     => old('slug') ?? '',
                                                    'required'  => true,
                                                    'maxlength' => 255,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-input', [
                                                    'type'      => 'number',
                                                    'name'      => 'year',
                                                    'value'     => old('year') ?? date('Y'),
                                                    'min'       => 2000,
                                                    'max'       => date('Y'),
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-input', [
                                                    'type'      => 'date',
                                                    'name'      => 'completed',
                                                    'value'     => old('completed') ?? null,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-checkbox', [
                                                    'name'            => 'professional',
                                                    'value'           => 1,
                                                    'unchecked_value' => 0,
                                                    'checked'         => old('professional') ?? 0,
                                                    'message'         => $message ?? '',
                                                ])

                                                @include('admin.components.form-checkbox', [
                                                    'name'            => 'personal',
                                                    'value'           => 1,
                                                    'unchecked_value' => 0,
                                                    'checked'         => old('personal') ?? 0,
                                                    'message'         => $message ?? '',
                                                ])

                                                @include('admin.components.form-input', [
                                                    'name'      => 'academy',
                                                    'value'     => old('academy') ?? '',
                                                    'maxlength' => 255,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-input', [
                                                    'name'      => 'website',
                                                    'value'     => old('website') ?? '',
                                                    'maxlength' => 255,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-input', [
                                                    'name'      => 'instructor',
                                                    'value'     => old('instructor') ?? '',
                                                    'maxlength' => 255,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-input', [
                                                    'name'      => 'sponsor',
                                                    'value'     => old('sponsor') ?? '',
                                                    'maxlength' => 255,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-textarea', [
                                                    'name'    => 'description',
                                                    'id'      => 'inputEditor',
                                                    'value'   => old('description') ?? '',
                                                    'message' => $message ?? '',
                                                ])

                                                @include('admin.components.form-input', [
                                                    'name'      => 'link',
                                                    'value'     => old('link') ?? '',
                                                    'required'  => true,
                                                    'maxlength' => 255,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-input', [
                                                    'type'        => 'number',
                                                    'name'        => 'sequence',
                                                    'value'       => old('seq') ?? 0,
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
                                                    'cancel_url' => route('admin.course.index')
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
