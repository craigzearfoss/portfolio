@php
    use App\Models\Career\Company;
    use App\Models\System\Country;
    use App\Models\System\Owner;
    use App\Models\System\State;

    $title    = $pageTitle ?? 'Add New Reference';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home',            'href' => route('guest.index') ],
        [ 'name' => 'Admin Dashboard', 'href' => route('admin.dashboard') ],
    ];
    if (!empty($owner) && !empty($admin) && $admin->root) {
        $breadcrumbs[] = [ 'name' => 'Admins',     'href' => route('admin.system.admin.index') ];
        $breadcrumbs[] = [ 'name' => $owner->name, 'href' => route('admin.system.admin.show', $owner) ];
        $breadcrumbs[] = [ 'name' => 'Career',     'href' => route('admin.career.index', ['owner_id'=>$owner->id]) ];
        $breadcrumbs[] = [ 'name' => 'References', 'href' => route('admin.career.reference.index', ['owner_id'=>$owner->id]) ];
    } else {
        $breadcrumbs[] = [ 'name' => 'Career',     'href' => route('admin.career.index') ];
        $breadcrumbs[] = [ 'name' => 'References', 'href' => route('admin.career.reference.index') ];
    }
    $breadcrumbs[] = [ 'name' => 'Add' ];

    // set navigation buttons
    $navButtons = [
        view('admin.components.nav-button-back', ['href' => referer('admin.career.reference.index')])->render(),
    ];
@endphp

@extends('admin.layouts.default')

@section('content')

    <div class="edit-container card form-container p-4">

        <form action="{{ route('admin.career.reference.store', request()->all()) }}" method="POST">
            @csrf

            @include('admin.components.form-hidden', [
                'name'  => 'referer',
                'value' => referer('admin.career.reference.index')
            ])

            @if($admin->root)
                @include('admin.components.form-select-horizontal', [
                    'name'     => 'owner_id',
                    'label'    => 'owner',
                    'value'    => old('owner_id') ?? '',
                    'required' => true,
                    'list'     => new Owner()->listOptions([], 'id', 'username', true, false, [ 'username', 'asc' ]),
                    'message'  => $message ?? '',
                ])
            @else
                @include('admin.components.form-hidden', [
                    'name'  => 'owner_id',
                    'value' => Auth::guard('admin')->user()->id
                ])
            @endif

            @include('admin.components.form-input-horizontal', [
                'name'      => 'name',
                'value'     => old('name') ?? '',
                'required'  => true,
                'maxlength' => 255,
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'      => 'title',
                'value'     => old('title') ?? '',
                'maxlength' => 100,
                'message'   => $message ?? '',
            ])

            <div class="field is-horizontal">
                <div class="field-label is-normal">
                </div>
                <div class="field-body">
                    <div class="field">

                        <div class="checkbox-container card form-container p-4">

                            @include('admin.components.form-checkbox', [
                                'name'            => 'friend',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('friend') ?? 0,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'family',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('family') ?? 0,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'coworker',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('coworker') ?? 0,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'supervisor',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('supervisor') ?? 0,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'subordinate',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('subordinate') ?? 0,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'professional',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('professional') ?? 0,
                                'message'         => $message ?? '',
                            ])

                            @include('admin.components.form-checkbox', [
                                'name'            => 'other',
                                'value'           => 1,
                                'unchecked_value' => 0,
                                'checked'         => old('other') ?? 0,
                                'message'         => $message ?? '',
                            ])

                        </div>

                    </div>
                </div>
            </div>

            @include('admin.components.form-select-horizontal', [
                'name'    => 'company_id',
                'label'   => 'company',
                'value'   => old('company_id') ?? '',
                'list'    => new Company()->listOptions([], 'id', 'name', true),
                'message' => $message ?? '',
            ])

            @include('admin.components.form-location-horizontal', [
                'street'     => old('street') ?? '',
                'street2'    => old('street') ?? '',
                'city'       => old('city') ?? '',
                'state_id'   => old('state_id') ?? '',
                'states'     => new State()->listOptions([], 'id', 'name', true),
                'zip'        => old('zip') ?? '',
                'country_id' => old('country_id') ?? '',
                'countries'  => new Country()->listOptions([], 'id', 'name', true),
                'message'    => $message ?? '',
            ])

            @include('admin.components.form-coordinates-horizontal', [
                'latitude'  => old('latitude') ?? '',
                'longitude' => old('longitude') ?? '',
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-phone-horizontal', [
                'phone' => old('phone') ?? '',
                'label' => old('phone_label') ?? '',
                'message' => $message ?? '',
            ])

            @include('admin.components.form-phone-horizontal', [
                'phone'   => old('alt_phone') ?? '',
                'label'   => old('alt_phone_label') ?? '',
                'alt'     => true,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-email-horizontal', [
                'email'   => old('email') ?? '',
                'label'   => old('email_label') ?? '',
                'message' => $message ?? '',
            ])

            @include('admin.components.form-email-horizontal', [
                'email'   => old('alt_email') ?? '',
                'label'   => old('alt_email_label') ?? '',
                'alt'     => true,
                'message' => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'type'    => 'date',
                'name'    => 'birthday',
                'value'   => old('birthday') ?? '',
                'message' => $message ?? '',
            ])

            @include('admin.components.form-textarea-horizontal', [
                'name'    => 'notes',
                'value'   => old('notes') ?? '',
                'message' => $message ?? '',
            ])

            @include('admin.components.form-link-horizontal', [
                'link' => old('link') ?? '',
                'name' => old('link_name') ?? '',
                'message'   => $message ?? '',
            ])

            @include('admin.components.form-input-horizontal', [
                'name'        => 'disclaimer',
                'value'       => old('disclaimer') ?? '',
                'maxlength'   => 500,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-visibility-horizontal', [
                'public'      => old('public')   ?? 0,
                'readonly'    => old('readonly') ?? 0,
                'root'        => old('root')     ?? 0,
                'disabled'    => old('disabled') ?? 0,
                'demo'        => old('demo')     ?? 0,
                'sequence'    => old('sequence') ?? 0,
                'message'     => $message ?? '',
            ])

            @include('admin.components.form-button-submit-horizontal', [
                'label'      => 'Add Reference',
                'cancel_url' => referer('admin.career.reference.index')
            ])

        </form>

    </div>

@endsection
