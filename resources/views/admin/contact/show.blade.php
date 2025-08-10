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
                        <h3 class="card-header ml-3">Show Contact</h3>
                        <div class="container mx-auto flex flex-col flex-auto items-center justify-center min-w-0">
                            <div class="card min-w-[320px] md:min-w-[450px] max-w-[800px] card-shadow" role="presentation">
                                <div class="card-body md:p-5">

                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <a class="btn btn-solid btn-sm" href="{{ route('admin.contact.edit', $contact) }}"><i class="fa fa-pen-to-square"></i> Edit</a>
                                        <a class="btn btn-solid btn-sm" href="{{ route('admin.contact.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
                                    </div>

                                    <div class="row">

                                        @include('admin.components.show-row', [
                                            'name'  => 'name',
                                            'value' => $contact->name
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'slug',
                                            'value' => $contact->slug
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'title',
                                            'value' => $contact->title
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'street',
                                            'value' => $contact->street
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'street2',
                                            'value' => $contact->street2
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'city',
                                            'value' => $contact->city
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'state',
                                            'value' => \App\Models\State::getName($contact->state)
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'zip',
                                            'value' => $contact->zip
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'country',
                                            'value' => \App\Models\Country::getName($contact->country)
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => !empty($contact->phone_label) ? $contact->phone_label : 'phone',
                                            'value' => $contact->phone
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => !empty($contact->alt_phone_label) ? $contact->alt_phone_label : 'alt phone',
                                            'value' => $contact->alt_phone
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => !empty($contact->email_label) ? $contact->email_label : 'email',
                                            'value' => $contact->email
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => !empty($contact->alt_email_label) ? $contact->alt_email_label : 'alt email',
                                            'value' => $contact->alt_email
                                        ])

                                        @include('admin.components.show-row-link', [
                                            'name'  => 'website',
                                            'url'    => $contact->website,
                                            'target' => '_blank'
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'description',
                                            'value' => $contact->description
                                        ])

                                        @include('admin.components.show-row-checkbox', [
                                            'name'    => 'public',
                                            'checked' => $contact->public
                                        ])

                                        @include('admin.components.show-row-checkbox', [
                                            'name'    => 'disabled',
                                            'checked' => $contact->disabled
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'owner',
                                            'value' => $contact->admin['username'] ?? ''
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'created at',
                                            'value' => longDateTime($contact->created_at)
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'updated at',
                                            'value' => longDateTime($contact->updated_at)
                                        ])

                                        @include('admin.components.show-row', [
                                            'name'  => 'deleted at',
                                            'value' => longDateTime($contact->deleted_at)
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
