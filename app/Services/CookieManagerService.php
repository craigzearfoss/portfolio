<?php

namespace App\Services;

use App\Enums\EnvTypes;
use http\Env;
use Illuminate\Support\Facades\Cookie;

/**
 *
 */
class CookieManagerService
{
    /**
     * @var array
     */
    protected array $cookies = [];

    public function __construct()
    {
        $this->fetch();
    }

    /**
     * @return self
     */
    public function fetch(): self
    {
        $this->cookies = request()->cookie();

        return $this;
    }

    public function reset(): self
    {
        $this->cookies = [];

        return $this;
    }

    /**
     * @param EnvTypes $envType
     * @param string $name
     * @return array|int|mixed|null
     */
    public function get(EnvTypes $envType, string $name): mixed
    {
        $cookieName = $envType->value . '-' . $name;

        if (empty($name)) {
            return $this->cookies;
        } else {
            return $this->cookies[$name] ?? null;
        }
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return request()->cookie();
    }

    /**
     * @param EnvTypes $envType
     * @return int|null
     */
    public function getOwnerId(EnvTypes $envType): ?int
    {
        $cookieName = $envType->value . '-' . 'owner_id';

        $value =  $this->cookies[$cookieName] ?? null;

        return !is_null($value) ? intval($value) : null;
    }

    public function set(EnvTypes $envType, $name, $value = null): self
    {
        $cookieName = $envType->value . '-' .  $name;

        $this->cookies[$cookieName] = $value;

        return $this;
    }

    public function setOwnerId(EnvTypes $envType, $value = null): self
    {
        $cookieName = $envType->value . '-' . 'owner_id';

        $this->cookies[$cookieName] = $value;

        return $this;
    }

    public function queue(EnvTypes $envType, string $name, int $ttl = 60): self
    {
        $cookieName = $envType->value . '-' . $name;

        Cookie::queue(
            Cookie::make(
                $cookieName,
                $this->cookies[$cookieName] ?? null,
                $ttl
            )
        );

        return $this;
    }

    public function queueOwnerId(EnvTypes $envType, int $ttl = 60): self
    {
        $cookieName  = $envType->value . '-' . 'owner_id';

        Cookie::queue(
            Cookie::make(
                $cookieName,
                $this->cookies[$cookieName] ?? null,
                $ttl
            )
        );

        return $this;
    }
}
