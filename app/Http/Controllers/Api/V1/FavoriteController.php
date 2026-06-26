<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\System\Database;
use App\Models\System\Resource;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use ReflectionClass;

class FavoriteController extends Controller
{
    /**
     * Increment the favorite_count for the specified resource by one.
     *
     * @param string $resourceName
     * @param int $id
     * @return ResponseFactory|Response
     */
    public function add(string $resourceName, int $id): Response|ResponseFactory
    {
        $resp = [
            'success' => 0,
            'data'    => [
                'resourceName' => $resourceName,
                'id'           => $id
            ],
            'message' => null,
            'errors'  => []
        ];

        if (!str_contains($resourceName, '.')) {
            $resp['errors'][] = 'Invalid resource name.';
        } elseif (!$database = trim(explode('.', $resourceName)[0])) {
            $resp['errors'][] = 'No resource name specified.';
        } elseif (!$table = trim(explode('.', $resourceName)[1])) {
            $resp['errors'][] = 'No resource name specified.';
        } elseif (!$resource = Resource::getResource($database . '_db', str_replace('_','-', $table))) {
            $resp['errors'][] = 'Resource was not found.';
        } else {
            try {
                $reflectionClass = new ReflectionClass($resource->class);

                $instance = $reflectionClass->newInstance();
                $instance->where('id', $id)->update(['favorite_count' => DB::raw('favorite_count + 1')]);
                $resp['success'] = 1;
            } catch (\Exception $e) {
                $resp['errors'][] = $e->getMessage();
            }
        }

        return response($resp);
    }

    /**
     * Decrement the favorite_count for the specified resource by one.
     *
     * @param string $resourceName
     * @param int $id
     * @return ResponseFactory|Response
     */
    public function remove(string $resourceName, int $id): Response|ResponseFactory
    {
        $resp = [
            'success' => 0,
            'data'    => [
                'resourceName' => $resourceName,
                'id'           => $id
            ],
            'message' => null,
            'errors'  => []
        ];

        if (!str_contains($resourceName, '.')) {
            $resp['errors'][] = 'Invalid resource name.';
        } elseif (!$database = trim(explode('.', $resourceName)[0])) {
            $resp['errors'][] = 'No resource name specified.';
        } elseif (!$table = trim(explode('.', $resourceName)[1])) {
            $resp['errors'][] = 'No resource name specified.';
        } elseif (!$resource = Resource::getResource($database . '_db', str_replace('_','-', $table))) {
            $resp['errors'][] = 'Resource was not found.';
        } else {
            try {
                $reflectionClass = new ReflectionClass($resource->class);

                $instance = $reflectionClass->newInstance();
                $instance->where('id', $id)->update(['favorite_count' => DB::raw('favorite_count - 1')]);
                $resp['success'] = 1;
            } catch (\Exception $e) {
                $resp['errors'][] = $e->getMessage();
            }
        }

        return response($resp);
    }
}
