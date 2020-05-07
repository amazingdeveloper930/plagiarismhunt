var BASE_URL = $("#base_url").val();

function sw_simple_alert(type, message)
  {
    Swal.fire({
        type: type,
        title: message,
        showConfirmButton: true,
      });
  }

function deleteProject(token)
{
    Swal.fire({
        title: 'Do you want to delete this report?',
        text: "If you delete the report, you can't see that anymore.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Delete'
      }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "get",
                dataType: "json",
                url: "/deletefile/" + token,
             
                success: function(response){
                    if(response.status == 'success')
                    {
                        sw_simple_alert('success', "Successfully deleted");
                        $("#project-" + token).remove();
                    }
                    else
                    {
                        sw_simple_alert('error', response.error_code);
                    }
                },
                error: function(jqXhr1, textStatus1, errorThrown1){
                    sw_simple_alert('error', 'unknown error');
                }
                });
        }
      })
}