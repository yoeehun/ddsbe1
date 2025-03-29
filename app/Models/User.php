<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class User extends Model {
    protected $table = 'tbluser';
    protected $fillable = ['username', 'password', 'gender', 'jobid'];
    public function job()
    {
        return $this->belongsTo(UserJob::class, 'jobid'); // Reference jobid in tbluserjob
    }
}