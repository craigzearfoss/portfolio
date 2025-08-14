@extends('user.layouts.default')

@section('content')

    <div class="app-layout-modern flex flex-auto flex-col">
        <div class="flex flex-auto min-w-0">

            @include('user.components.nav-left')

            <div class="flex flex-col flex-auto min-h-screen min-w-0 relative w-full bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700">

                @include('user.components.header')

                @include('user.components.popup')

                <div class="page-container relative h-full flex flex-auto flex-col">
                    <div class="h-full">
                        <h3 class="card-header ml-3">My Profile</h3>
                        <div class="container mx-auto flex flex-col flex-auto items-center justify-center min-w-0">
                            <div class="card min-w-[320px] md:min-w-[450px] max-w-[800px] card-shadow" role="presentation">
                                <div class="card-body md:p-5">

                                    <div>
                                        @include('admin.components.messages', [$errors])
                                    </div>

                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <a class="btn btn-sm btn-solid" href="{{ route('user.change_password', $user->id) }}"><i class="fa fa-key"></i> Change Password</a>
                                        <a class="btn btn-solid btn-sm" href="{{ route('user.edit', $user) }}"><i class="fa fa-pen-to-square"></i> Edit</a>
                                    </div>

                                    <div class="row">

                                        @include('user.components.show-row', [
                                            'name'  => 'name',
                                            'value' => $user->name
                                        ])

                                        @include('user.components.show-row', [
                                            'name'  => 'title',
                                            'value' => $user->title
                                        ])

                                        @include('user.components.show-row', [
                                            'name'  => 'street',
                                            'value' => $user->street
                                        ])

                                        @include('user.components.show-row', [
                                            'name'  => 'street2',
                                            'value' => $user->street2
                                        ])

                                        @include('user.components.show-row', [
                                            'name'  => 'city',
                                            'value' => $user->city
                                        ])

                                        @include('user.components.show-row', [
                                            'name'  => 'state',
                                            'value' => \App\Models\State::getName($user->state)
                                        ])

                                        @include('user.components.show-row', [
                                            'name'  => 'zip',
                                            'value' => $user->zip
                                        ])

                                        @include('user.components.show-row', [
                                            'name'  => 'country',
                                            'value' => \App\Models\Country::getName($user->country)
                                        ])

                                        @include('user.components.show-row', [
                                            'name'  => 'phone',
                                            'value' => $user->phone
                                        ])

                                        @include('user.components.show-row', [
                                            'name'  => 'email',
                                            'value' => $user->email
                                        ])

                                        @include('user.components.show-row-link', [
                                            'name'   => 'website',
                                            'url'    => $user->website,
                                            'target' => '_blank'
                                        ])

                                        <?php /*
                                        @include('user.components.show-row', [
                                            'name'  => 'status',
                                            'value' => \App\Models\User::statusName($user->status)
                                        ])

                                        @include('user.components.show-row-checkbox', [
                                            'name'    => 'disabled',
                                            'checked' => $user->disabled
                                        ])
                                        */ ?>

                                        @include('user.components.show-row', [
                                            'name'  => 'email verified at',
                                            'value' => longDateTime($user->email_verified_at)
                                        ])

                                        @include('user.components.show-row', [
                                            'name'  => 'created at',
                                            'value' => longDateTime($user->created_at)
                                        ])

                                        @include('user.components.show-row', [
                                            'name'  => 'updated at',
                                            'value' => longDateTime($user->updated_at)
                                        ])

                                        <?php /*
                                        @include('user.components.show-row', [
                                            'name'  => 'deleted at',
                                            'value' => longDateTime($user->deleted_at)
                                        ])
                                        */ ?>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    @include('user.components.footer')

                </div>
            </div>
        </div>
    </div>

@endsection
