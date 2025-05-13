<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'activity_logs';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'action',
        'description',
        'user_id',
    ];

    /**
     * Get the user that owns the activity log.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Log an activity
     * 
     * @param string $action
     * @param string $description
     * @param int|null $userId
     * @return ActivityLog
     */
    public static function log($action, $description, $userId = null)
    {
        return self::create([
            'action' => $action,
            'description' => $description,
            'user_id' => $userId,
        ]);
    }
}
