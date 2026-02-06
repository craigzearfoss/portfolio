@php
    if (isAdmin()) {
        $envType = 'admin';
        $backRoute = 'admin.dashboard';
    } elseif (isUser()) {
        $envType = 'user';
        $backRoute = 'user.dashboard';
    } else {
        $envType = 'guest';
        $backRoute = 'guest.index';
    }
    $message = $exception->getMessage();
@endphp
@extends($envType.'.layouts.empty', [
    'title' => '403 Forbidden',
    'errorMessages' => $errors->any()
        ? !empty($errors->get('GLOBAL')) ? [$errors->get('GLOBAL')] : ['Fix the indicated errors before saving.']
        : [],
    'success' => session('success') ?? null,
    'error'   => session('error') ?? null,
])

@section('content')

    <div class="container">
        <div class="section">
            <div class="columns">
                <div class="column is-three-fifths is-offset-one-fifth">

                    @if(!empty($message))

                        <div class="box has-text-centered">
                            <h1 class="title">403 Forbidden</h1>
                            <p>{{ $message }}</p>
                        </div>

                    @else

                        <div class="box has-text-centered">
                            <h1 class="title">403 Forbidden</h1>
                            <p>You tried to access a page for which you are not authorized.</p>
                            <p>If you are the application owner check the logs for more information.</p>
                        </div>

                    @endif

                    <div>

                        @include($envType.'.components.link', [
                            'name' => 'Back',
                            'href' => referer($backRoute)
                        ])

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
