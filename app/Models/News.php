<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * News Model
 *
 * Represents the "news" table in the database.
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property int $user_id
 * @property string $create_time
 * @property string $update_time
 * @property-read \App\Models\User $user
 */
class News extends Model
{
    use HasFactory;

    // Table name associated with the News model
    protected $table = 'news'; // news

    // Fillable attributes for mass assignment
    protected $fillable = ['title', 'content', 'user_id', 'create_time', 'update_time'];

    // Disable Laravel's automatic timestamps
    public $timestamps = false;

    // Specify the field name for the created timestamp
    const CREATED_AT = 'create_time';

    /**
     * Relationship: News belongs to a User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

