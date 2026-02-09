<?php

namespace App\Services;

use App\Models\Scopes\AdminPublicScope;
use App\Models\System\Admin;
use App\Models\System\AdminDatabase;
use App\Models\System\AdminResource;
use App\Models\System\Database;
use App\Models\System\Resource;
use App\Models\System\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use stdClass;

class ImageService
{
    protected $validators = [
        'default' => [
            'image',
            'mimes:jpg,png,jpeg,gif,svg',
            'dimensions:min_width=100,min_height=100,max_width=1200,max_height=1200',
            'max:2048',
            'nullable'
        ],
        'image' => [
            'image',
            'mimes:jpg,png,jpeg,gif,svg',
            'dimensions:min_width=100,min_height=100,max_width=1200,max_height=1200',
            'max:2048',
            'nullable'
       ],
       'thumbnail' => [
            'image',
            'mimes:jpg,png,jpeg,gif,svg',
            'dimensions:min_width=20,min_height=20,max_width=200,max_height=200',
            'max:2048',
            'nullable'
        ],
    ];
    public function __construct()
    {
    }

    public function validate(Request $request, $imageName = 'default')
    {
        $validated = $request->validate($this->validationRules( $imageName));
    }

    public function validationRules(string $type = 'default')
    {
        if (array_key_exists($type, $this->validators)) {
            return $this->validators[$type];
        } else {
            return $this->validators['default'];
        }
    }
}
