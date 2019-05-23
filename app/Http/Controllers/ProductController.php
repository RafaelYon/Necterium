<?php

namespace App\Http\Controllers;

use App\Http\Request;

class ProductController
{
    public function show(Request $request)
    {
        //dp(['ProductController', 'product', $request->getParameters()[0]]);

        $queryBuilder = \App\Database\QueryBuilder::table('table_name')
                        ->select(['column1', 'column2', 'column3',])
                        ->join('table2', 'column2', '=', 'fk1')
                        ->where('column1', 1);

        dp($queryBuilder->toSql());
    }
}