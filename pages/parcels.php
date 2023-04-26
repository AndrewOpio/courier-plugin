<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
<!--<link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet">-->
<link href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href = "https://cdn.datatables.net/datetime/1.2.0/css/dataTables.dateTime.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">

<script type ="text/javascript">
   //Adding a booking
   function addParcel(e)
    {
       e.preventDefault();

       var parcel_content = document.getElementById("parcel_content").value;
       var sending_date = document.getElementById("sending_date").value;
       var sender_name = document.getElementById("sender_name").value;
       var sender_contact = document.getElementById("sender_contact").value;
       var receiving_date = document.getElementById("receiving_date").value;
       var receiver_name = document.getElementById("receiver_name").value;
       var receiver_contact = document.getElementById("receiver_contact").value;
       var current_location = document.getElementById("current_location").value;
       var contact_person = document.getElementById("contact_person").value;
       var contact_person1 = document.getElementById("contact_person1").value;
       var location_note = document.getElementById("location_note").value;
       var destination = document.getElementById("destination").value;


       if (parcel_content == "" || sending_date == "" || destination == "" || sender_name == "" || sender_contact
        == "" || receiving_date == "" || receiver_name == "" || receiver_contact == "" || current_location == "" 
        || location_note == "" || contact_person == "" || contact_person1 == "") {
          alert("Please enter all required fields")
          return;
       }

       var save = document.getElementById("save").innerHTML ="saving...";

       var ajaxurl = '<?php echo admin_url('admin-ajax.php');?>';

       var data = {
            action: 'parcels',
            type: 'add',
            parcel_content,
            sending_date,
            sender_name,
            sender_contact,
            receiving_date,
            receiver_name,
            receiver_contact,
            current_location,
            contact_person,
            location_note,
            destination
       }

        $.ajax({ 
            url:ajaxurl,
            type:"POST",
            data: data,
            success : function( response ){

              //console.log(response);

                if ($.trim(response) == "success") {
                    alert("Parcel details submitted successfully.")
                    location.reload(true);

                } else if($.trim(response) == "failed") {
                    alert("An error occured.");
                    var save = document.getElementById("save").innerHTML ="save";

                }
            },

        });
    }


   //Deleting parcel
   function deleteParcel(id, parcel_number)
   {
      var ajaxurl = '<?php echo admin_url('admin-ajax.php');?>';
       //alert(id);
      var data = {
          action: 'parcels',
          type: 'delete',
          id: id,
          parcel_number
      };

      var del = document.getElementById("delete"+id).innerHTML ="Deleting...";

      $.post(ajaxurl, data, function(response) {
           if ($.trim(response) == "success") {
                alert("Parcel details deleted successfully.")
                location.reload(true);

            } else if($.trim(response) == "failed") {
                alert("An error occured.")
                var del = document.getElementById("delete"+id).innerHTML ="Delete";
            }
      }); 
   }


   //Updating a parcel
   function updateParcel(e, id)
   {
        e.preventDefault();

        var parcel_number = document.getElementById("parcel_number"+id).value;
        var parcel_content = document.getElementById("parcel_content"+id).value;
        var sending_date = document.getElementById("sending_date"+id).value;
        var sender_name = document.getElementById("sender_name"+id).value;
        var sender_contact = document.getElementById("sender_contact"+id).value;
        var receiving_date = document.getElementById("receiving_date"+id).value;
        var receiver_name = document.getElementById("receiver_name"+id).value;
        var receiver_contact = document.getElementById("receiver_contact"+id).value;
        var current_location = document.getElementById("current_location"+id).value;
        var contact_person = document.getElementById("contact_person"+id).value;
        var contact_person1 = document.getElementById("contact_person1"+id).value;
        var location_note = document.getElementById("location_note"+id).value;
        var destination = document.getElementById("destination"+id).value;


       if (current_location != "" || location_note != "") {
          if (location_note == "" || contact_person1 == "" || current_location == "") {
            alert("Please enter all required filds")
            return;
          }
       }

       if (parcel_content == "" || sending_date == "" || sender_name == "" || sender_contact
        == "" || receiving_date == "" || receiver_name == "" || receiver_contact == "" 
        || destination == "" || contact_person == "") {
          alert("Please enter all required fields")
          return;
       }

        var edit = document.getElementById("update" + id).innerHTML = "Updating...";

        var ajaxurl = '<?php echo admin_url('admin-ajax.php');?>';

        var data = {
            action: 'parcels',
            type: 'update',
            id,
            parcel_number,
            parcel_content,
            sending_date,
            sender_name,
            sender_contact,
            receiving_date,
            receiver_name,
            receiver_contact,
            current_location,
            location_note,
            contact_person,
            destination
        }

        $.ajax({ 
            url:ajaxurl,
            type:"POST",
            data: data,
            success : function( response ){  

              //console.log(response);

                if ($.trim(response) == "success") {
                    alert("Parcels details updated successfully.")
                    location.reload(true);

                } else if($.trim(response) == "failed") {
                    alert("An error occured.")
                    var edit = document.getElementById("update" + id).innerHTML = "Update";

                }
            },

        });
    }

