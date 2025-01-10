<?php
namespace App\Models;
use App\Models\ComplaintAttachment;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Complaint extends BaseModel
{
    use HasFactory;

    protected $fillable = ['userable_id', 'userable_type', 'type' ,'email','type' , 'complaint_msg','complaint_num', 'admin_seen', 'admin_replay'];

    public function userable()
    {
        return $this->morphTo('userable');
    }
    
    public function user()
	{
		return $this->belongsTo(User::class, 'user_id', 'id');
	}
    public function replays()
    {
        return $this->hasMany(ComplaintReplay::class, 'complaint_id', 'id'); 
    }

    // public static function boot(): void
    // {
    //     parent::boot();
    //     self::creating(function ($model) {
    //         $lastId = self::max('id') ?? 0;
    //         $model->complaint_num = date('Y') . ($lastId + 1);
    //     });
    // }
}
