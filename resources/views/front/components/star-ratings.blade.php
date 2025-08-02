<div class="text-left">

    @php
        $limit = !empty($rating) ? ( (($rating - intval($rating)) >= 0.25) ? ceil($rating) : floor($rating) ) : 4;
    @endphp

    @if (empty($max))
        @for ($cnt=1; $cnt<=$limit; $cnt++)
            @if ((floor($rating) >= $cnt) || ($rating - $cnt) >= 0.75 )
                <i class="fa-solid fa-star"></i>
            @else
                <i class="fa-solid fa-star-half"></i>
            @endif
        @endfor
    @else
        //TODO rating with max
        @for ($cnt=1; $cnt<$max; $cnt++)
            <i class="fa-solid fa-star"></i>
        @endfor
    @endif
</div>
