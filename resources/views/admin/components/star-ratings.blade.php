<div class="has-text-left" style="white-space: nowrap;">

    @php
        if (empty($max)) {
            $max = !empty($rating) ? ( (($rating - intval($rating)) >= 0.25) ? ceil($rating) : floor($rating) ) : 4;
        }
    @endphp

    @for ($cnt=1; $cnt<$max + 1; $cnt++)
        @if($cnt <= $rating)
            <i class="fa-solid fa-star"></i>
        @elseif (!empty($rating) && (floor($rating) == $cnt) && ($rating - $cnt)) < 0.75 ))
            <i class="fa-solid fa-star-half"></i>
        @endif
    @endfor
    {{ $label ?? '' }}

</div>
