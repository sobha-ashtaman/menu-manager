<x-menumanager-app-layout>
    <x-slot name="header">
        <link rel="stylesheet" type="text/css" href="{{ asset('vendor/menu/css/menu.css') }}">
    </x-slot>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6"></div>
            <div class="col-md-6 float-left"><a href="" class="btn btn-primary float-end">Create New</a></div>
        </div>
    </div>
    <div class="container mt-4">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="card">
                                <div class="card-body">
                                    @if($obj->id)
                                        <form method="POST" action="{{ route('menu-manager.menus.update') }}" class="p-t-15" id="MenuFrm" data-validate=true>
                                    @else
                                        <form method="POST" action="{{ route('menu-manager.menus.store') }}" class="p-t-15" id="MenuFrm" data-validate=true>
                                    @endif
                                    @csrf
                                    <input type="hidden" name="id" @if($obj->id) value="{{encrypt($obj->id)}}" @endif id="inputId">
                                        <div class="row">
                                            <div class="col-12">
                                                <div data-simplebar>
                                                    <div class="tab-content chat-list" id="pills-tabContent" >
                                                        <div class="tab-pane fade show active" id="tab1">
                                                            <div class="row m-0">
                                                                <div class="form-group col-md-6">
                                                                    <label for="name">Menu Name</label>
                                                                    <input type="text" class="form-control" id="name" name="name" value="{{$obj->name}}">
                                                                    <span class="error"></span>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label for="email">Position</label>
                                                                    <select id="position" class="form-control webadmin-select2-input" name="position">
                                                                        @php
                                                                            $postions = Config('menu.positions');
                                                                        @endphp
                                                                        @foreach($postions as $position)
                                                                            <option value="{{$position}}" @if($obj->position == $position) selected="selected" @endif>{{$position}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    <label for="password">Menu Title</label>
                                                                    <input type="text" class="form-control" id="title" name="title" value="{{$obj->title}}">
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr/>
                                        <div class="row">
                                            <div class="col-md-5"> 
                                              <div class="card" style="background-color: #fff !important">
                                               
                                                <div class="card-body">
                                                  <div class="form-group mb-2">
                                                    <label for="exampleInputPassword1">Link Text</label>
                                                    <input type="text" name="custom_link_text" class="form-control" id="inputCustomLinkText">
                                                  </div>
                                                  <div class="form-group mb-2">
                                                    <label for="exampleInputPassword1">Image Link</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">{{asset('/')}}</span>
                                                        </div>
                                                        <input type="text" class="form-control" name="custom_link_image_url" id="inputCustomLinkImageUrl">
                                                    </div>
                                                  </div>
                                                  <div class="form-group mb-2">
                                                    <label for="exampleInputPassword1">Icon Class</label>
                                                    <input type="text" name="custom_link_icon" class="form-control" id="inputCustomIcon">
                                                  </div>
                                                  <div class="form-group mb-2">
                                                    <label for="exampleInputPassword1">Url</label>
                                                    <input type="text" name="custom_url" class="form-control" id="inputCustomUrl">
                                                  </div>
                                                  <div class="form-group mb-2 clearfix">
                                                    <div class="checkbox float-start">
                                                      <input type="checkbox" id="inputTarget" class="me-1"><label for="inputTarget"> New Window</label>
                                                    </div>
                                                    <div class="checkbox float-end">
                                                      <input type="checkbox" id="inputExternal" class="me-1"><label for="inputExternal"> External Link</label>
                                                    </div>
                                                  </div>
                                                  <div class="form-group mb-2">
                                                      <button type="button" id="add-custom-links" class="btn btn-primary btn-sm">Add to Menu</button>
                                                  </div>
                                                </div>
                                              </div> 
                                            </div>
                                            <div class="col-md-7">
                                              
                                                <div class="dd">
                                                  <ol class="dd-list custom-accordion-menu">
                                                    @if($obj->id && $obj->menu_items)
                                                      @include('menumanager-views::menus._partials.menu_items', ['items'=>$obj->menu_items])
                                                    @endif
                                                  </ol>
                                              </div>
                                              <input type="hidden" name="menu_settings" id="inputMenuSettings">
                                              <span class="error"></span>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-12 text-end">
                                                <a href="{{route('menu-manager.menus.index')}}" class="btn btn-soft-primary">Back to List</a>
                                                <button type="button" id="save-btn" class="btn btn-primary px-4">Submit</button>
                                            </div>
                                        </div>
                                    </form>                                                                   
                                </div><!--end card-body-->
                            </div><!--end card-->
                    </div>
                </div>
            </div>
        </div>
    </div>
<x-slot name="footer">
      <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
      <script src="{{ asset('vendor/menu/js/jquery.nestable.js') }}"></script>
      <script src="{{ asset('vendor/menu/js/menu.js') }}"></script>
</x-slot>
</x-app-layout>
