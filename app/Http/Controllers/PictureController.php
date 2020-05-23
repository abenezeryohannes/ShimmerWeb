<?php

namespace App\Http\Controllers;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as Image;
use App\Picture;
use App\Profile;
use App\Like;
use App\User;
use App\Http\Resources\Picture as PictureResource;

use Illuminate\Http\Request;

class PictureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
     {




             $image = $request->file('image');
             $image2 = Image::make($image);
             $base_name = time() ."RND". rand(0, 100000) ;
             $name = $base_name  .  '.' . $image->getClientOriginalExtension();
             $destinationPath = public_path('img');
             $image->move($destinationPath, $name);
             $image2->blur(35);
             $image2->save($destinationPath ."/". $base_name . 'lq.' . 'jpg', 10);
           

             $picture = Picture::where('user_id', '=', $request['user_id'])
                                 ->where('order', '=', $request['order'])->first();

            if($picture == null)
                {
                   // dd("picture is null " .  " user id : " . $request['user_id'] . " order: " . $request['order'] );
                    $pics = Picture::where('user_id', '=', $request['user_id'])->orderBy('order', 'desc')->first();
                    //dd($pics);
                    $picture = new Picture();
                    $picture->user_id = (int) $request['user_id'];
                    if($pics!=null) $picture->order = $pics->order+1;
                    else $picture->order = 1;
                    //dd($picture);
                }

            $picture->name = $name;
            $picture->save();

            // $destinationPathforplaceholder = public_path('placeholder');
            // $image->encode('jpg', 10);
            // $image->move($destinationPathforplaceholder, $name);

            
            $profile = Profile::where('user_id', '=', $picture->user_id)->first();
            $profile->completed = (55 + (($profile->answers->count() + $profile->pictures->count())*5));
            $profile->save();
            

            


         //   return response()->json([
         //       'status' => "success",
         //       'name' => $name,
         //       'destination' => public_path('img')
         //       ]);

         $user = User::find($picture->user_id);
         $allUsers = User::all();
         if($picture->order==1)
         foreach($allUsers as $u){
             if($u->id==$user->id)continue;
             $like = new Like();
             $like->liker_user_id = $u->id;
             $like->liked_user_id = $user->id;
         
             $picture = Picture::where('user_id', '=', $user->id)->first();
             $like->picture_id = $picture->id;
             
             $like->notified = false;
             $like->comment = "U luk cute!";
             $like->save();    
         }
 
       
             return new PictureResource($picture);
            //response()->json(['status' => "success", 'name' => $name, 'destination' => public_path('img') ]);
            
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // $validatedRequest = $request->validate([
        //     'url' => 'required',//|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        //     'user_id' => 'required',
        //     'order' => 'required'
        // ]);

        $url = $request['url'];
        $url =  str_replace('"', '', $url);
        
        //return "yes";
        $extenstion = pathinfo($url, PATHINFO_EXTENSION);
        $base_name = time() . $request['order'];
        $filename = $base_name .  '.'  . "jpg";
    

        $file = Image::make($url)->save(public_path('img') . "/"  .$filename);
        
         $image2 = Image::make($url);
         $image2->blur(35);
         $image2->save($destinationPath ."/". $base_name . 'lq.' . 'jpg', 10);
       
        // $save = file_put_contents('img', $filename, $file);
        //$destinationPath = public_path('img');
        //$file->move($destinationPath, $filename);
        //Storage::putFileAs('img', $file, $filename);
        // $file->store('img')->storeAs($filename);

        //$file = file_get_contents($url);
        //Storage::put($filename, $file);
        //return $filename;
        //save to database
        $picture = Picture::where('user_id', '=', $request['user_id'])->where('order', '=', $request['order'])->first();
        if($picture == null){
            $pics = Picture::where('user_id', '=', $request['user_id'])->orderBy('order', 'desc')->first();
            $picture = new Picture();
            if($pics!=null) $picture->order = $pics->order;
            else  $picture->order = 0;
        } 
        $picture->user_id = $request['user_id'];
        $picture->order = $request['order'];
        $picture->name = $filename;
        $picture->save();

 
        $profile = Profile::where('user_id', '=', $picture->user_id)->first();
        $profile->completed = (55 + (($profile->answers->count() + $profile->pictures->count())*5));
        $profile->save();
        
        
        // $user = User::find($picture->user_id);
        // $allUsers = User::all();
        // if($picture->order==1)
        // foreach($allUsers as $u){
        //     if($u->id==$user->id)continue;
        //     $like = new Like();
        //     $like->liker_user_id = $u->id;
        //     $like->liked_user_id = $user->id;
        
        //     $picture = Picture::where('user_id', '=', $user->id)->first();
        //     $like->picture_id = $picture->id;
            
        //     $like->notified = false;
        //     $like->comment = "U luk cute!";
        //     $like->save();    
        // }

      

        return new PictureResource($picture);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Picture  $picture
     * @return \Illuminate\Http\Response
     */
    public function show(Picture $picture)
    {
        //
        $validatedRequest = $request->validate([
            'name' => 'required',
        ]);

        $url = "" . $request['name'];
        $extenstion = pathinfo($url, PATHINFO_EXTENSION);
        
        $img = Image::make($url);

        header('Content-Type: image/' . $extenstion);
        return $img->response();

        



    }


    public function setOrder(Request $request){


        $picture = Picture::where('user_id', '=', $request['user_id'])
                            ->where('id', '=', $request['picture_id'])->first();


    
        
        if($picture == null)
        {
            new PictureResource(null);
        }

        $picture->order =  $request['order'];
        $picture->save();

        return new PictureResource($picture);
    }


    public function deletePicture(Request $request){

        $picture = Picture::where('user_id', '=', $request['user_id'])
                            ->where('id', '=', $request['picture_id'])->first();
        if($picture == null)
        {
            return response()->json(["status"=> "Failur! no picture found!"]);
        }
        $picture = Picture::where('user_id', '=', $request['user_id'])
        ->where('id', '=', $request['picture_id'])->delete();

        $picture = Picture::where('user_id', '=', $request['user_id'])->get();
        return PictureResource::collection($picture);



    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Picture  $picture
     * @return \Illuminate\Http\Response
     */
    public function edit(Picture $picture)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Picture  $picture
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Picture $picture)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Picture  $picture
     * @return \Illuminate\Http\Response
     */
    public function destroy(Picture $picture)
    {
        //
    }
}
