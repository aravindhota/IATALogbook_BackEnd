<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';

    protected $fillable = [
        'name', 'email', 'phone', 'address'
    ];

    /**
     * The clients have a ManyToMany relation, because a client can contract many services.
     */
    public function services()
    {
        return $this -> belongsToMany(Service::class, 'clients_services');
    }
}
