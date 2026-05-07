@php
    use App\Enums\EnvTypes;

    $envType = getEnvType();

    $backRoute = match ($envType) {
        EnvTypes::ADMIN => 'admin.dashboard',
        EnvTypes::USER => 'user.dashboard',
        default => 'guest.index',
    };

    $title   = '403 Forbidden';
    $message = !empty($exception) ? $exception->getMessage() : '';
    if (empty($message)) {
        $message = 'You tried to access a page for which you do not have permission.';
    }
    $errorImagePath = DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'site' . DIRECTORY_SEPARATOR . 'error' . DIRECTORY_SEPARATOR . '403.png';
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
