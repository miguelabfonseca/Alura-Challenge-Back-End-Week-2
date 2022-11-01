<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = ['categoriaId', 'titulo', 'descricao', 'url'];

    public function categoria()
    {
        return $this->hasOne(Categoria::class, 'id', 'categoriaId');
    }
}
