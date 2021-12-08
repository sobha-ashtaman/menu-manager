<?php

namespace DevSobSud\MenuManager\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{

    protected $table = 'menu_items';

    protected $fillable = array('menu_id', 'title', 'original_title', 'url', 'menu_type', 'menu_nextable_id', 'linkable_id', 'linkable_type', 'menu_order', 'parent_id', 'target_blank', 'external_link', 'image_url', 'icon_class');

    protected $dates = ['created_at','updated_at'];

    public function children()
    {
        return $this->hasMany('DevSobSud\MenuManager\Models\MenuItem', 'parent_id', 'id');
    }

    public function linkable()
    {
        return $this->morphTo();
    }
}
