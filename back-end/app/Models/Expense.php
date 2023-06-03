<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'expenses_date',
        'price',
        'user_id'
    ];

    protected $hidden = [];

    public function User() {
        $this->belongsTo(User::class);
    }
}
