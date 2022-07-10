<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Shop;


class ShopController extends Controller
{
    public function index()
    {
        // return Request()->all();
        if(Request()->userId == 1) 
        {
            $shops = Shop::with('user')->orderby('id', 'desc')->get();
        }
        else {
            $shops = Shop::where('user_id',Request()->userId)->with('user')->orderby('id', 'desc')->get();
        }
        
        return response()->json($shops);
     
    }




    public function mapView()
    {
        $shops = Shop::orderby('id', 'desc')->get();
        return \App\Http\Resources\ShopResource::collection($shops);
    }



    public function store(Request $request)
    {
        return $request->image;
        $image = $request->image;
        $image_name = $image->getClientOriginalName();
        $request->image->move(public_path('shop-images'), $image_name);

        $shop = Shop::create($request->only(
            'name',
            'description',
            'latitude',
            'longitude'
        ) + [
        'image' => $image_name
        ]
        );

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
        if($request->has('image'))
        {
        $image = $request->image;
        $image_name = $image->getClientOriginalName();
        $request->image->move(public_path('shop-images'), $image_name);
        $shop->image = $image_name;
        }
        $shop->update($request->only(
            'name',
            'description',
            'latitude',
            'longitude'
        ) 
        );
        

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


    public function search(Request $request)
    {
        $name = $request->name;
        $user_id = $request->user_id;
        $lat = $request->lat;
        $long = $request->long;

        $query = Shop::select('*');

        if($name){
            $query->where('name', 'like', '%'.$name.'%');
        }
        if($user_id){
            $query->where('user_id','=',$user_id);
        }
        if($lat){
            $query->where('latitude','=',$lat);
        }
        if($long){
            $query->where('longitude','=',$long);
        }

        $shops = $query->orderBy('id', 'DESC')
        ->get();
        return \App\Http\Resources\ShopResource::collection($shops);
    }
}
