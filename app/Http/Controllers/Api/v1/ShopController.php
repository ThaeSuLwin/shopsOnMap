<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Shop;


class ShopController extends Controller
{
    public function index()
    {
        $shops = Shop::orderby('id', 'desc')->get();
        return response()->json($shops);
     
    }




    public function mapView()
    {
        $shops = Shop::orderby('id', 'desc')->get();
        return \App\Http\Resources\ShopResource::collection($shops);
    }



    public function store(Request $request)
    {

        $shop = Shop::create($request->all());

        return response()->json([
            'status' => 'success',
            'shop'   => $shop
        ]);
    }

    public function show($id)
    {
        $shop = Shop::find($id);

        return response()->json($shop);
    }

    public function update(Request $request, $id)
    {
        $shop = Shop::find($id);
        $shop->update($request->all());

        return response()->json([
            'status' => 'success',
            'shop'   => $shop
        ]);
    }

    public function destroy($id)
    {
         $shop = Shop::find($id);
         $shop->delete();

         return response()->json('shop successfully deleted!');
    }
}