</script>

<style>
  tr:nth-child(odd) {
    background-color: rgba(150, 212, 212, 0.4) !important;
  }

  @media (max-width: 768px){
    .dataTables_wrapper .dt-buttons {
        text-align-last: center;
        margin-top: 15px;
        margin-bottom: 15px;
    }
   } 

   @media (min-width: 769px){
    .dataTables_wrapper .dt-buttons {
      margin-top: 20px;
      margin-bottom: -30px;

    }
   } 

   button.multiselect {
        background-color: initial;
        border: 1px solid #8c8c8c;
    }
    ul.multiselect-container {height:200px;overflow-y:scroll;}
    input.multiselect-search {margin-top: 5px;}


</style>


<style type = "text/css">
.wrapper {
	 width: 330px;
	 font-family: 'Helvetica';
	 font-size: 14px;
}
 .StepProgress {
	 position: relative;
	 padding-left: 45px;
	 list-style: none;
}
 .StepProgress::before {
	 display: inline-block;
	 content: '';
	 position: absolute;
	 top: 0;
	 left: 15px;
	 width: 10px;
	 height: 100%;
}
 .StepProgress-item {
	 position: relative;
	 counter-increment: list;
}
 .StepProgress-item:not(:last-child) {
	 padding-bottom: 20px;
}
 .StepProgress-item::before {
	 display: inline-block;
	 content: '';
	 position: absolute;
	 left: -30px;
	 height: 100%;
	 width: 10px;
}
 .StepProgress-item::after {
	 content: '';
	 display: inline-block;
	 position: absolute;
	 top: 0;
	 left: -37px;
	 width: 20px;
	 height: 20px;
	 border: 2px solid #CCC;
	 border-radius: 50%;
	 background-color: #FFF;
}
 .StepProgress-item.is-done::before {
	 border-left: 2px solid green;
   margin-left:2px;
}
 .StepProgress-item.is-done::after {
	 content: "✔";
	 font-size: 13px;
	 color: #FFF;
	 text-align: center;
	 border: 2px solid green;
	 background-color: green;
}
 .StepProgress-item.current::before {
	 border-left: 2px solid green;
   margin-left:2px;
}
 .StepProgress-item.current::after {
	 content: counter(list);
	 padding-top: 1px;
	 width: 25px;
	 height: 25px;
	 top: -4px;
	 left: -40px;
	 font-size: 14px;
	 text-align: center;
	 color: green;
	 border: 2px solid green;
	 background-color: white;
}
 .StepProgress strong {
	 display: block;
}

</style>


