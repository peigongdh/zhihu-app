<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    protected $fillable = ['user_id', 'event', 'actionable_id', 'actionable_type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function actionable()
    {
        return $this->morphTo();
    }

    public function scopeNotUndo($query)
    {
        return $query->where('undo', 'F');
    }
}
