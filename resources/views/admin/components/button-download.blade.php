<a class="button is-small px-1 py-0"
   title="download file"
   @if(!empty($file))
       href="{{ route('download-from-public', [ 'file' => $file, 'name' => $name ?? null ]) }}"
       target="_blank"
   @else
       style="color: gray; cursor: default;"
   @endif
>
    <i class="fa-solid fa-download"></i>
</a>
