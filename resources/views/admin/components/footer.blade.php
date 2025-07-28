<footer class="footer flex flex-auto items-center h-16 px-4 sm:px-6 md:px-8">
    <div class="flex items-center justify-between flex-auto w-full">
        @if(getenv('APP_OWNER'))
            <span>Copyright © 2025 <span class="font-semibold">{{ getenv('APP_OWNER') }}</span> All rights reserved.</span>
        @endif
        <div>
            <a class="text-gray" href="#">Terms &amp; Conditions</a>
            <span class="mx-2 text-muted"> | </span>
            <a class="text-gray" href="#">Privacy &amp; Policy</a>
        </div>
    </div>
</footer>
