<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function action()
    {
        return $this->belongsTo(Action::class);
    }
}
