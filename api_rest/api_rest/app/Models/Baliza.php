<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
/**
 *
 * @mixin Builder
 *
 */
class Baliza extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $table = 'baliza';
    protected $fillable = ['id','nombre','provincia','temperatura','precipitacion','humedad','velocidad','y','z'];
    use HasFactory;
}
