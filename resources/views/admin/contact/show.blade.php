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
                                        <a class="btn btn-solid btn-sm" href="{{ route('admin.contact.edit', $contact) }}"><i class="fa fa-pen-to-square"></i> Edit</a>                                        <a class="btn btn-solid btn-sm" href="{{ route('admin.contact.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2"><strong>name</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    @if (!empty($contact->title))
                                                        {{ $contact->title }} {{ $user->name }}
                                                    @else
                                                        {{ $contact->name }}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2"><strong>street</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    {{ $contact->street }}@if ($contact->street2), {{ $contact->street2 }}@endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2"><strong>location</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    @if ($contact->city)
                                                        {{ $contact->city }}@if ($contact->state), {{ $contact->state }}@endif
                                                    @else
                                                        {{ $contact->state }}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2"><strong>zip</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    {{ $contact->zip }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2"><strong>country</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    {{ $contact->country }}
                                                </div>
                                            </div>
                                        </div>
                                        @if (!empty($contact->phone))
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="row">
                                                    <div class="col-2"><strong>{{ $contact->phone_label ?? 'phone '}}</strong>:</div>
                                                    <div class="col-10 pl-0">
                                                        {{ $contact->phone }}
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if (!empty($contact->alt_phone))
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="row">
                                                    <div class="col-2"><strong>{{ $contact->alt_phone_label ?? 'alt phone '}}</strong>:</div>
                                                    <div class="col-10 pl-0">
                                                        {{ $contact->alt_phone }}
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if (!empty($contact->email))
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="row">
                                                    <div class="col-2"><strong>{{ $contact->email_label ?? 'email' }}</strong>:</div>
                                                    <div class="col-10 pl-0">
                                                        {{ $contact->email }}
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if (!empty($contact->alt_email))
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="row">
                                                    <div class="col-2"><strong>{{ $contact->alt_email_label ?? 'alt email' }}</strong>:</div>
                                                    <div class="col-10 pl-0">
                                                        {{ $contact->alt_email }}
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2"><strong>website</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    @include('user.components.link', [ 'url' => $contact->website, 'target' => '_blank' ])
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2"><strong>description</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    {!! $contact->description !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2"><strong>disabled</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    @include('admin.components.checkmark', [ 'checked' => $contact->disabled ])
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2 text-nowrap"><strong>created at</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    {{ longDateTime($contact->created_at) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2 text-nowrap"><strong>updated at</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    {{ longDateTime($contact->updated_at) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2 text-nowrap"><strong>deleted at</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    {{ longDateTime($contact->deleted_at) }}
                                                </div>
                                            </div>
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
