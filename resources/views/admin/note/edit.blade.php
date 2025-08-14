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
                        <h3 class="card-header ml-3">Edit Note</h3>
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
                                                       href="{{ route('admin.note.show', $note) }}"><i
                                                            class="fa fa-list"></i> Show</a>
                                                    <a class="btn btn-sm btn-solid"
                                                       href="{{ route('admin.note.index') }}"><i
                                                            class="fa fa-arrow-left"></i> Back</a>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="form-container">

                                            <form action="{{ route('admin.note.update', $note->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                @include('admin.components.form-hidden', [
                                                    'name'  => old('admin_id') ?? Auth::guard('admin')->user()->id,
                                                    'value' => '0',
                                                ])

                                                @include('admin.components.form-input', [
                                                    'name'        => 'subject',
                                                    'value'       => old('subject') ?? $note->subject,
                                                    'required'    => true,
                                                    'maxlength'   => 255,
                                                    'message'     => $message ?? '',
                                                ])

                                                @include('admin.components.form-textarea', [
                                                    'name'    => 'body',
                                                    'id'      => 'inputEditor',
                                                    'value'   => old('body') ?? $note->body,
                                                    'message' => $message ?? '',
                                                ])

                                                @include('admin.components.form-button-submit', [
                                                    'label'      => 'Save',
                                                    'cancel_url' => route('admin.note.index')
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
