@php
    use App\Enums\EnvTypes;

    $envType = getEnvType();

    $backRoute = match ($envType) {
        EnvTypes::ADMIN => 'admin.dashboard',
        EnvTypes::USER => 'user.dashboard',
        default => 'guest.index',
    };

    $message = $exception->getMessage();
@endphp
@extends($envType->value.'.layouts.empty', [
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


                    <div class="box has-text-centered">
                        <h1 class="title">500 Server Error</h1>

                        @if(!empty($message))

                            <p>{{ $message }}</p>

                        @endif

                    </div>


                    @include($envType->value.'.components.link', [
                        'name' => 'Back',
                        'href' => referer($backRoute)
                    ])

                </div>
            </div>
        </div>
    </div>

@endsection
