<?php

namespace DevSobSud\MenuManager\Models;

use DevSobSud\MenuManager\Models\BaseModel as Model;
use Validator;

class Menu extends Model
{

    protected $table = 'menus';

    protected $fillable = array('name', 'position', 'title', 'status');

    protected $dates = ['created_at','updated_at'];

    public function validate($data=null)
    {
        $data = $data ? $data : request()->all();
        $validator = Validator::make($data, [
            'name' => 'required|max:250',
            'position' => 'required'
        ]);
        if ($validator->fails()) {
            $response = Redirect::back()->withInput()->withErrors($this->errors);
            throw new HttpResponseException($response);
        }
    }

    public function menu_items()
    {
        return $this->hasMany('DevSobSud\MenuManager\Models\MenuItem');
    }

    public function parent_menu_items()
    {
        return $this->menu_items()->where('parent_id',0);
    }
}