<div class = "main" style = "margin-top: 20px; width: 98%;">

  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add New Parcel</h4>
        </div>

        <form method="POST" id = "add">
          <div class="input" style = "padding: 10px;">
            <div class = "row" style = "margin-top:5px;">
              <div class="form-group col-md-6">
                <label>Parcel Content:</label>
                <input type="text" class="form-control" id = "parcel_content" name = "parcel_content" placeholder = "Enter parcel content..">
              </div>
              
              <div class="form-group col-md-6">
                <label>Sending Date:</label>
                <input type="date" class="form-control" id = "sending_date" name = "sending_date">
              </div>
            </div>

            <div class = "row" style = "margin-top:5px;">
              <div class="form-group col-md-6">
                <label>Sender's Name:</label>
                <input type="text" class="form-control" id = "sender_name" name = "sender_name" placeholder = "Enter sender name..">
              </div>
              
              <div class="form-group col-md-6">
                <label>Sender's Contact:</label>
                <input type="text" class="form-control" id = "sender_contact" name = "sender_contact" placeholder = "Enter sender contact..">
              </div>
            </div>

            <div class = "row" style = "margin-top:5px;">
              <div class="form-group col-md-6">
                <label>Receiving Date:</label>
                <input type="date" class="form-control" id = "receiving_date" name = "receiving_date">
              </div>
              
              <div class="form-group col-md-6">
                <label>Receiver's Name:</label>
                <input type="text" class="form-control" id = "receiver_name" name = "receiver_name" placeholder = "Enter receiver name..">
              </div>
            </div>
      
            <div class = "row" style = "margin-top:5px;">
              <div class="form-group col-md-6">
                <label>Reciever's Contact:</label>
                <input type="text" class="form-control" id = "receiver_contact" name = "receiver_contact" placeholder = "Enter receiver contact..">
              </div>
              
              <div class="form-group col-md-6">
                <label>Destination:</label>
                <input type="text" class="form-control" id = "destination" name = "destination" placeholder = "Enter destination..">
                <input type = "hidden" name = "contact_person" id = "contact_person" required/>
                <div class="dropdown-menu" style="margin-left: 15px; margin-top: 0px;" id="suggestion-box1"></div>
              </div>
            </div>

            <div class = "row" style = "margin-top:5px;">
              <div class="form-group col-md-6">
                <label>Current Location:</label>
                <input type="text" class="form-control" id = "current_location" name = "current_location" placeholder = "Enter current location..">
                <input type = "hidden" name = "contact_person1" id = "contact_person1" required/>
                <div class="dropdown-menu" style="margin-left: 15px; margin-top: 0px;" id="suggestion-box2"></div>
              </div>
              <div class="form-group col-md-6">
                <label style = "margin-bottom: 5px;">Location Note:</label>
                <textarea class="form-control"  id= "location_note"></textarea>
              </div>
            </div>
            <input type="hidden" name = "add" value = "add">
          </div>
        </form>

        <div class="modal-footer">
          <button type="button" class="button" id = "save" onclick ="addParcel(event)" style = "margin-right:8px;">Save</button>
          <button type="button" class="button" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


  <div class = "car">
    <div class = "card-header" style = "height: 35px; display: flex;">
        <h6><b>Parcel Delivery</b></h6>
        <img width=20 height=20 style = "float:right; margin-left: auto;" src = "<?php echo plugin_dir_url( __FILE__ ) .'images/parcel.png';?>" alt = "parcel icon"/>
    </div>

    <div>
    
      <div class = "card-body table-responsive">
          <div style = "display: flex; margin-bottom: 20px;">
            <div>
              <span>Minimum date:</span><br>
              <input type="text" id="min" name="min">
            </div>
            <div style = "margin-left: 15px;">
              <span>Maximum date:</span><br>
              <input type="text" id="max" name="max">
            </div>
            <div style = "margin-left: 15px; margin-top: 25px;">
                <button class = "button" onclick = "resetTable()">Reset</button>
            </div>
          </div>
          <table id = "table" class="table table-striped table-hover" border = "0">
              <thead>
                  <tr class = "header" style = "background-color: white !important;">
                      <td class = "text">Id</td>
                      <td class = "text">Parcel Number</td>
                      <td class = "text">Parcel Content</td>
                      <td class = "text">Sending Date</td>
                      <td class = "text">Sender's Name</td>
                      <td class = "text">Sender's Contact</td>
                      <td class = "text">Receiving Date</td>
                      <td class = "text">Receiver's Name</td>
                      <td class = "text">Receiver's Contact</td>
                      <td class = "text">Current Location</td>
                      <td class = "text">Destination</td>
                      <td class = "text">Status</td>
                      <td class = "text notexport">Actions</td>
                  </tr>
              </thead>
              <tbody>
              <?php
              if ($parcels) {
                $i = 1;
                global $wpdb;

                foreach ($parcels as $parcel) {

                  $table_name = $wpdb->prefix."order_locations";
                  $locations = $wpdb->get_results("SELECT * FROM $table_name WHERE order_id = '$parcel->parcel_number'");
                  foreach ($locations as $loc) {
                      $location = $loc->order_location;
                  }                  
              ?>

                  <div id="<?php echo $parcel->id."delete"; ?>" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-dialog-centered">
                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Delete Parcel</h4>
                        </div>
                        <div class="modal-body">
                          <p>Are sure you want to delete this parcel?</p>
                          <button class="button" id = "<?php echo "delete".$parcel->id; ?>" style = "width: 100%;" onclick ="deleteParcel(<?php echo $parcel->id; ?>, '<?php echo $parcel->parcel_number; ?>')">Delete</button>
                        </div>                      
                      </div>
                    </div>
                  </div>

                  <div id="<?php echo $parcel->id."update"; ?>" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Update Parcel Details</h4>
                        </div>

                        <form method="POST">
                          <div class="input" style = "padding: 10px;">
                            <div class = "row" style = "margin-top:5px;">
                              <div class="form-group col-md-6">
                                <label>Parcel Content:</label>
                                <input type="text" class="form-control" id = "<?php echo "parcel_content".$parcel->id; ?>" name = "parcel_content" placeholder = "Enter parcel content.." value = "<?php echo $parcel->parcel_content; ?>">
                              </div>
                              
                              <div class="form-group col-md-6">
                                <label>Sending Date:</label>
                                <input type="date" class="form-control" id = "<?php echo "sending_date".$parcel->id; ?>" name = "sending_date" value = "<?php echo $parcel->sending_date; ?>">
                              </div>
                            </div>

                            <div class = "row" style = "margin-top:5px;">
                              <div class="form-group col-md-6">
                                <label>Sender Name:</label>
                                <input type="text" class="form-control" id = "<?php echo "sender_name".$parcel->id; ?>" name = "sender_name" placeholder = "Enter sender name.." value = "<?php echo $parcel->sender_name; ?>">
                              </div>
                              
                              <div class="form-group col-md-6">
                                <label>Sender Contact:</label>
                                <input type="text" class="form-control" id = "<?php echo "sender_contact".$parcel->id; ?>" name = "sender_contact" placeholder = "Enter sender contact.." value = "<?php echo $parcel->sender_contact; ?>">
                              </div>
                            </div>

                            <div class = "row" style = "margin-top:5px;">
                              <div class="form-group col-md-6">
                                <label>Receiver Date:</label>
                                <input type="date" class="form-control" id = "<?php echo "receiving_date".$parcel->id; ?>" name = "receiving_date" value = "<?php echo $parcel->receiving_date; ?>">
                              </div>
                              
                              <div class="form-group col-md-6">
                                <label>Receiver Name:</label>
                                <input type="text" class="form-control" id = "<?php echo "receiver_name".$parcel->id; ?>" name = "receiver_name" placeholder = "Enter receiver name.." value = "<?php echo $parcel->receiver_name; ?>">
                              </div>
                            </div>
                      
                            <div class = "row" style = "margin-top:5px;">
                              <div class="form-group col-md-6">
                                <label>Reciever Contact:</label>
                                <input type="text" class="form-control" id = "<?php echo "receiver_contact".$parcel->id; ?>" name = "receiver_contact" placeholder = "Enter receiver contact.." value = "<?php echo $parcel->receiver_contact; ?>">
                              </div>
                              
                              <div class="form-group col-md-6">
                                <label>Destination:</label>
                                <input type="text" class="form-control" id = "<?php echo "destination".$parcel->id; ?>" name = "destination" placeholder = "Enter destination.." value = "<?php echo $parcel->destination; ?>">
                                <input type = "hidden" name = "contact_person" id = "<?php echo "contact_person".$parcel->id; ?>" value = "<?php echo $parcel->contact_person; ?>" required/>
                                <div class="dropdown-menu" style="margin-left: 15px; margin-top: 0px;" id="<?php echo "suggestion-box1".$parcel->id; ?>"></div>
                              </div>
                            </div>

                            <div class = "row" style = "margin-top:5px;">
                              <div class="form-group col-md-6">
                                <label>Current Location:</label>
                                <input type="text" class="form-control" id = "<?php echo "current_location".$parcel->id; ?>" name = "current_location" placeholder = "Enter current location..">
                                <input type = "hidden" name = "contact_person1" id = "<?php echo "contact_person1".$parcel->id; ?>" required/>
                                <div class="dropdown-menu" style="margin-left: 15px; margin-top: 0px;" id="<?php echo "suggestion-box2".$parcel->id; ?>"></div>
                              </div>
                              <div class="form-group col-md-6">
                                <label style = "margin-bottom: 5px;">Location Note:</label>
                                <textarea class="form-control"  id= "<?php echo 'location_note'.$parcel->id;?>"></textarea>
                              </div>
                            </div>

                            <input type="hidden" class="form-control" id = "<?php echo "parcel_number".$parcel->id; ?>" value = "<?php echo $parcel->parcel_number; ?>">

                            <input type="hidden" name = "add" value = "add">
                          </div>
                        </form>
                        <div class="modal-footer">
                          <button type="button" class="button" id = "<?php echo "update".$parcel->id; ?>" onclick ="updateParcel(event, <?php echo $parcel->id; ?>)" style = "margin-right:8px;">Update</button>
                          <button type="button" class="button" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <script>
                    // AJAX call for autocomplete 
                    $(document).ready(function(){
                        $("#<?php echo "destination".$parcel->id; ?>").keyup(function(){
                            if ($(this).val()) {
                                var ajaxurl = '<?php echo admin_url('admin-ajax.php');?>';

                                var data = {
                                    action: 'update_search_points',
                                    keyword: $(this).val(),
                                    id: <?php echo $parcel->id; ?>
                                };
                                $.ajax({
                                type: "POST",
                                url: ajaxurl,
                                data: data,
                                beforeSend: function(){
                                    $("#<?php echo "destination".$parcel->id; ?>").css("background","#e2e2e2");
                                    document.getElementById("<?php echo "update".$parcel->id; ?>").disabled = true;
                                },
                                success: function(data){
                                    document.getElementById("<?php echo "update".$parcel->id; ?>").disabled = false;
                                    $("#<?php echo "suggestion-box1".$parcel->id; ?>").show();
                                    $("#<?php echo "suggestion-box1".$parcel->id; ?>").html(data);
                                    $("#<?php echo "destination".$parcel->id; ?>").css("background","#FFF");
                                }
                                });
                            } else {
                                $("#<?php echo "suggestion-box1".$parcel->id; ?>").hide(); 
                            }
                        });


                        $("#<?php echo "current_location".$parcel->id; ?>").keyup(function(){
                            if ($(this).val()) {
                                var ajaxurl = '<?php echo admin_url('admin-ajax.php');?>';

                                var data = {
                                    action: 'update_search_locations',
                                    keyword: $(this).val(),
                                    id: <?php echo $parcel->id; ?>
                                };
                                $.ajax({
                                type: "POST",
                                url: ajaxurl,
                                data: data,
                                beforeSend: function(){
                                    $("#<?php echo "current_location".$parcel->id; ?>").css("background","#e2e2e2");
                                    document.getElementById("<?php echo "update".$parcel->id; ?>").disabled = true;
                                },
                                success: function(data){
                                    document.getElementById("<?php echo "update".$parcel->id; ?>").disabled = false;
                                    $("#<?php echo "suggestion-box2".$parcel->id; ?>").show();
                                    $("#<?php echo "suggestion-box2".$parcel->id; ?>").html(data);
                                    $("#<?php echo "current_location".$parcel->id; ?>").css("background","#FFF");
                                }
                                });
                            } else {
                                $("#<?php echo "suggestion-box2".$parcel->id; ?>").hide(); 
                            }
                        });

                    });

                    <?php 
                        echo '
                        function selectPoint'.$parcel->id.'(val1, val2)
                        {
                            $("#destination'.$parcel->id.'").val(val2);
                            $("#contact_person'.$parcel->id.'").val(val1);
                            $("#suggestion-box1'.$parcel->id.'").hide();
                        }';

                        echo '
                        function selectLocation'.$parcel->id.'(val1, val2)
                        {
                            $("#current_location'.$parcel->id.'").val(val2);
                            $("#contact_person1'.$parcel->id.'").val(val1);
                            $("#suggestion-box2'.$parcel->id.'").hide();
                        }';
                    ?>
                </script>

                  <div id="<?php echo $parcel->id."journey"; ?>" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Order Journey</h4>
                        </div>
                        <div style="margin:auto;">
                          <div class="wrapper">
                            <ul class="StepProgress">
                              <?php 

                                $customer = false;

                                foreach ($locations as $node) {
                                  if ($node->order_location == "Customer") {
                                    $customer = true;

                                    echo "<script>
                                        document.getElementById('"."current_location".$parcel->id."').disabled = true;
                                        document.getElementById('"."location_note".$parcel->id."').disabled = true;
                                    </script>";
                                  }
                                  ?> 
                                   <div class="StepProgress-item is-done">
                                      <strong><?php echo $node->order_location; ?></strong>
                                      <strong><?php echo $node->time_stamp; ?></strong>
                                      <?php echo $node->location_note; ?>
                                    </div>                            
                                  <?php
                                }
                               ?>

                               <?php
                                    if ($customer == false) {
                                ?>
                                  <div class="StepProgress-item current">
                                    <strong>Customer</strong>
                                  </div>
                                <?php
                                    } 
                                ?>      
                            </ul>
                          </div>
                         </div>
                      </div>
                    </div>
                  </div>
                  <tr>
                      <td class = "data"><?php echo $i; ?></td>
                      <td class = "data"><?php echo $parcel->parcel_number; ?></td>                  
                      <td class = "data"><?php echo $parcel->parcel_content; ?></td>                  
                      <td class = "data"><?php echo $parcel->sending_date; ?></td>                  
                      <td class = "data"><?php echo $parcel->sender_name; ?></td>                  
                      <td class = "data"><?php echo $parcel->sender_contact; ?></td>                  
                      <td class = "data"><?php echo $parcel->receiving_date; ?></td>                  
                      <td class = "data"><?php echo $parcel->receiver_name; ?></td>                  
                      <td class = "data"><?php echo $parcel->receiver_contact; ?></td>  
                      <td class = "data"><?php echo $location; ?></td>                                                   
                      <td class = "data"><?php echo $parcel->destination; ?></td>
                      <td class = "data"><?php echo $location == "Customer" ? "delivered" : "intransit"; ?></td>         
                       <td class = "action">
                          <div style = "display: flex;">
                            <button type = "button" class = "button" data-toggle = "modal" data-target = "#<?php echo $parcel->id."update"; ?>" data-backdrop = "true">Update</button>
                            <button type = "button" class = "button" style = "margin-left: 10px;" data-toggle = "modal" data-target = "#<?php echo $parcel->id."delete"; ?>" data-backdrop = "true">Delete</button>
                            <button type = "button" class = "button" style = "margin-left: 10px;" data-toggle = "modal" data-target = "#<?php echo $parcel->id."journey"; ?>" data-backdrop = "true">Journey</button>
                          </div>
                      </td>                 
                  </tr>
              <?php
                  $i++;
                }
              }
              ?>
              </tbody>
          </table>
      </div>
    </div>
    <div class = "card-footer">
        <button type = "button" style = "margin-left : 5px;" class = "button" data-toggle = "modal" data-target = "#myModal" data-backdrop = "true"><span class = "add">&plus;</span>Add Parcel</button>
    </div>
  </div>
