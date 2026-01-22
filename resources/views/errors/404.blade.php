@php
    if (isAdmin()) {
        $envType = 'admin';
        $backRoute = 'admin.dashboard';
    } elseif (isUser()) {
        $envType = 'user';
        $backRoute = 'user.dashboard';
    } else {
        $envType = 'guest';
        $backRoute = 'home';
    }
    $message = $exception->getMessage();
@endphp
@extends($envType.'.layouts.empty', [
    'title' => '404 Not Found',
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
                    <div class="box has-text-centered">
                        <h1 class="title">404 Not Found</h1>

                        @if(!empty($message))

                            <p>
                                {{ $message }}
                            </p>

                        @else

                            <p>You may have mistyped the address or the page may have moved.</p>

                            <p>If you are the application owner check the logs for more information.</p>

                        @endif

                    </div>
                    <div>

                        @include($envType.'.components.link', [
                            'name' => 'Back',
                            'href' => route($backRoute)
                        ])

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
