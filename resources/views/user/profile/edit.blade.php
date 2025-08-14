@extends('user.layouts.default')

@section('content')

    <div class="app-layout-modern flex flex-auto flex-col">
        <div class="flex flex-auto min-w-0">

            @include('user.components.nav-left')

            <div
                class="flex flex-col flex-auto min-h-screen min-w-0 relative w-full bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700">

                @include('user.components.header')

                @include('user.components.popup')

                <div class="page-container relative h-full flex flex-auto flex-col">
                    <div class="h-full">
                        <h3 class="card-header ml-3">Edit My Profile</h3>
                        <div class="container mx-auto flex flex-col flex-auto items-center justify-center min-w-0">
                            <div class="card min-w-[320px] md:min-w-[450px] card-shadow" role="presentation">
                                <div class="card-body md:p-5">
                                    <div class="text-center">
                                        <div class="mb-4">

                                            <div class="d-grid gap-2 d-md-flex justify-between">

                                                @if ($errors->any())
                                                    @include('user.components.error-message', ['message'=>'Fix the indicated errors before saving.'])
                                                @else
                                                    <div></div>
                                                @endif

                                                <div>
                                                    <a class="btn btn-sm btn-solid" href="{{ route('user.change_password', $user->id) }}"><i class="fa fa-key"></i> Change Password</a>
                                                    <a class="btn btn-sm btn-solid" href="{{ route('user.show') }}"><i class="fa fa-arrow-left"></i> Back</a>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="form-container">

                                            <form action="{{ route('user.update') }}" method="POST">
                                                @csrf

                                                @include('user.components.form-hidden', [
                                                    'name'  => old('admin_id') ?? Auth::guard('web')->user()->id,
                                                    'value' => '0',
                                                ])

                                                @include('user.components.form-input', [
                                                    'name'      => 'name',
                                                    'value'     => old('name') ?? $user->name,
                                                    'required'  => true,
                                                    'minlength' => 6,
                                                    'maxlength' => 255,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('user.components.form-select', [
                                                    'name'    => 'title',
                                                    'value'   => old('title') ?? $user->title,
                                                    'list'    => \App\Models\User::titleListOptions(true, true),
                                                    'message' => $message ?? '',
                                                ])

                                                @include('user.components.form-input', [
                                                    'name'      => 'street',
                                                    'value'     => old('street') ?? $user->street,
                                                    'maxlength' => 255,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('user.components.form-input', [
                                                    'name'      => 'street2',
                                                    'value'     => old('street2') ?? $user->street2,
                                                    'maxlength' => 255,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('user.components.form-input', [
                                                    'name'      => 'city',
                                                    'value'     => old('city') ?? $user->city,
                                                    'maxlength' => 255,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('user.components.form-select', [
                                                    'name'    => 'state',
                                                    'value'   => old('state') ?? $user->state,
                                                    'list'    => \App\Models\State::listOptions(true, true),
                                                    'message' => $message ?? '',
                                                ])

                                                @include('user.components.form-input', [
                                                    'name'      => 'zip',
                                                    'value'     => old('zip') ?? $user->zip,
                                                    'maxlength' => 20,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('user.components.form-select', [
                                                    'name'    => 'country',
                                                    'value'   => old('country') ?? $user->country,
                                                    'list'    => \App\Models\Country::listOptions(true, true),
                                                    'message' => $message ?? '',
                                                ])

                                                @include('user.components.form-input', [
                                                    'name'      => 'phone',
                                                    'value'     => old('phone') ?? $user->phone,
                                                    'maxlength' => 20,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('user.components.form-input', [
                                                    'type'      => 'email',
                                                    'name'      => 'email',
                                                    'disabled'  => true,
                                                    'value'     => old('email') ?? $user->email,
                                                    'required'  => true,
                                                    'maxlength' => 255,
                                                    'message'   => $message ?? '',
                                                ])

                                                @include('user.components.form-input', [
                                                    'name'      => 'website',
                                                    'value'     => old('website') ?? $user->website,
                                                    'maxlength' => 255,
                                                    'message'   => $message ?? '',
                                                ])

                                                <?php /*
                                                @include('user.components.form-select', [
                                                    'name'    => 'status',
                                                    'value'   => old('status') ?? $user->status,
                                                    'list'    => \App\Models\User::statusListOptions(),
                                                    'message' => $message ?? '',
                                                ])

                                                @include('user.components.form-checkbox', [
                                                    'name'            => 'disabled',
                                                    'value'           => 1,
                                                    'unchecked_value' => 0,
                                                    'checked'         => old('disabled') ?? $user->disabled,
                                                    'message'         => $message ?? '',
                                                ])
                                                */ ?>

                                                @include('user.components.form-button-submit', [
                                                    'label'      => 'Save',
                                                    'cancel_url' => route('user.show')
                                                ])

                                            </form>

                                        </div>
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
