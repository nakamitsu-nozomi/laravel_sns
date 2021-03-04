<?php

namespace App;

use App\Mail\BareMail;
use App\Notifications\PasswordResetNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordResetNotification($token, new BareMail()));
    }
    public function articles(): HasMany
    {
        return $this->hasMany("App\Article");
    }
    public function likes(): BelongsToMany
    {
        return $this->belongsToMany("App\Article", "likes")->withTimestamps();
    }
    // フォロワーのアソシエーション
    public function followers(): BelongsToMany
    {
        return $this->belongsToMany("App\User", "follows", "followee_id", "follower_id")->withTimestamps();
    }
    // あるユーザーをフォロー中かどうか判定するメソッド
    public function isFollowedBy(?User $user): bool
    {
        return $user
            ? (bool)$this->followers->where("id", $user->id)->count()
            : false;
    }
    // フォローのアソシエーション
    public function followings(): BelongsToMany
    {
        return $this->belongsToMany('App\User', 'follows', 'follower_id', 'followee_id')->withTimestamps();
    }
    // フォロワー数を表示アクセサ
    public function getCountFollowersAttribute(): int
    {
        return $this->followers->count();
    }
    // フォロー数を表示アクセサ
    public function getCountFollowingsAttribute(): int
    {
        return $this->followings->count();
    }
}
