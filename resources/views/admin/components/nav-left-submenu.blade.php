@php
    use App\Models\System\Owner;

    $subMenu = $subMenu ?? [];
    $owner   = $owner ?? null;
@endphp
@if (!empty($subMenu))

@endif
<div class="candidate-left-nav-container card m-2 p-0 has-background-light-35 has-text-primary-dark">

    @if (!config('app.single_admin_mode'))

        <div class="card-header">
            @include('guest.components.link', [
                'name' => 'candidates',
                'href' => route('guest.admin.index')
            ])
        </div>

        @if (!empty($owner))
            <div class="select-container">
                @include('guest.components.select-list', [
                    'value'       => !empty($owner->label) ? $owner->label : '',
                    'list'        => new Owner()->listOptions([ 'is_public' => 1, 'is_disabled' => false ], 'label', 'name', true, false, ['name', 'asc']),
                    'placeholder' => 'type name',
                    'onchange'    => 'loadSelectedAdmin(this.value, \'/#adminId#\')'
                ])
            </div>
        @endif

    @endif

    @if (!empty($candidateItems))

        @for ($i = 0; $i < count($candidateItems); $i++)

            <ul class="menu is-menu-main" style="font-size: 1rem;">

                @if ((get_class($candidateItems[$i]) === 'stdClass') && $candidateItems[$i]->name === 'Resume')

                    <p class="menu-label menu-label-left">
                        @include('guest.components.nav-link-left', [
                            'level'  => 1,
                            'name'   => $candidateItems[$i]->title,
                            'href'   => !empty($candidateItems[$i]->url) ? $candidateItems[$i]->url: false,
                            'active' => $candidateItems[$i]->active,
                            'class'  => 'button is-primary',
                            'style'  => 'width: 100%; height: 2em; color: #ffffff !important;',
                        ])
                    </p>

                @else

                    <p class="menu-label menu-label-left">
                        @include('guest.components.nav-link-left', [
                            'level'  => 1,
                            'name'   => $candidateItems[$i]->title,
                            'href'   => !empty($candidateItems[$i]->url) ? $candidateItems[$i]->url: false,
                            'active' => $candidateItems[$i]->active,
                            'class'  => 'has-text-white'
                        ])
                    </p>

                @endif

                @if (!empty($candidateItems[$i]->children))

                    <ul class="menu-list pl-2" style="margin-left: 1em;">

                        @foreach ($candidateItems[$i]['children'] as $l2=>$menu2Item)
                            <li>
                                @include('guest.components.nav-link-left', [
                                    'level'  => 2,
                                    'name'   => !empty($menu2Item->plural) ? $menu2Item->plural : $menu2Item->title,
                                    'href'   => !empty($menu2Item->url) ? $menu2Item->url : false,
                                    'active' => $menu2Item->active,
                                    'icon'   => !empty($menu2Item->icon) ? $menu2Item->icon : 'fa-circle'
                                ])

                                @if (!empty($menu2Item->children))
                                    @php dd($menu2Item->children) @endphp
                                    @php //@TODO: This isn't working @endphp
                                    <ul class="menu-list pl-2" style="margin-left: 1em;">

                                        @foreach ($menu2Item->children as $menu3Item)
                                            <li>
                                                @include('guest.components.nav-link-left', [
                                                    'level'  => 3,
                                                    'name'   => !empty($menu3Item->plural) ? $menu3Item->plural : $menu3Item->title,
                                                    'href'   => !empty($menu3Item->url) ? $menu3Item->url : false,
                                                    'active' => $menu3Item->active,
                                                    'icon'   => !empty($menu3Item->icon) ? $menu3Item->icon : 'fa-circle'
                                                ])
                                            </li>
                                        @endforeach

                                    </ul>

                                @endif

                            </li>
                        @endforeach

                    </ul>

                @endif

            </ul>

        @endfor

    @endif

</div>
