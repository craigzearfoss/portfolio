@extends('guest.layouts.default', [
    'title'         => $title ?? 'Personal',
    'breadcrumbs'   => [
        [ 'name' => 'Home',       'href' => route('system.index') ],
        [ 'name' => 'Users',      'href' => route('guest.admin.index') ],
        [ 'name' => $admin->name, 'href' => route('guest.admin.show', $admin)],
        [ 'name' => $title ?? 'Personal' ],
    ],
    'buttons'       => [],
    'errorMessages' => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success'       => session('success') ?? null,
    'error'         => session('error') ?? null,
    'admin'         => null,
])

@section('content')

    <div class="card m-4">

        <div class="card-body p-4">

            <div class="container">
                <div class="content">

                    <h3 class="title">
                        {{ $admin->name }} Personal
                    </h3>

                    <ul class="menu-list ml-4 mb-2">

                        @foreach ($personalResourceTypes as $resourceType)

                            @if(empty($resourceType['global']) && Route::has('guest.admin.personal.'.$resourceType['name'].'.index'))
                                <li>
                                    @include('guest.components.link', [
                                        'name'  => $resourceType['plural'],
                                        'href'  => route('guest.admin.personal.'.$resourceType['name'].'.index', $admin),
                                        'class' => 'pt-1 pb-1',
                                    ])
                                </li>
                            @endif

                        @endforeach

                    </ul>

                </div>
            </div>

        </div>

</div>

@endsection
