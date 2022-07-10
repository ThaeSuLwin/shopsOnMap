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
        $shops = Shop::with('user')->orderby('id', 'desc')->get();
       
        // return $shops;
        return \App\Http\Resources\ShopResource::collection($shops);
    }



    public function store(Request $request)
    {
        
        $shop = new Shop;
        $shop->name = $request->name;
        $shop->description = $request->description;
        $shop->latitude = $request->latitude;
        $shop->longitude = $request->longitude;
        $shop->hour = $request->hour;
        $shop->address = $request->address;
        $shop->user_id = $request->user_id;
        if($request->file('image'))
        {
        $image = $request->image;
        $image_name = $image->getClientOriginalName();
        $request->image->move(public_path('shop-images'), $image_name);
        $shop->image = $image_name;
        }

        $shop->save();

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
        $shop->name = $request->name;
        $shop->description = $request->description;
        $shop->latitude = $request->latitude;
        $shop->longitude = $request->longitude;
        $shop->hour = $request->hour;
        $shop->address = $request->address;

        if($request->file('image'))
        {
        $image = $request->image;
        $image_name = $image->getClientOriginalName();
        $request->image->move(public_path('shop-images'), $image_name);
        $shop->image = $image_name;
        }

        $shop->update();
        

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
        $address = $request->address;

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
        if($address){
            $query->where('address', 'like', '%'.$address.'%');
        }
        $shops = $query->orderBy('id', 'DESC')
        ->get();
        return \App\Http\Resources\ShopResource::collection($shops);
    }



    public function filter(Request $request)
    {
        $name = $request->name;
        $user_id = $request->user_id;
        $lat = $request->lat;
        $long = $request->long;
        $address = $request->address;
        $date = $request->date;

        if($request->userId === 1)
        {
            $query = Shop::select('*');
        }
        else {
            $query = Shop::where('user_id',$request->userId)->select('*');
        }

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
        if($address){
            $query->where('address', 'like', '%'.$address.'%');
        }
        if($date) 
        {
            $query->whereDate('created_at','=',$date);
        }
        $shops = $query->orderBy('id', 'DESC')
        ->get();
        return response()->json($shops);
    }
}
