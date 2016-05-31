<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chats extends Model
{
    protected $table ="chats";

    protected $fillable = ['usuario', 'mensaje',]; //fillable <-- Para indicarle que campos quieres llenar.

    protected $primaryKey = 'id';

    public $timestamps = false;
}
