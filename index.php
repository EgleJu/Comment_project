<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Comment page</title>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>

<script
  src="https://code.jquery.com/jquery-3.4.1.js"
  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  crossorigin="anonymous"></script>


<body>
<h2 align="center"
class="border-bottom border-dark p-3 "> Comment form </h2>

<div class="container col-sm-7">

  <form method="POST" id="comment_form">
    <div class="form-row">
        <div class="form-group col-md-3">
          <label for="comment_email">Email*</label>
          <input type="text" name="comment_email" id="comment_email" class="form-control" >
        </div>
        <div class="form-group col-md-3">
          <label for="comment_name">Name*</label>
          <input type="text" name="comment_name" id="comment_name" class="form-control"  >
        </div>
      </div>
      <div class="form-group ">
        <label for="comment_content">Comment*</label>
        <textarea name="comment_content" type="text" class="form-control" id="comment_content" rows="4"></textarea>
      </div >
      <div class="form-group">
          <input type="hidden" name="comment_id" id="comment_id" value="0"/>
          <input type="submit" name="submit" id="submit" class="btn btn-success" value="Submit"/>
      </div>
  </form>
  <span id="comment_message"></span>
  <br />
  <div id="display_comment"></div>
</div>


</body>
</html>

<script>


$(document).ready(function() {

    $('#comment_form').on('submit', function(event){
      event.preventDefault();
      var form_data = $(this).serialize();
      $.ajax({
        url:"comment_section.php",
        method:"POST",
        data:form_data,
        dataType:"JSON",
        success:function(data)
        {
          if(data.error != '')
          {
            $('#comment_form')[0].reset();
            $('#comment_message').html(data.error);
            $('#comment_id').val('0');
            load_comment();

          }
        }
      })
    });

    load_comment();

    function load_comment()
    {
      $.ajax({
        url:"upload_comment.php",
        method: "POST",
        success:function(data)
        {
          $('#display_comment').html(data);
        }
      })
    }



$(document).on('click', '.reply', function() {
  var comment_id = $(this).attr("id");
  $('#comment_id').val(comment_id);
  $('#comment_email').focus();

});

});


</script>
