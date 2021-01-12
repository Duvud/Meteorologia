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
    protected $primaryKey = 'id';
    protected $table = 'baliza';
    protected $fillable = ['nombre','temperatura','humedad','vel_aire'];
    use HasFactory;
}
