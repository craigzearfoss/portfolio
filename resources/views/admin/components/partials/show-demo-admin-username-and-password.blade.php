<div class="p-2 has-text-centered">

    @if(true === $retVal = validateDemoAdminCredentials())

        <p class="mb-1">
            To log in as the <strong>demo</strong> admin use the credentials below.
        </p>
        <code class=" has-text-primary">{{ config('app.demo_admin_username') }} / {{ config('app.demo_admin_password') }}</code>

    @else

        <p ><strong class="has-text-danger">{{ $retVal }}</strong></p>

    @endif

</div>
