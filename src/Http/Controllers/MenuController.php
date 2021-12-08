<?php

namespace DevSobSud\MenuManager\Http\Controllers;

use DevSobSud\MenuManager\Http\Controllers\Controller;
use DevSobSud\MenuManager\Models\Menu, View, Redirect, DB, Datatables, Config, Request;
use DevSobSud\MenuManager\Models\MenuItem;
use Illuminate\Http\Request as httpRequest;
use Illuminate\Http\JsonResponse;

class MenuController extends Controller
{
    protected $model;
    protected $route;

    public function __construct()
    {
        $this->model = new Menu;
        $this->route = 'menu-manager.menus';
    }

    public function index()
    {
        if(Request::ajax()){
            $menus = $this->model->select('id', 'name', 'position', 'status', 'updated_at');
            return $this->getCollection($menus);
        }
        return view('menumanager-views::menus.index');
    }

    protected function setDTData($records)
    {
        foreach ($records as $key => $value) {
            $records[$key]['edit_action'] = '<a href="'.route($this->route.'.edit', ['id'=>encrypt($value['id'])]).'">Edit</a>';
            $records[$key]['delete_action'] = '<a href="'.route($this->route.'.destroy', ['id'=>encrypt($value['id'])]).'" class="menu-delete">Delete</a>';
            $records[$key]['status'] = ($value['status'] == 1)?'<a href="'.route($this->route.'.change-status', [encrypt($value['id'])]).'" class="status-change">Disable</a>':'<a href="'.route($this->route.'.change-status', [encrypt($value['id'])]).'" class="status-change">Enable</a>';
        }
        return $records;
    }

    public function create()
    {
        return view('menumanager-views::menus.form')->with('obj', new Menu() );
    }

    public function edit($id) {
        $id = decrypt($id);
        if($obj = $this->model->find($id)){
            $obj->menu_items = $this->menu_tree($id, 0);
            return view('menumanager-views::menus.form', ['obj'=>$obj]);
        } else {
            abort('404');
        }
    }

    public function store()
    {
        $this->model->validate();
        $data = request()->all();
        $this->model->fill($data);
        $this->model->save();
        $menu_settings = json_decode($data['menu_settings']);
        if(isset($data['menu']))
            $this->store_recurssion($menu_settings, $data['menu'], 0, $this->model->id);
        return Redirect::to(route($this->route.'.edit', ['id'=>encrypt($this->model->id)]))->withSuccess('Menu successfully added!');
    }

    public function store_recurssion($menu_settings, $menu, $parent=0, $menu_id)
    {
        if($menu_settings)
        {
            foreach ($menu_settings as $key => $setting) {
                $id = $setting->id;
                if(isset($menu[$id]))
                {
                    $item_array = explode('-', $id);
                    $obj = new MenuItem;
                    $obj->menu_id = $menu_id;

                    if($item_array[0] == 'custom_link')
                    {
                        $obj->url = $menu[$id]['url'];
                        $obj->target_blank = (isset($menu[$id]['target_blank']))?1:0;
                        $obj->external_link = (isset($menu[$id]['external_link']))?1:0;
                        $obj->original_title = $menu[$id]['original_title'];
                    }
                    else{
                        $config_menu = Config('admin.menu.items');
                        foreach($config_menu as $config_item)
                        {
                            if(method_exists($config_item['model'], 'create_admin_menu')){
                                if($item_array[0] == $config_item['identifier'].'_link')
                                {
                                    $obj->linkable_type = $config_item['model'];                     
                                    $obj->linkable_id = $menu[$id]['id'];

                                    break;
                                }
                            }
                        }
                                                    
                    }
                    $obj->title = $menu[$id]['text'];
                    $obj->image_url = $menu[$id]['image_url'];
                    $obj->icon_class = $menu[$id]['icon'];
                    $obj->menu_order = $key;
                    $obj->menu_type = $item_array[0];
                    $obj->parent_id = $parent;
                    $obj->menu_nextable_id = $menu[$id]['menu_nextable_id'];
                    $obj->save();
                    if(isset($setting->children))
                        $this->store_recurssion($setting->children, $menu, $obj->id, $menu_id);
                }
            }
        }
    }


    public function menu_tree($menu_id, $parent)
    {
        $items = MenuItem::where('menu_id', $menu_id)->where('parent_id', $parent)->orderBy('menu_order')->get();
        if($items)
        {
            foreach ($items as $key => $item) {
                if($item->children())
                {
                    $item['children'] = $this->menu_tree($menu_id, $item->id);
                }
            }
        }
        return $items;
    }

    public function update() {
        $data = request()->all();
        $id =  decrypt($data['id']);
        $this->model->validate($data, $id);
        if($obj = $this->model->find($id)){
            $obj->update($data);
            MenuItem::where('menu_id', $obj->id)->forcedelete();
            $menu_settings = json_decode($data['menu_settings']);
            if(isset($data['menu']))
                $this->store_recurssion($menu_settings, $data['menu'], 0, $obj->id);
            return Redirect::to(route($this->route.'.edit', ['id'=>encrypt($obj->id)]))->withSuccess('Menu successfully updated!');
        }
        else {
            return Redirect::back()
                    ->withErrors("Ooops..Something wrong happend.Please try again.") // send back all errors to the login form
                    ->withInput(request()->all());
        }
    }

    public function changeStatus($id)
    {
        $id = decrypt($id);
        $obj = $this->model->find($id);
        if ($obj) {
            $status = $obj->status;
            $set_status = ($status == 1)?0:1;
            $obj->status = $set_status;
            $obj->save();
            $message = ($status == 1)?"disabled":"enabled";
            return response()->json(['message'=>'Menu successfully '.$message.'!']);
        }
        return response()->json(['message'=>'Oops!! something went wrong...Please try again.']);
    }

    public function destroy($id) {
        $id = decrypt($id);
        $obj = $this->model->find($id);
        if ($obj) {
            $obj->menu_items()->delete();
            $obj->delete();
            return response()->json(['message'=>'Menu successfully deleted!']);
        }
        return response()->json(['message'=>'Oops!! something went wrong...Please try again.']);
    }
}
