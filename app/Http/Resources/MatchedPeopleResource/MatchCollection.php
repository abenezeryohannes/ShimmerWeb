<?php

namespace App\Http\Resources\MatchedPeopleResource;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Match;

class MatchCollection extends ResourceCollection
{

    private $user;
    public function user($value){
        $this->user = $value;
        return $this;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        
        return $this->collection->map(
                
                function(Match $match) use($request){
                    $resource = new  MatchResource($match);
                    return $resource->user($this->user)->toArray($request);
                }
            
             )->all();
        
    }
    


}
