<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;


class Task extends Model
{
    use HasFactory;

    const PER_PAGE = 20;

    protected $fillable = [
        'title',
        'description',
        'assign_to',
        'created_by',
        'status'
    ];

    public function getCreatedAttribute()
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }



    static function getTasks(): LengthAwarePaginator
    {
        return self::isUser()->with(['createdBy'   , 'assignTo'  ])->latest()->paginate( self::PER_PAGE );
    }

    public function scopeIsUser($q){
        if(auth()->user()->role == config('app.roles.user')){
            $q->byUser();
        }
        return $q;
    }

    public function scopeByUser($q)
    {
        return $q->where(function ($q) {
                $q->where('created_by', auth()->id())
                ->orWhere('assign_to', auth()->id());
        });
    }


    public function createdBy()
    {
        return $this->belongsTo(User::class,   'created_by', 'id');
    }

    public function assignTo()
    {
        return $this->belongsTo(User::class,   'assign_to', 'id');
    }


}
