<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecklistItem extends Model
{
    use HasFactory;

    protected $fillable = ['checklist_id', 'item_name', 'completed'];

    // Relasi ke Checklist
    public function checklist()
    {
        return $this->belongsTo(Checklist::class);
    }
}