</div>


<script src="https://cdn.datatables.net/datetime/1.2.0/js/dataTables.dateTime.min.js"></script>

<script src = "https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>


<script>  
    var minDate, maxDate;
 
    // Custom filtering function which will search data in column four between two values
    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            var min = minDate.val();
            var max = maxDate.val();
            var date = new Date( data[3] );
    
            if (
                ( min === null && max === null ) ||
                ( min === null && date <= max ) ||
                ( min <= date   && max === null ) ||
                ( min <= date   && date <= max )
            ) {
                return true;
            }
            return false;
        }
    );

    $(document).ready(function () {
       // Create date inputs
    minDate = new DateTime($('#min'), {
      format: 'MMMM Do YYYY'    
    });
    maxDate = new DateTime($('#max'), {
      format: 'MMMM Do YYYY'    
    });

    var table = $('#table').DataTable( {
            dom:'lBfrtip',
            buttons: [{
               extend: 'pdfHtml5',
               className: 'button',
               text: 'Print PDF',
               orientation: 'landscape',
               pageSize: 'LEGAL',
               exportOptions: {
                   columns: ':not(.notexport)'
               }

            },
            {
               extend: 'excel',
               className: 'button',
               text: 'Print Excel Sheet',
               orientation: 'landscape',
               pageSize: 'LEGAL',
               exportOptions: {
                   columns: ':not(.notexport)'
               } 
            }],
        } );


        // Refilter the table
        $('#min, #max').on('change', function () {
            table.draw();
        });
    });
