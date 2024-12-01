<?php

namespace App\Models;

<<<<<<< HEAD
use Illuminate\Database\Eloquent\Model;

namespace App\Models;

=======
>>>>>>> test
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

<<<<<<< HEAD
    protected $fillable = [
        'user_id',
        'forum_id',
        'body',
    ];
=======
    protected $fillable = ['user_id', 'thread_id', 'parent_comment_id', 'body'];
>>>>>>> test

    public function user()
    {
        return $this->belongsTo(User::class);
    }

<<<<<<< HEAD
    public function forum()
    {
        return $this->belongsTo(Forum::class);
=======
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function parentComment()
    {
        return $this->belongsTo(Comment::class, 'parent_comment_id');
    }

    public function childComments()
    {
        return $this->hasMany(Comment::class, 'parent_comment_id');
    }
    public function upvotes()
    {
        return $this->morphMany(Upvote::class, 'votable');
    }
    public function upvoteCount()
    {
        return $this->upvotes()->where('vote_type', 'upvote')->count();
    }

    public function downvoteCount()
    {
        return $this->upvotes()->where('vote_type', 'downvote')->count();
>>>>>>> test
    }
}
