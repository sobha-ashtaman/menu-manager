$(function(){
            if($('#dataTable').length)
            {
                initDataTable(); 
            }

            var validator = $("#MenuFrm").validate({
                ignore: [],
                errorPlacement: function(error, element){
                    $(element).each(function (){
                        $(this).parent('div').find('span.error').html(error);
                    });
                },
                rules: {
                  name: "required",
                  menu_settings: "required",
                },
                messages: {
                  name: "Enter menu name",
                  menu_settings: "Setup a menu using menu settings",
                },
            });

            $(document).on('click', '#save-btn', function(){
              if($('.dd').nestable('serialize') != '')
                $('#inputMenuSettings').val(JSON.stringify($('.dd').nestable('serialize')));
              if($("#MenuFrm").valid())
              {
                $('#MenuFrm').submit();
              }
            });

            $('.dd').nestable({ 
                expandBtnHTML: '',
                collapseBtnHTML: ''
            });

            $(document).on('click', '#add-custom-links', function(){
                var name = $('#inputCustomLinkText').val();
                var url = $('#inputCustomUrl').val();
                var url = $('#inputCustomUrl').val();
                var image_url = $('#inputCustomLinkImageUrl').val();
                var icon = $('#inputCustomIcon').val();
                if(name != '' && url != '')
                {
                    $('#inputCustomLinkText').removeClass('errorBox');
                    $('#inputCustomUrl').removeClass('errorBox');
                    var id = 'custom_link-'+name;
                    var target_blank = 0;
                    var checked = "";
                    var external_checked = "";
                    if($("#inputTarget").is(":checked"))
                    {
                      target_blank = 1
                      checked = "checked";
                    }

                    if($("#inputExternal").is(":checked"))
                    {
                      external_checked = "checked";
                    }

                    var inner_html = '<div class="dd-handle accord-header"><span class="menu-title">'+name+'</span><span class="float-end dd-nodrag"><img src="'+base_url+'/vendor/menu/images/down-arrow.png"/></span></div><div class="accord-content"><div class="form-group mb-2"><label class="control-label" for="inputCode">Navigation Label</label><input type="text" name="menu['+id+'][text]" class="form-control menu-title-input" value="'+name+'"/></div><div class="form-group mb-2"><label for="exampleInputPassword1">Image Link</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text">'+base_url+'</span></div><input type="text" class="form-control" name="menu['+id+'][image_url]" value="'+image_url+'" id="inputCustomLinkImageUrl'+id+'"></div></div><div class="form-group mb-2"><label for="exampleInputPassword1">Icon class</label><input type="text" name="menu['+id+'][icon]" class="form-control" value="'+icon+'"></div><div class="form-group mb-2"><label class="control-label" for="inputCode">Url</label><input type="text" name="menu['+id+'][url]" class="form-control" value="'+url+'"/></div><div class="form-group mb-2 clearfix"><div class="checkbox float-start"><input type="checkbox" class="me-1" name="menu['+id+'][target_blank]" '+checked+' id="target-'+id+'"/><label for="target-'+id+'"> New Window</label></div><div class="checkbox float-end"><input type="checkbox" class="me-1" name="menu['+id+'][external_link]" '+external_checked+' id="external-'+id+'"/><label for="external-'+id+'"> External Link</label></div></div><input type="hidden" name="menu['+id+'][menu_nextable_id]" value="'+id+'"/><input type="hidden" name="menu['+id+'][original_title]" value="'+name+'"/><p class="menu-original-text"> Original: '+name+'</p><p><a href="javascript:void(0)" class="remove-menu">Remove</a></p></div>';
                    var html = '<li class="dd-item" data-id="'+id+'">'+inner_html+'</li>';
                    $('.dd > .dd-list').append(html);
                    $('.dd').nestable();
                    $('#inputCustomLinkText').val('');
                    $('#inputCustomUrl').val('');
                }
                else{
                  if(name == "")
                    $('#inputCustomLinkText').addClass('errorBox');
                  else
                    $('#inputCustomLinkText').removeClass('errorBox');

                  if(url == "")
                    $('#inputCustomUrl').addClass('errorBox');
                  else
                    $('#inputCustomUrl').removeClass('errorBox');
                }
            });

          $(document).on('click', '.custom-accordion .accord-header', function(){
                if($(this).next("div").is(":visible")){
                  $(this).next("div").slideUp("slow");
                  $(this).find('.toggle-arraow').removeClass('fa-angle-up').addClass('fa-angle-down');
                } else {
                  $(".custom-accordion .accord-content").slideUp("slow");
                  $('.toggle-arraow').each(function(i, e) {
                    $(this).removeClass('fa-angle-up').addClass('fa-angle-down');
                  });
                  $(this).next("div").slideToggle("slow");
                  $(this).find('.toggle-arraow').addClass('fa-angle-up').removeClass('fa-angle-down');
                }
            });

            $(document).on('click', '.custom-accordion-menu .accord-header', function(){
                if($(this).next("div").is(":visible")){
                  $(this).next("div").slideUp("slow");
                  $(this).find('.toggle-arraow').removeClass('fa-angle-up').addClass('fa-angle-down');
                } else {
                  $(".custom-accordion-menu .accord-content").slideUp("slow");
                  $('.toggle-arraow').each(function(i, e) {
                    $(this).removeClass('fa-angle-up').addClass('fa-angle-down');
                  });
                  $(this).next("div").slideToggle("slow");
                  $(this).find('.toggle-arraow').addClass('fa-angle-up').removeClass('fa-angle-down');
                }
            });

            $(document).on('click', '.remove-menu', function(){
              $(this).parents('.accord-content').parent().remove();
              $('.dd').nestable();
            });

            $(document).on('keyup', '.menu-title-input', function(){
              $(this).parents('.accord-content').siblings('.accord-header').find('.menu-title').html($(this).val());
            })
})

