@extends('admin.layouts.default')

@section('content')

    <div class="app-layout-modern flex flex-auto flex-col">
        <div class="flex flex-auto min-w-0">

            @include('admin.components.nav-left')

            <div class="flex flex-col flex-auto min-h-screen min-w-0 relative w-full bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700">

                @include('admin.components.header')

                @include('admin.components.popup')

                <div class="page-container relative h-full flex flex-auto flex-col">
                    <div class="h-full">
                        <h3 class="card-header ml-3">Show Certificate</h3>
                        <div class="container mx-auto flex flex-col flex-auto items-center justify-center min-w-0">
                            <div class="card min-w-[320px] md:min-w-[450px] max-w-[800px] card-shadow" role="presentation">
                                <div class="card-body md:p-5">

                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <a class="btn btn-solid btn-sm" href="{{ route('admin.certificate.edit', $certificate) }}"><i class="fa fa-pen-to-square"></i> Edit</a>                                        <a class="btn btn-solid btn-sm" href="{{ route('admin.certificate.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
                                    </div>

                                    <div class="row">

                                        @include('admin.components.show-row', [
                                            'name'  => 'name',
                                            'value' => $certificate->name
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'name',
                                            'value' => $certificate->slug
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'organization',
                                            'value' => $certificate->organization
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'received',
                                            'value' => longDate($certificate->received)
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'expiration',
                                            'value' => longDate($certificate->expiration)
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'year',
                                            'value' => $certificate->year
                                        ])

                                        @include('admin.components.show-row-checkbox', [
                                            'name'    => 'professional',
                                            'checked' => $certificate->professional
                                        ])

                                        @include('admin.components.show-row-checkbox', [
                                            'name'    => 'personal',
                                            'checked' => $certificate->personal
                                        ])

                                        @include('admin.components.show-row-link', [
                                            'name'   => 'link',
                                            'url'    => $certificate->link,
                                            'target' => '_blank'
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'description',
                                            'value' => $certificate->description
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'sequence',
                                            'value' => $certificate->sequence
                                        ])

                                        @include('admin.components.show-row-checkbox', [
                                            'name'    => 'public',
                                            'checked' => $certificate->public
                                        ])

                                        @include('admin.components.show-row-checkbox', [
                                            'name'    => 'disabled',
                                            'checked' => $certificate->disabled
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'owner',
                                            'value' => $certificate->admin['username'] ?? ''
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'created at',
                                            'value' => longDateTime($certificate->created_at)
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'updated at',
                                            'value' => longDateTime($certificate->updated_at)
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'deleted at',
                                            'value' => longDateTime($certificate->deleted_at)
                                        ])

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
