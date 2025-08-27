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
                        <h3 class="card-header ml-3">Edit Dictionary Server</h3>
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
                                                       href="{{ route('admin.dictionary_server.show', $dictionaryServer) }}"><i
                                                                class="fa fa-list"></i> Show</a>
                                                    <a class="btn btn-sm btn-solid"
                                                       href="{{ route('admin.dictionary_server.index') }}"><i
                                                                class="fa fa-arrow-left"></i> Back</a>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="form-container">

                                            <form action="{{ route('admin.dictionary_server.update', $dictionaryServer) }}"
                                                  method="POST">
                                                @csrf
                                                @method('PUT')

                                                @include('admin.components.form-input', [
                                                    'name'      => 'full_name',
                                                    'value'     => old('full_name') ?? $dictionaryServer->full_name,
                                                    'required'  => true,
                                                    'maxlength' => 255,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-input', [
                                                    'name'      => 'name',
                                                    'value'     => old('name') ?? $dictionaryServer->name,
                                                    'required'  => true,
                                                    'maxlength' => 100,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-input', [
                                                    'name'      => 'slug',
                                                    'value'     => old('slug') ?? $dictionaryServer->slug,
                                                    'required'  => true,
                                                    'maxlength' => 100,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-input', [
                                                    'name'      => 'abbreviation',
                                                    'value'     => old('abbreviation') ?? $dictionaryServer->abbreviation,
                                                    'required'  => true,
                                                    'maxlength' => 100,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-input', [
                                                    'name'      => 'owner',
                                                    'value'     => old('owner') ?? $dictionaryServer->owner,
                                                    'required'  => true,
                                                    'maxlength' => 100,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-checkbox', [
                                                    'name'            => 'open_source',
                                                    'label'           => 'open source',
                                                    'value'           => 1,
                                                    'unchecked_value' => 0,
                                                    'checked'         => old('public') ?? $dictionaryServer->open_source,
                                                    'message'         => $message ?? '',
                                                ])

                                                @include('admin.components.form-checkbox', [
                                                    'name'            => 'proprietary',
                                                    'value'           => 1,
                                                    'unchecked_value' => 0,
                                                    'checked'         => old('proprietary') ?? $dictionaryServer->proprietary,
                                                    'message'         => $message ?? '',
                                                ])

                                                @include('admin.components.form-checkbox', [
                                                    'name'            => 'compiled',
                                                    'value'           => 1,
                                                    'unchecked_value' => 0,
                                                    'checked'         => old('compiled') ?? $dictionaryServer->compiled,
                                                    'message'         => $message ?? '',
                                                ])

                                                @include('admin.components.form-input', [
                                                    'name'      => 'website',
                                                    'value'     => old('website') ?? $dictionaryServer->website,
                                                    'required'  => true,
                                                    'maxlength' => 255,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-input', [
                                                    'name'      => 'wiki_page',
                                                    'label'     => 'wiki page',
                                                    'value'     => old('wiki_page') ?? $dictionaryServer->wiki_page,
                                                    'required'  => true,
                                                    'maxlength' => 255,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('admin.components.form-textarea', [
                                                    'name'    => 'description',
                                                    'id'      => 'inputEditor',
                                                    'value'   => old('description') ?? $dictionaryServer->description,
                                                    'message' => $message ?? '',
                                                ])

                                                @include('admin.components.form-button-submit', [
                                                    'label'      => 'Save',
                                                    'cancel_url' => route('admin.dictionary_server.index')
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
