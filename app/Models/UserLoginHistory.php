<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLoginHistory extends Model
{
    use HasFactory;
    protected $table = 'user_login_history';

    protected $fillable = [
        'user_id',
        'ip_address',
        'organization_id',
        'login_at',
    ];
    
    public $timestamps = false;


    public function user(){
        return $this->belongsTo(User::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
