$(function(){

    var table = $('#dataTable');
    var ajaxUrl = table.data('datatable-ajax-url');
    var dt_table = table.DataTable({
          processing: true,
          serverSide: true,
          ajax: ajaxUrl,
          columns: dt_columns
    });

    $(document).on('click', '.status-change', function(event){
        event.preventDefault();
        var url = $(this).attr('href');
        $.get(url, function(data){
            alert(data.message);
            dt_table.ajax.reload();
        })
    });

    $(document).on('click', '.menu-delete', function(event){
        event.preventDefault();
        var that = $(this);
        var url = that.attr('href');
        var confirm = window.confirm("Are you sure?");
        if(confirm == true)
        {
            $.get(url, function(data){
                alert(data.message);
                dt_table.ajax.reload();
            })
        }
    })
});