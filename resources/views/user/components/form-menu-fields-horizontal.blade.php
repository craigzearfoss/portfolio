@php
    $menu = $menu?? 0;
    $menu_level = $menu_level = 0;
@endphp
<div class="field is-horizontal">
    <div class="field-label is-normal">
        <strong>menu</strong>
    </div>
    <div class="field-body">
        <div class="field">

            <div class="checkbox-container card form-container p-4">

                @include('user.components.form-checkbox', [
                    'name'            => 'menu',
                    'label'           => 'include',
                    'value'           => 1,
                    'unchecked_value' => 0,
                    'checked'         => old('menu') ?? $menu,
                    'message'         => $message ?? '',
                ])

                <div class="field is-horizontal" style="width: 10em;">
                    <div class="field-label" style="display: inline-block; width: 2.5em;">
                        <label class="label" for="inputMenu_level">level</label>
                    </div>
                    <div class="field-body mb-1" style="display:  inline-block;">
                        <div class="field">
                            <div class="select">

                                <select id="inputMenu_level" name="menu_level" required>
                                    @for($i=0; $i<=5; $i++)
                                        <option value="{{ $i }}"
                                                @if($i == old('menu_level') ?? $menu_level) selected @endif
                                        >
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
