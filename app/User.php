<?php

namespace App;

use App\Mailer\UserMailer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'confirmation_token', 'api_token', 'settings'
    ];

    protected $casts = [
        'settings' => 'array'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function settings()
    {
        return new Setting($this);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function sendPasswordResetNotification($token)
    {
        (new UserMailer())->passwordReset($this->email, $token);
    }

    public function owns(Model $model)
    {
        return $this->id == $model->user_id;
    }

    public function follows()
    {
        return $this->belongsToMany(Question::class, 'user_question')->withTimestamps();
    }

    public function followThis($questionId)
    {
        return $this->follows()->toggle($questionId);
    }

    public function followed($questionId)
    {
        return !!$this->follows()->where('question_id', $questionId)->count();
    }

    public function followers()
    {
        return $this->belongsToMany(self::class, 'followers', 'follower_id', 'followed_id')->withTimestamps();
    }

    public function followersUser()
    {
        return $this->belongsToMany(self::class, 'followers', 'followed_id', 'follower_id')->withTimestamps();
    }

    public function followThisUser($userId)
    {
        return $this->followers()->toggle($userId);
    }

    public function votes()
    {
        return $this->belongsToMany(Answer::class, 'votes')->withTimestamps();
    }

    public function voteFor($answer)
    {
        return $this->votes()->toggle($answer);
    }

    public function hasVotedFor($answerId)
    {
        return !!$this->votes()->where('answer_id', $answerId)->count();
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'to_user_id');
    }

    public function actions()
    {
        return $this->hasMany(Action::class);
    }

    public function timelines()
    {
        return $this->hasMany(Timeline::class);
    }
}
