<!DOCTYPE html>
<html lang="en" dir="ltr" class="light">

@include('front.components.head')

<body>

<div id="root">

    @yield('content')

</div>

<!-- Core Vendors JS -->
<script src="{{ asset('backend/assets/js/vendors.min.js') }}"></script>

<!-- Other Vendors JS -->

<!-- Page js -->
<script src="{{ asset('backend/assets/js/pages/welcome.js') }}"></script>

<!-- Core JS -->
<script src="{{ asset('backend/assets/js/app.min.js') }}"></script>

</body>

<script type="text/javascript">
    $('#reload').click(function() {
        $.ajax({
            type: 'GET',
            url: 'reload-captcha',
            success: function(data) {
                $(".captcha span").html(data.captcha);
            }
        });
    });
</script>

</html>
