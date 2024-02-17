$(document).ready(function(){

    $(".nav-item").removeClass["active"];
    $(".nav-link").removeClass["active"];
    // Check admin password is correct or not

    $("#current_password").keyup(function(){
        var current_password = $("#current_password").val();
        // alert(current_password);

        $.ajax({

            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            type:'post',
            url: '/admin/check-admin-password',
            data:{current_password:current_password},
            success:function(resp){
                // alert(resp);

                if(resp=="false"){
                    $("#check_password").html("<font color='red'> Current Password is incorrect!</font>");
                }
                else if(resp=="true"){

                    $("#check_password").html("<font color='green'> Current Password is correct!</font>");

                }
            },
            error:function(){
                alert('Error');
            }
        });
    })


    // Updating Of admin Status

    $(document).on("click",".updateAdminStatus", function()
    {
        // alert("test");
        var status = $(this).children("i").attr("status");
        var admin_id = $(this).attr("admin_id");

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/update-admin-status',
            data:{status:status,admin_id:admin_id},
            success:function(resp){
                // alert(resp);
                if(resp['status']==0)
                {
                    $("#admin-"+admin_id).html("<i style='font-size: 30px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>")
                }
                else if(resp['status']==1)
                {
                    $("#admin-"+admin_id).html("<i style='font-size: 30px;' class='mdi mdi-bookmark-check' status='Active'></i>")
                }
            },
            error:function(){
                alert("Error");
            }
        });
    });

    // Updating Of Section Status

    $(document).on("click",".updateSectionStatus", function()
    {
        // alert("test");
        var status = $(this).children("i").attr("status");
        var section_id = $(this).attr("section_id");

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/update-section-status',
            data:{status:status,section_id:section_id},
            success:function(resp){
                // alert(resp);
                if(resp['status']==0)
                {
                    $("#section-"+section_id).html("<i style='font-size: 30px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>")
                }
                else if(resp['status']==1)
                {
                    $("#section-"+section_id).html("<i style='font-size: 30px;' class='mdi mdi-bookmark-check' status='Active'></i>")
                }
            },
            error:function(){
                alert("Error");
            }
        });
    });
});
