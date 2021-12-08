<x-menumanager-app-layout>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6"></div>
            <div class="col-md-6 float-left"><a href="{{route('menu-manager.menus.create')}}" class="btn btn-primary float-end">Create New</a></div>
        </div>
    </div>
    <div class="container mt-4">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <table id='dataTable' data-datatable-ajax-url="{{route('menu-manager.menus.index')}}" >
                          <thead>
                            <tr>
                              <td>S.no</td>
                              <td>Name</td>
                              <td>Position</td>
                              <td>Status</td>
                              <td>Edit</td>
                              <td>Delete</td>
                            </tr>
                          </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<x-slot name="footer">
    <script type="text/javascript">
        
            var dt_columns = [
                    { data: 'id', name: 'id', searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'position', name: 'position' },
                    { data: 'status', name: 'status', searchable: false, sortable: false },
                    { data: 'edit_action', name: 'edit_action', searchable: false, sortable: false },
                    { data: 'delete_action', name: 'delete_action', searchable: false, sortable: false },
                 ];

            
    </script>
    <script src="{{ asset('vendor/menu/js/dt.js') }}"></script>
</x-slot>
</x-app-layout>
