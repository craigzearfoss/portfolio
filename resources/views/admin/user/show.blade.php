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
                        <h3 class="card-header ml-3">Show User</h3>
                        <div class="container mx-auto flex flex-col flex-auto items-center justify-center min-w-0">
                            <div class="card min-w-[320px] md:min-w-[450px] max-w-[800px] card-shadow" role="presentation">
                                <div class="card-body md:p-5">

                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <a class="btn btn-solid btn-sm" href="{{ route('admin.user.edit', $user) }}"><i class="fa fa-pen-to-square"></i> Edit</a>
                                        <a class="btn btn-solid btn-sm" href="{{ route('admin.user.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2"><strong>name</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    @if (!empty($user->$title))
                                                        {{ $user->title }} {{ $user->name }}
                                                    @else
                                                        {{ $user->name }}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2"><strong>street</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    {{ $user->street }}@if ($user->street2), {{ $user->street2 }}@endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2"><strong>location</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    @if ($user->city)
                                                        {{ $user->city }}@if ($user->state), {{ $user->state }}@endif
                                                    @else
                                                        {{ $user->state }}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2"><strong>zip</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    {{ $user->zip }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2"><strong>country</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    {{ $user->country }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2"><strong>phone</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    {{ $user->phone }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2"><strong>email</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    {{ $user->email }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2"><strong>website</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    @include('user.components.link', [ 'url' => $user->website, 'target' => '_blank' ])
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2"><strong>status</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    {{ \App\Models\User::statusName($user->status) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2"><strong>disabled</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    @include('admin.components.checkmark', [ 'checked' => $user->disabled ])
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2 text-nowrap"><strong>email verified at</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    {{ longDateTime($user->email_verified_at) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2 text-nowrap"><strong>created at</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    {{ longDateTime($user->created_at) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2 text-nowrap"><strong>updated at</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    {{ longDateTime($user->updated_at) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="row">
                                                <div class="col-2 text-nowrap"><strong>deleted at</strong>:</div>
                                                <div class="col-10 pl-0">
                                                    {{ longDateTime($user->deleted_at) }}
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
