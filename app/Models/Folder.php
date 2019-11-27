<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Folder extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'parent_id'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * Get the parent of the folder
     */
    public function parent()
    {
        return $this->belongsTo('App\Models\Folder', 'parent_id');
    }

    /**
     * Get the list of sub folder of the folder
     */
    public function subFolders()
    {
        return $this->hasMany('App\Models\Folder', 'parent_id');
    }

    /**
     * Get the list of files of the folder
     */
    public function files()
    {
        return $this->belongsTo('App\Models\File', 'folder_id');
    }
}
