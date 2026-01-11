<div class="field is-horizontal">
    <div class="field-label">
    </div>
    <div class="field-body">
        <div class="field">

            <a
                href="{!! $cancel_url ?? route('admin.dashboard') !!}"
                class="button is-small is-dark"
            ><i class="fa-solid fa-close"></i> Cancel</a>

            <button
                type="{{ $type ?? 'submit' }}"
                @if (!empty($name))name="{!! $name !!}" @endif
                @if (!empty($id))id="{!! $id !!}" @endif
                class="button is-small is-dark {!! $class ?? '' !!}"
                @if (!empty($style))style="{!! is_array($style) ? implode('; ', $style) . ';' : $style !!}" @endif
                @if (!empty($onclick))onclick="{!! $onclick !!}" @endif
                {{ !empty($disabled) || !empty($readonly) ? 'disabled' : '' }}
            ><i class="fa-solid fa-floppy-disk"></i> {!! $label ?? 'Submit' !!}</button>

        </div>
    </div>
</div>
