<?php
/**
 */

namespace App\Service;


class PaginationService
{

    public function returnPaginationArray(int $page, string $route, $subjectsTotal, $max){
        $paginationArray = [
            'page' =>$page,
            'route' => $route,
            'page_count' =>ceil(count($subjectsTotal)/$max),
            'route_params' => []
        ];
        return $paginationArray;
    }

}