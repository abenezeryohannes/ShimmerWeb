<?php

namespace App;

//use Laravel\Passport\HasApiTokens;
use Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;


    public function answers()
    {
        return $this->hasMany('App\Answare');
    }

    public function pictures(){
        return $this->hasMany('App\Picture');
    }
    public function location(){
        return $this->hasOne('App\Location');
    }

    public function likers(){
        return $this->hasMany('App\Like', 'liked_user_id', 'id');
    }
    public function likes(){
        return $this->hasMany('App\Like', 'liker_user_id', 'id');
    }

    public function profile(){
        return $this->hasOne('App\Profile');
    }

    public function paymentInfo(){
        return $this->hasOne('App\PaymentInformation', 'user_id', 'id');
    }
    public function scopeFullPayment($query){
        return $this->join('payments', 'users.id', '=', 'payments.user_id')->join('payment_types', 'payments.payment_type_id', '=', 'payment_types.id')
        ;
    }
    public function scopeFullPaymentSubscribtion($query){
        return $this->join('payments', 'users.id', '=', 'payments.user_id')->join('payment_types', 'payments.payment_type_id', '=', 'payment_types.id')
        ->where('payment_types.type', '=', 'subscribtion')->select('payments.*');
    }
    public function scopeFullActivePaymentSubscribtion($query){
        return $this->join('payments', 'users.id', '=', 'payments.user_id')->join('payment_types', 'payments.payment_type_id', '=', 'payment_types.id')
        ->where("payments.created_at", ">", Carbon::now())->where('payment_types.type', '=', 'subscribtion')
        
        ->select('payments.*');
    }
    
    public function scopePaymentTypes($query){
        return $this->join('payments', 'users.id', '=', 'payments.user_id')->join('payment_types', 'payments.payment_type_id', '=', 'payment_types.id')
        ->where('payment_types.type', '=', 'subscribtion')
        
        ->select('payment_types.*');
    }
    public function scopeFullActivePaymentBoost($query){
        return $this->join('payments', 'users.id', '=', 'payments.user_id')->join('payment_types', 'payments.payment_type_id', '=', 'payment_types.id')
        ->where("payments.created_at", ">", Carbon::now())->where('payment_types.type', '=', 'boost')->select('payments.*');;
    }

    public function phonenumbers()
    {
        return $this->hasMany("App\Phonenumber");
    }
    public function telegram()
    {
        return $this->hasOne("App\TelegramInvite");
    }





    
    




    public function scopeUnreadCount($query, $user_id)
    {
        return $query->join('messages', function($join){
                $join->on('messages.reciever_id', '=', 'users.id');
            })
            ->where('messages.seen', false)->count();
    }



    public function scopeUnreadLastMessage($query, $user_id)
    {   
        return $query->join('messages', function($join){
                $join->on('messages.reciever_id', '=', 'users.id');
            })
            ->where('messages.seen', false)->Order_by('messages.created_at', 'asc')->first()->get();
    }



    public function messages()
    {
      return $this->hasMany("App\Message");
    }

    
    public function payment()
    {
      return $this->hasMany("App\Payment");
    }

    public function boost()
    {
      return $this->hasMany("App\Boost");
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'facebook', 'email', 'password', 'first_name', 'last_name', 'instagram', 'phone_number'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];








    ////////////////////////////////
    public function scopeChats($query, $user_id_1, $user_id_2)
    {
        
        $this->user1 = $user_id_1;
        $this->user2 = $user_id_2;
        return $query->join('messages', 'messages.sender_id', '!=', 'messages.reciever_id')
        ->where(function($query) {
            $query->Where('messages.sender_id',  $this->user1)
            ->Where('messages.reciever_id',  $this->user2);
        })->Orwhere(function($query){
            $query->Where('messages.reciever_id',  $this->user1)
            ->Where('messages.sender_id', $this->user2);
        })->orderBy('messages.created_at', 'desc');
    }


    //////////////////////////////
    public function scopeGetMatches($query, $user_id)
    {
         //change this
        return $query->join('matches', function($join){
            $join->on('users.id', '=', 'matches.user_id_2')
            ->oron('users.id', '=', 'matches.user_id_1');
        })
        ->where('users.id', '=', $user_id)
        ->orderBy('matches.created_at', 'desc')
        ->get([
            
            "users.id",
            "matches.created_at",
            "user_id_1",
            "user_id_2",
            "new",
            "seen"
        
        ]);
    }

    public function scopeGetProfile($query, $user_id){
        return $query->join('profiles', function($join){
            $join->on('profiles.user_id', '=', 'users.id');
        })
        
        ->where('users.id', '=', $user_id)->get([
            'user_id',
            'first_name',
            'phone_number',
            'profiles.sex',
            'age',
            'height_id',
            'work',
            'school',
            'kid_id',
            'family_plan_id',
            'education_id',
            'drink_id',
            'smoke_id',
           
        ]);


        
    }



}
