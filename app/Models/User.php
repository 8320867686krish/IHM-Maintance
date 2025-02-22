<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role as ModelsRole;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
        'hazmat_companies_id',
        'phone',
        'image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function hazmatCompaniesId()
    {
        return $this->belongsTo(hazmatCompany::class,'hazmat_companies_id','id');

    }
    public function ships(){
        return $this->belongsToMany(Ship::class, 'ship_teams', 'user_id', 'ship_id');

    
       }
       public function hazmatCompany()
       {
           return $this->belongsTo(hazmatCompany::class,'hazmat_companies_id','id');
       }

       public function clientCompany(){
        return $this->hasOne(ClientCompany::class,'user_id','id');

       }

       public function shipClient(){
        return $this->hasOne(Ship::class,'user_id','id');

       }
       public function designatedPerson(){
        return $this->hasMany(DesignatedPerson::class, 'ship_staff_id', 'id');

       }
      
}
