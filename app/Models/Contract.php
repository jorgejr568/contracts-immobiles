<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $primaryKey = 'immobile_id';
    public $incrementing = false;

    const DOCUMENT_TYPE_ENTITY = 'ENTITY';
    const DOCUMENT_TYPE_ENTITY_LENGTH = 14;
    const DOCUMENT_TYPE_PERSON = 'PERSON';
    const DOCUMENT_TYPE_PERSON_LENGTH = 11;

    protected $fillable = [
        'immobile_id',
        'receiver_email',
        'receiver_name',
        'document_type',
        'document_number',
    ];

    public function immobile(){
        return $this->belongsTo(Immobile::class);
    }
}
