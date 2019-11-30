<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use SoftDeletes;

    /**
     * The name of the table into the database
     * @var string
     */
    protected $table = 'file';

    /**
     * Use or not the timestamp
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'folder_id', 'url', 'type', 'size'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function folder()
    {
        return $this->belongsTo('App\Models\Folder', 'folder_id');
    }
}
