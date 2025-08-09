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
                        <h3 class="card-header ml-3">Edit Reading</h3>
                        <div class="container mx-auto flex flex-col flex-auto items-center justify-center min-w-0">
                            <div class="card min-w-[320px] md:min-w-[450px] card-shadow" role="presentation">
                                <div class="card-body md:p-5">
                                    <div class="text-center">
                                        <div class="mb-4">

                                            <div class="d-grid gap-2 d-md-flex justify-between">

                                                <?php /* @include('admin.components.messages', [$errors]) */ ?>
                                                @if ($errors->any())
                                                    @include('admin.components.error-message', ['message'=>'Fix the indicated errors before saving.'])
                                                @else
                                                    <div></div>
                                                @endif

                                                <div>
                                                    <a class="btn btn-sm btn-solid"
                                                       href="{{ route('admin.reading.show', $reading) }}"><i
                                                            class="fa fa-list"></i> Show</a>
                                                    <a class="btn btn-sm btn-solid"
                                                       href="{{ route('admin.reading.index') }}"><i
                                                            class="fa fa-arrow-left"></i> Back</a>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="form-container">

                                            <form action="{{ route('admin.reading.update', $reading) }}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                @include('admin.components.form-hidden', [
                                                    'name'  => old('admin_id') ?? Auth::guard('admin')->user()->id,
                                                    'value' => '0',
                                                ])

                                                @include('admin.components.form-input', [
                                                    'name'        => 'title',
                                                    'value'       => old('title') ?? $reading->title,
                                                    'required'    => true,
                                                    'maxlength'   => 255,
                                                    'message'     => $message ?? '',
                                                ])

                                                @include('admin.components.form-input', [
                                                    'name'        => 'author',
                                                    'value'       => old('author') ?? $reading->author,
                                                    'required'    => true,
                                                    'maxlength'   => 255,
                                                    'message'     => $message ?? '',
                                                ])

                                                @include('admin.components.form-checkbox', [
                                                    'name'            => 'paper',
                                                    'value'           => 1,
                                                    'unchecked_value' => 0,
                                                    'checked'         => old('paper') ?? $reading->paper,
                                                    'message'         => $message ?? '',
                                                ])

                                                @include('admin.components.form-checkbox', [
                                                    'name'            => 'audio',
                                                    'value'           => 1,
                                                    'unchecked_value' => 0,
                                                    'checked'         => old('audio') ?? $reading->audio,
                                                    'message'         => $message ?? '',
                                                ])

                                                @include('admin.components.form-checkbox', [
                                                    'name'            => 'wishlist',
                                                    'value'           => 1,
                                                    'unchecked_value' => 0,
                                                    'checked'         => old('wishlist') ?? $reading->disabled,
                                                    'message'         => $message ?? '',
                                                ])

                                                @include('admin.components.form-input', [
                                                    'name'        => 'link',
                                                    'value'       => old('link') ?? $reading->link,
                                                    'maxlength'   => 255,
                                                    'message'     => $message ?? '',
                                                ])

                                                @include('admin.components.form-input', [
                                                    'name'        => 'link name',
                                                    'value'       => old('link_name') ?? $reading->link_name,
                                                    'maxlength'   => 255,
                                                    'message'     => $message ?? '',
                                                ])

                                                @include('admin.components.form-textarea', [
                                                    'name'    => 'notes',
                                                    'id'      => 'inputEditor',
                                                    'value'   => old('description') ?? $reading->notes,
                                                    'message' => $message ?? '',
                                                ])

                                                @include('admin.components.form-input', [
                                                    'type'        => 'number',
                                                    'name'        => 'sequence',
                                                    'value'       => old('sequence') ?? $reading->sequence,
                                                    'min'         => 0,
                                                    'message'     => $message ?? '',
                                                ])

                                                @include('admin.components.form-checkbox', [
                                                    'name'            => 'public',
                                                    'value'           => 1,
                                                    'unchecked_value' => 0,
                                                    'checked'         => old('public') ?? $reading->public,
                                                    'message'         => $message ?? '',
                                                ])

                                                @include('admin.components.form-checkbox', [
                                                    'name'            => 'disabled',
                                                    'value'           => 1,
                                                    'unchecked_value' => 0,
                                                    'checked'         => old('disabled') ?? $reading->disabled,
                                                    'message'         => $message ?? '',
                                                ])

                                                @include('admin.components.form-button-submit', [
                                                    'label'      => 'Save',
                                                    'cancel_url' => route('admin.reading.index')
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
