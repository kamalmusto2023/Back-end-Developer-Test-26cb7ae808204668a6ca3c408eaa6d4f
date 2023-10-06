<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * The comments that belong to the user.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * The lessons that a user has access to.
     */
    public function lessons()
    {
        return $this->belongsToMany(Lesson::class);
    }

    /**
     * The lessons that a user has watched.
     */
    public function watched()
    {
        return $this->belongsToMany(Lesson::class)->wherePivot('watched', true);
    }




    public function getAchievementsInfo() :array
    {
        $user = $this;
       
        $lessons_watched_achievements =$user->lessons_watched_achievements( $user->watched()->count());
        $comments_written_achievements =$user->comments_written_achievements( $user->comments()->count());
        return $this->getBadgeInfo( $lessons_watched_achievements  +   $comments_written_achievements);
        
    }
    
    public function comments_written_achievements(int $number):int
    {
        if($number>=20)return  5 ;
         if($number>=10)return  4 ;
         if($number>=5)return  3 ;
        if($number>=3)return  2 ;
        if($number>=1)return  1;
        return 0;
    }
    public function lessons_watched_achievements(int $number):int
    {
        if($number>=50)return  5 ;
        if($number>=25)return 4 ;
        if($number>=10)return   3 ;
        if($number>=5)return 2 ;
        if($number>=1)return  1 ;
        return 0;
    }
    public function getBadgeInfo(int $level):array {
        if($level>=10)return [
            "next_available_achievements"=>[],
            "current_badge"=>"master",
            "next_badge"=>"",
            "remaing_to_unlock_next_badge"=>0,
        ];
        if($level>=8)return [
            "next_available_achievements"=>["master"],
            "current_badge"=>"advanced",
            "next_badge"=>"master",
            "remaing_to_unlock_next_badge"=>1,
        ];
        if($level>=4)return [
            "next_available_achievements"=>["master","advanced"],
            "current_badge"=>"intermediate",
            "next_badge"=>"advanced",
            "remaing_to_unlock_next_badge"=>2,
        ];
        if($level>=4)return [
            "next_available_achievements"=>["master","advanced"],
            "current_badge"=>"intermediate",
            "next_badge"=>"advanced",
            "remaing_to_unlock_next_badge"=>2,
        ];
    
        if($level>=0)return [
            "next_available_achievements"=>["master","advanced","intermediate"],
            "current_badge"=>"beginner",
            "next_badge"=>"intermediate",
            "remaing_to_unlock_next_badge"=>3,
        ];
            return [
            "next_available_achievements"=>["master","advanced","intermediate","beginner"],
            "current_badge"=>"",
            "next_badge"=>"beginner",
            "remaing_to_unlock_next_badge"=>4];
      

    }



}

