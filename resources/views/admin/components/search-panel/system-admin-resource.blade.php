@php
    use App\Models\System\Admin;
    use App\Models\System\Database;
    use App\Models\System\Resource;

    $action      = $action ?? url()->current();
    $owner_id    = $owner_id ?? (!empty($owner->is_root) ? null : ($owner->id ?? null));
    $database_id = $database_id ?? request()->query('database_id');
    $name        = $name ?? request()->query('name');
@endphp
<div class="mb-2" style="display: flex;">

    <div class="search-container card p-2">

        <form id="searchForm" action="{!! $action ?? '' !!}" method="get">

            <div>

                <div class="floating-div-container">

                    <div class="floating-div">
                        <div class="search-form-control">
                            @include('admin.components.search-panel.controls.system-owner', [ 'owner_id' => $owner_id ])
                        </div>
                    </div>

                    <div class="floating-div">
                        <div class="search-form-control">
                            <div class="control" style="max-width: 28rem;">
                                @include('admin.components.form-select', [
                                    'name'     => 'database_id',
                                    'label'    => 'database',
                                    'value'    => $database_id,
                                    'list'     => new Database()->listOptions(
                                                      [ 'owner_id' => 1 ],
                                                      'id',
                                                      'tag',
                                                      true,
                                                      false,
                                                      [ 'tag', 'asc' ]
                                                  ),
                                    'style'    => 'width: 8rem;'
                                ])
                            </div>
                        </div>
                    </div>

                    <div class="floating-div">
                        <div class="search-form-control">
                            <div class="control" style="max-width: 28rem;">
                                @include('admin.components.form-select', [
                                    'name'     => 'name',
                                    'label'    => 'name',
                                    'value'    => $name,
                                    'list'     => new Resource()->listOptions(
                                                      [ 'owner_id' => $owner_id ],
                                                      'name',
                                                      'name',
                                                      true,
                                                      false,
                                                      [ 'name', 'asc' ]
                                                  ),
                                    'style'    => 'width: 8rem;'
                                ])
                            </div>
                        </div>
                    </div>

                </div>

                <div class="has-text-right pr-2">
                    @include('admin.components.button-clear', [
                        'id'   =>'clearSearchForm',
                        'name' => 'Clear',
                    ])
                    @include('admin.components.button-search', [
                        'id' =>'performSearch',
                    ])
                </div>

            </div>

        </form>

    </div>

</div>
