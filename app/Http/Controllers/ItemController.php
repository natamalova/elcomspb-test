<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('unique');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse JSON
     */
    public function store(Request $request)
    {
        $items = $request->post('items');

        foreach ($items as $item) {
            Item::create($item);
        }

        return response()->json('Данные успешно записаны');
    }
}
