<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['completed_at'];

    public function scopeMine($query, $user = null)
    {
        $user = $user ?: auth()->user();
        $query->where('user_id', $user->id);
    }

    public function complete()
    {
        $this->update([
            'completed_at' => now()
        ]);

        return $this;
    }
}
