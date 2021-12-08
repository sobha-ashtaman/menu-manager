<?php 
namespace DevSobSud\MenuManager\Models;

use Illuminate\Database\Eloquent\Model;
use Schema, Auth;
use Illuminate\Http\Request;

class BaseModel extends Model {

    public static function boot() {
        parent::boot();
        $input = request()->all();
        static::creating(function ($model) {
            if(Schema::hasColumn($model->getTableName(), 'created_by')) {
                if($user = Auth::user())
                    $model->created_by = $user->id;
            }
        });
        
        static::saving(function ($model) {
            if(Schema::hasColumn($model->getTableName(), 'updated_by')) {
                if($user = Auth::user())
                    $model->updated_by = $user->id;
            }
            // return true;
        });
    }
    
    protected static function setNullWhenEmpty($model) {
        foreach ($model->attributes as $key => $value) {
            if ( trim(strip_tags($value)) == '' && (!is_bool($value)) ) {
                $model->{$key} = null;
            }
        }
    }
    
    public static function getTableName() {
        return with(new static)->getTable();
    }

}
