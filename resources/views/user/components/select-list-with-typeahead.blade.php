@php
    $id          = $id ?? ('input' . (!empty($name)  ? ucfirst($name) : 'Name'));
    $name        = $name ?? null;
    $value       = $value ?? '';
    $attributes  = $attributes ?? [];
    $placeholder = $placeholder ?? null;

    $list = $list ?? [];

    $selectedOptionLabel = '';
    foreach ($list as $listKey=>$listLabel) {
        if ($listKey === $value) {
            $selectedOptionLabel = $listLabel;
        }
    }

    // if a value was specified that's not in the options list then add it to the options list
    $add_undefined_option = !isset($add_undefined_option) || boolval($add_undefined_option);
    if ($add_undefined_option && !empty($value) && !in_array($value, array_keys($list))) {
        $list[$value] = $value;
    }

    $required = $required ?? false;

    $class = !empty($class) ? (!is_array($class) ? explode(' ', $class) : $class) : [];
    foreach ([ 'form-select', 'input', 'typeahead-input' ] as $thisClass) {
        if (!in_array($thisClass, $class)) $class[] = $thisClass;
    }

    $style = !empty($style) ? (!is_array($style) ? explode(';', $style) : $style) : [];

    $hasIcon = in_array($name, [
        'username',
        'password', 'confirm_password',
        'link', 'postings_url', 'website', 'wikipedia',
        'phone', 'alt_phone', 'home_phone', 'personal_phone', 'work_phone', 'mobile_phone', 'cell_phone',
        'email', 'alt_email', 'work_email', 'personal_email',
        'birthday'
    ]);
@endphp

@error('role')
    @php
        $class[] = 'is-invalid';
    @endphp
@enderror

<div class="typeahead-container field mb-0 mr-2">

    <input type="text"
           id="typeahead-input_{{ $name }}"
           class="{!! implode(' ', $class) !!} @error('role') is-invalid @enderror"
           @if (!empty($style))
               style="{!! implode('; ', $style) !!}"
           @endif
           value="{{ $selectedOptionLabel }}"
           @if (!empty($placeholder))
               placeholder="{{ $placeholder }}"
           @endif
           @if (!empty($onchange))
               onchange="{!! $onchange !!}"
           @endif
           autocomplete="off"
           @if (!empty($attributes))
                @foreach ($attributes as $key=>$value)
                    {{ $key }}="{!! $value !!}"
                @endforeach
           @endif
    >

    <input type="hidden" id="typeahead-key_{{ $name }}" name="{{ $name }}" value="{{ $value }}">

    <div id="typeahead-dropdown_{{ $name }}" class="typeahead-dropdown"></div>
</div>

<script>

    // Data array containing key-value object pairs
    const dataList_{{ $name }} = [
        @foreach ($list as $listKey=>$listLabel)
            {!! '{ key: "' . $listKey . '", value: "' . $listLabel . '" },' !!}
        @endforeach
    ];

    const input_{{ $name }} = document.getElementById("typeahead-input_{{ $name }}");
    const hiddenKey_{{ $name }} = document.getElementById("typeahead-key_{{ $name }}");
    const dropdown_{{ $name }} = document.getElementById("typeahead-dropdown_{{ $name }}");

    // Handle real-time user input filtering
    input_{{ $name }}.addEventListener("input", function() {
        const query = this.value.toLowerCase();
        dropdown_{{ $name }}.innerHTML = ""; // Clear existing items

        if (!query) {
            dropdown_{{ $name }}.style.display = "none";
            hiddenKey_{{ $name }}.value = ""; // Reset key if input cleared
            return;
        }

        // filter based on the 'value' property
        const matches_{{ $name }} = dataList_{{ $name }}.filter(item => item.value.toLowerCase().includes(query));

        if (matches_{{ $name }}.length === 0) {
            dropdown_{{ $name }}.style.display = "none";
            return;
        }

        // generate selection rows dynamically
        matches_{{ $name }}.forEach(item => {
            const row = document.createElement("div");
            row.textContent = item.value;
            row.style.padding = "8px";
            row.style.cursor = "pointer";

            // Mouse hover highlight effect
            row.addEventListener("mouseenter", () => row.style.backgroundColor = "#f0f0f0");
            row.addEventListener("mouseleave", () => row.style.backgroundColor = "#fff");

            // Click event handler to capture the data key
            row.addEventListener("click", function() {
                input_{{ $name }}.value = item.value;      // Display readable value to user
                hiddenKey_{{ $name }}.value = item.key;    // Save hidden key/ID to form input
                dropdown_{{ $name }}.style.display = "none"; // Close list menu box
                //console.log(`Selected Text: ${item.value}, Stored Key: ${item.key}`);
            });

            dropdown_{{ $name }}.appendChild(row);
        });

        dropdown_{{ $name }}.style.display = "block";
    });

    // close menu list when clicking outside the component
    document.addEventListener("click", function() {
        (document.querySelectorAll('.typeahead-dropdown') || []).forEach((elem) => {
            elem.style.display = 'none';
            elem.checked = true;
        })
    })

</script>
