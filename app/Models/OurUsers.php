<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OurUsers extends Model
{
    use HasFactory;

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'our_users';

    public function links() {
        return $this->hasMany('\App\Models\Links', 'user_id')
            ->orderBy('updated_at', 'desc')
            ->select('name', 'updated_at')
            ->groupBy('name')
            ->paginate(10);
    }
}
