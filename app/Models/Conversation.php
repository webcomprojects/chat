<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'room_id', 'type'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'conversation_user', 'conversation_id', 'user_id')
            ->withPivot('type');
    }


    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function scopeGetRole($query)
    {
        $roles = ['owner', 'admin', 'user'];

        foreach ($roles as $role) {
            $clonedQuery = clone $query;

            if (
                $clonedQuery->whereHas('users', function ($q) use ($role) {
                    $q->where('users.id', auth()->id())
                        ->where('conversation_user.type', $role);
                })->exists()
            ) {
                return $role;
            }
        }

        return null;
    }



    public function scopeDataConversation($query)
    {
        return $query->with([
            'messages',
            'messages.user',
            'users' => function ($query) {
                $query->withPivot('type');
            }
        ])->first();
    }


}
