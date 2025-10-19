<footer class="footer mt-4">
    <div class="container-fluid">
        <div class="level">
            <div class="level-left">
                <div class="level-item">
                    @if(config('app.copyright') && config('app.owner'))
                        @include('user.components.copyright')
                    @endif
                </div>
                <div class="level-item">
                </div>
            </div>
            <div class="level-right">
                <div class="level-item">
                    <a href="{{ route('guest.about') }}">About</a>
                    <span class="mx-2"> | </span>
                    <a href="{{ route('guest.terms-and-conditions') }}">Terms & Conditions</a>
                    <span class="mx-2"> | </span>
                    <a href="{{ route('guest.privacy-policy') }}">Privacy policy</a>
                    <span class="mx-2"> | </span>
                    <a href="{{ route('guest.contact') }}">Contact</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<script>
    (function() {
        document.querySelectorAll('.download-link').forEach(element => {
            element.addEventListener('click', function() {
                let url = element.getAttribute('data-url');
                let filename = element.getAttribute('data-filename') ?? '';
                console.log(url,filename)
                downloadFile(url, filename)
                console.log('Element with class "download-link" clicked:', this);
            });
        });

        if (document.querySelector('#inputEditor')) {
            ClassicEditor
                .create(document.querySelector('#inputEditor'))
                .catch(error => {
                    console.error(error);
                });
        }
    })();
</script>

