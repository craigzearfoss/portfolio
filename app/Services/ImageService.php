<?php

namespace App\Services;

use Illuminate\Support\Facades\Request;

/**
 *
 */
class ImageService
{
    protected array $validators = [
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

    /**
     *
     */
    public function __construct()
    {
    }

    /**
     * @param Request $request
     * @param string $imageName
     * @return void
     */
    public function validate(Request $request, string $imageName = 'default'): void
    {
        $request->validate($this->validationRules( $imageName));
    }

    /**
     * @param string $type
     * @return mixed|string[]
     */
    public function validationRules(string $type = 'default'): mixed
    {
        if (array_key_exists($type, $this->validators)) {
            return $this->validators[$type];
        } else {
            return $this->validators['default'];
        }
    }
}
