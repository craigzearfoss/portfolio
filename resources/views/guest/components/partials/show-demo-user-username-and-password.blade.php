<div class="p-2 has-text-centered">

    @if(true === $retVal = validateDemoUserCredentials())

        <p class="mb-1">
            To log in as the <strong>demo</strong> user use the credentials below.
        </p>
        <code class=" has-text-primary">{{ config('app.demo_user_username') }} / {{ config('app.demo_user_password') }}</code>

    @else

        <p ><strong class="has-text-danger">{{ $retVal }}</strong></p>

    @endif

</div>
