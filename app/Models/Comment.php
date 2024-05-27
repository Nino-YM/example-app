<?php

use App\Models\Post;
use App\Models\User;


class Comment extends Model
{
    use HasFactory;
    // nom de la fonction au singulier car 1 seul message en relation
    // cardinalité 1,1
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
    // idem
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}