</script>


<script>
   // AJAX call for autocomplete 
   $(document).ready(function(){
      $("#destination").keyup(function(){
         if ($(this).val()) {
            var ajaxurl = '<?php echo admin_url('admin-ajax.php');?>';

            var data = {
               action: 'search_points',
               keyword: $(this).val(),
            };
            $.ajax({
            type: "POST",
            url: ajaxurl,
            data: data,
            beforeSend: function(){
                  $("#destination").css("background","#e2e2e2");
                  document.getElementById("save").disabled = true;
            },
            success: function(data){
                  document.getElementById("save").disabled = false;
                  $("#suggestion-box1").show();
                  $("#suggestion-box1").html(data);
                  $("#destination").css("background","#FFF");
            }
            });
         } else {
            $("#suggestion-box1").hide(); 
         }
      });

      $("#current_location").keyup(function(){
         if ($(this).val()) {
            var ajaxurl = '<?php echo admin_url('admin-ajax.php');?>';

            var data = {
               action: 'search_locations',
               keyword: $(this).val(),
            };
            $.ajax({
            type: "POST",
            url: ajaxurl,
            data: data,
            beforeSend: function(){
                  $("#current_location").css("background","#e2e2e2");
                  document.getElementById("save").disabled = true;
            },
            success: function(data){
                  document.getElementById("save").disabled = false;
                  $("#suggestion-box2").show();
                  $("#suggestion-box2").html(data);
                  $("#current_location").css("background","#FFF");
            }
            });
         } else {
            $("#suggestion-box2").hide(); 
         }
      });

   });

   //To select point
   function selectPoint(val1, val2) {
         $("#destination").val(val2);
         $("#contact_person").val(val1);
         $("#suggestion-box1").hide();
   }


   function selectLocation(val1, val2) {
         $("#current_location").val(val2);
         $("#contact_person1").val(val1);
         $("#suggestion-box2").hide();
   }



   function resetTable()
   {
    window.location.reload(true);
   }
 
  
</script>


