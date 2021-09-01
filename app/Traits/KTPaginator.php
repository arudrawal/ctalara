<?php
namespace App\Traits;
// use Carbon\Carbon;
/*
    KT datatable pagination sample request: build meta data array.
    "GET": {
        "scheme": "http",
        "host": "127.0.0.1:8000",
        "filename": "/api/sponsor/index",
        "query": {
            "pagination[page]": "1",
            "pagination[perpage]": "10",
            "sort[sort]": "asc",
            "sort[field]": "name",
            "query": ""
        },
    }
*/
 trait KTPaginator {
    /*
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function getQueryMetaData($request) {
        $query = $request->input('query.page', 1);
        return [
            'filterField' => '',
            'filterValue' => '',
        ];
    }
    /*
     * @param  \Illuminate\Http\Request  $request
     * @param  int $total
     * @param  string $def_sort_field
     * @return array
     */
    protected function getMetaData($request, $total, $def_sort_field) {
        $page = $request->input('pagination.page', 1);
        $perpage = $request->input('pagination.perpage', 10);
        $pages = ($total/$perpage)+1;
        $offset = ($perpage* ($page-1));
        return [
            'page' => $page,
            'perpage' => $perpage,
            'total' => $total,
            'pages' => ($total/$perpage)+1,
            'offset' => ($perpage* ($page-1)),
            'field' => $request->input('sort.field', $def_sort_field),
            'sort' => $request->input('sort.sort', 'asc')
        ];
    }
}
