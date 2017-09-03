$(document).ready(function(){

	var working = false;
	
	// Listening for the submit
	$('#addCommentForm').submit(function(e){

 		e.preventDefault();
		if(working) return false;
		
		working = true;
		$('#submit').val('Working..');
		$('span.error').remove();
		
		//Sending the form fileds to submit.php
		$.post('submit.php',$(this).serialize(),function(msg){

			working = false;
			$('#submit').val('Submit');
			
			if(msg.status){

				$(msg.html).hide().appendTo('#content').slideDown();
				$('#body').val('');
			}
			else {

				//	If errors
				$.each(msg.errors,function(k,v){
					$('label[for='+k+']').append('<span class="error">'+v+'</span>');
				});
			}
		},'json');

	});
	
});

//Delete
 $(document).on('click', '.del', function(){
  var com_id = $(this).attr("id");
  if(confirm("Are you sure you want to delete this?"))
  {
   $.ajax({
    url:"delete.php",
    method:"POST",
    data:{com_id:com_id},
    success:function(data)
    {
        $(".comment#d"+com_id).fadeOut(500, function() {
     	$comment = $(".comment#"+com_id).detach();
	 });
    }
   });
  }
  else
  {
   return false; 
  }
 });

//Edit start
$(document).on('click', '.edit', function(){
    var com_id = $(this).attr("id");

    $.ajax({
        url:"select.php",
        method:"POST",
        data:{com_id:com_id},
        dataType:"json",
        success:function(data)
        {
            $('#userModal').modal('show');
            $('#com_id').val(com_id);
            $('.form2').val(data.body);
        }
    })
});

//Edit finish
$(document).on('change', '.form2', function(){
    var com_id = $('#com_id').val();
    com_body = this.value;
    $.ajax({
        url:"edit.php",
        method:"POST",
        data:{com_id:com_id, body:this.value},
        success:function(data)
        {
            com_item = document.getElementById("d"+com_id).getElementsByClassName("body");
            com_item[0].innerHTML=com_body;
            $('#com_id').val(com_id);
            $('#userModal').modal('hide');

        },
        //If errors
        error: function (jXHR, textStatus, errorThrown) {
            alert(jXHR +textStatus + errorThrown);
        }
    })
});
//Sort order
$(document).on('click', '.name-a, .name-d, .email-a, .email-d, .date-a, .date-d', function(){
    var sort_id = this.innerHTML;
    $.ajax({
        url:"sort.php",
        method:"POST",
        data:{sort_id:sort_id},
        success:function(data)
        {
            content.innerHTML=data;
        }
    })
});


