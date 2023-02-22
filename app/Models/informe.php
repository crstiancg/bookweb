<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class informe extends Model
{
    use HasFactory;

    protected $fillable = ['info_pdf'];

    //protected $fillable = ['doce_id', 'cate_id', 'au_id'];
    //return $this->belongsTo(Autor::class, 'au_id', 'id');

    protected $casts = [
        'info_fecha' => 'datetime',
    ];
    
    public function autor(){
        return $this->belongsTo(Autor::class);
    }

    public function docente(){
        return $this->belongsTo(Docente::class);
    }

    public function categoria(){
        return $this->belongsTo(Categoria::class);
    }

}
