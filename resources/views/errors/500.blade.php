@php
    use App\Enums\EnvTypes;

    $envType = getEnvType();

    $backRoute = match ($envType) {
        EnvTypes::ADMIN => 'admin.dashboard',
        EnvTypes::USER => 'user.dashboard',
        default => 'guest.index',
    };

    $title   = '500 Internal Server Error';
    $message = !empty($exception) ? $exception->getMessage() : '';
    if (empty($message)) {
        $message = 'The server encountered an internal error or misconfiguration and was unable to complete your request.';
    }
    $errorImagePath = DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'site' . DIRECTORY_SEPARATOR . 'error' . DIRECTORY_SEPARATOR . '500.png';
@endphp
@extends($envType->value.'.layouts.empty', [
    'title'   => $title,
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
                        <h1 class="title">{{ $title }}</h1>
                        @if (file_exists(public_path() . $errorImagePath))
                            <img src="{{ str_replace(DIRECTORY_SEPARATOR, '/', $errorImagePath) }}" alt="{{ $title }} image" />
                        @endif
                        <p>{{ $message }}</p>
                    </div>

                    <div>

                        @include($envType->value.'.components.link', [
                            'name' => 'Back',
                            'href' => route($backRoute)
                        ])

                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
