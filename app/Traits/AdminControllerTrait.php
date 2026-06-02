<?php

namespace App\Traits;

trait AdminControllerTrait
{
    /**
     * @var int
     */
    protected int $PAGINATION_PER_PAGE = 20;

    /**
     * Returns the number of items per page for pagination. First it checks the
     * PAGINATION_PER_PAGE variable in the .env file. If it is not set then it
     * get the value of the PAGINATION_PER_PAGE class  variable in the controller.
     *
     * @return int
     */
    public function perPage(): int
    {
        $perPage = config('app.pagination_per_page');

        if (empty($perPage)) {
            $perPage = $this->PAGINATION_PER_PAGE;
        }

        return $perPage;
    }
}
