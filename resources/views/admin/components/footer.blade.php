<footer class="footer">
    <div class="container-fluid">
        <div class="level">
            <div class="level-left">
                <div class="level-item">
                    @if(config('app.copyright') && config('app.owner'))
                        @include('admin.components.copyright')
                    @endif
                </div>
                <div class="level-item">
                </div>
            </div>
            <div class="level-right">
                <div class="level-item">
                    <a href="{!! route('admin.about') !!}">About</a>
                    <span class="mx-2"> | </span>
                    <a href="{!! route('admin.terms-and-conditions') !!}">Terms & Conditions</a>
                    <span class="mx-2"> | </span>
                    <a href="{!! route('admin.privacy-policy') !!}">Privacy policy</a>
                    <span class="mx-2"> | </span>
                    <a href="{!! route('admin.contact') !!}">Contact</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<script>
    (function() {
        document.querySelectorAll('.download-link').forEach(element => {
            element.addEventListener('click', function(event) {
                event.preventDefault();
                const elem = event.currentTarget;
                let url = elem.getAttribute('data-url');
                let filename = elem.getAttribute('data-filename') ?? '';
                downloadFile(url, filename)
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

