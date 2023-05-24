<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'price'
    ];

    /**
     * The services have a ManyToMany relation, because a service can be contracted by many clients.
     */
    public function clients()
    {
        return $this -> belongsToMany(Client::class, 'clients_services');
    }
}
