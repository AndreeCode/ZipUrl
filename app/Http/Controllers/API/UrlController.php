<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UrlRequest;
use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function showAll()
    {
        $urls = Url::select('original_url','alias','short_url')->get();
        return response()->json($urls);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UrlRequest $request)
    {
        $shortUrl=$this->CreateShortUrl(5);
 
        $url=new Url();
        $url->original_url=$request->url;
        $url->short_url=$shortUrl;
        $url->alias=Url($shortUrl);
        $url->save();
    
        
        return response()->json([
            'short_url'=>url($url->short_url),
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $shortUrl)
    {
        $url =Url::select('original_url')->where('short_url',$shortUrl)->first();
        
        if($url){
            return redirect()->away($url->original_url,301);
        }else{
            return response()->json([
                'Error'=>'URL no encontrada',
            ],404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function CreateShortUrl(int $num){
        do {
            
            $alias =Str::random($num);
        } while (Url::where('alias', $alias)->exists()); 

        return $alias;
    }
}
