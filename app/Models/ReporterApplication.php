<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReporterApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'district',
        'city',
        'id_proof_type',
        'id_proof_number',
        'experience',
        'motivation',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
