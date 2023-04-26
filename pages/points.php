<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
<link href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
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
   function addPoint(e)
    {
       e.preventDefault();

       var name = document.getElementById("name").value;
       var contact = document.getElementById("contact").value;
       var location = document.getElementById("location").value;
    

       if (name == "" || contact == "" || location == "") {
          alert("Please enter all required fields")
          return;
       }

       var save = document.getElementById("save").innerHTML ="saving...";

       var ajaxurl = '<?php echo admin_url('admin-ajax.php');?>';

       var data = {
            action: 'points',
            type: 'add',
            name,
            contact,
            location
       }

        $.ajax({ 
            url:ajaxurl,
            type:"POST",
            data: data,
            success : function( response ){

                console.log(response);

                if ($.trim(response) == "success") {
                    alert("Point added successfully.")
                    window.location.reload(true);

                } else if($.trim(response) == "exists0") {
                    alert("Contact already exists.");
                    var save = document.getElementById("save").innerHTML ="save";

                } else if ($.trim(response) == "failed") {
                    alert("An error occured.");
                    var save = document.getElementById("save").innerHTML ="save";

                }
            },

        });
    }


   //Deleting point
   function deletePoint(id)
   {
      var ajaxurl = '<?php echo admin_url('admin-ajax.php');?>';
       //alert(id);
      var data = {
          action: 'points',
          type: 'delete',
          id: id
      };

      var del = document.getElementById("delete"+id).innerHTML ="Deleting...";

      $.post(ajaxurl, data, function(response) {
           if ($.trim(response) == "success") {
                alert("Point deleted successfully.")
                location.reload(true);

            } else if($.trim(response) == "failed") {
                alert("An error occured.")
                var del = document.getElementById("delete"+id).innerHTML ="Delete";
            }
      }); 
   }


   //Updating a parcel
   function updatePoint(e, id)
   {
        e.preventDefault();

       var name = document.getElementById("name"+id).value;
       var contact = document.getElementById("contact"+id).value;
       var orig_contact = document.getElementById("orig_contact"+id).value;
       var location = document.getElementById("location"+id).value;
    

       if (name == "" || contact == "" || location == "") {
          alert("Please enter all required fields")
          return;
       }

        var edit = document.getElementById("update" + id).innerHTML = "Updating...";

        var ajaxurl = '<?php echo admin_url('admin-ajax.php');?>';

        var data = {
            action: 'points',
            type: 'update',
            id,
            name,
            contact,
            orig_contact,
            location
        }

        $.ajax({ 
            url:ajaxurl,
            type:"POST",
            data: data,
            success : function( response ){  

                if ($.trim(response) == "success") {
                    alert("Point updated successfully.")
                    window.location.reload(true);

                } else if ($.trim(response) == "exists0") {
                    alert("Contact already exists.");
                    var edit = document.getElementById("update" + id).innerHTML = "Update";

                } else if ($.trim(response) == "failed") {
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


<div class = "main" style = "margin-top: 20px; width: 98%;">

  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add New Point</h4>
        </div>

        <form method="POST" id = "add">
          <div class="input" style = "padding: 10px;">
            <div class = "row" style = "margin-top:5px;">
              <div class="form-group col-md-6">
                <label>Name:</label>
                <input type="text" class="form-control" id = "name" name = "name" placeholder = "Enter name..">
              </div>
              
              <div class="form-group col-md-6">
                <label>Contact:</label>
                <input type="text" class="form-control" id = "contact" name = "contact" placeholder = "Enter contact..">
              </div>
            </div>

            <div class = "row" style = "margin-top:5px;">
              <div class="form-group col-md-12">
                <label>Location:</label>
                <input type="text" class="form-control" id = "location" name = "location" placeholder = "Enter location..">
              </div>
            </div>

            <input type="hidden" name = "add" value = "add">
          </div>
        </form>

        <div class="modal-footer">
          <button type="button" class="button" id = "save" onclick ="addPoint(event)" style = "margin-right:8px;">Save</button>
          <button type="button" class="button" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


  <div class = "car">
    <div class = "card-header" style = "height: 35px; display: flex;">
        <h6><b>Pickup Points</b></h6>
        <img width=20 height=20 style = "float:right; margin-left: auto;" src = "<?php echo plugin_dir_url( __FILE__ ) .'images/parcel.png';?>" alt = "parcel icon"/>
    </div>

    <div>
      <div class = "card-body table-responsive">
          <table id = "table" class="table table-striped table-hover" border = "0">
              <thead>
                  <tr class = "header" style = "background-color: white !important;">
                      <td class = "text">Id</td>
                      <td class = "text">Name</td>
                      <td class = "text">Contact</td>    
                      <td class = "text">Location</td>
                      <td class = "text notexport">Actions</td>        
                  </tr>
              </thead>
              <tbody>
              <?php
              if($points){
                $i = 1;
                global $wpdb;

                foreach ($points as $point) {           
              ?>

                  <div id="<?php echo $point->id."delete"; ?>" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-dialog-centered">
                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Delete Pickup Point</h4>
                        </div>
                        <div class="modal-body">
                          <p>Are sure you want to delete this pickup point?</p>
                          <button class="button" id = "<?php echo "delete".$point->id; ?>" style = "width: 100%;" onclick ="deletePoint(<?php echo $point->id; ?>)">Delete</button>
                        </div>                      
                      </div>
                    </div>
                  </div>

                  <div id="<?php echo $point->id."update"; ?>" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Update Point Details</h4>
                        </div>

                        <form method="POST">
                          <div class="input" style = "padding: 10px;">
                            <div class = "row" style = "margin-top:5px;">
                                <div class="form-group col-md-6">
                                    <label>Name:</label>
                                    <input type="text" class="form-control" id = "<?php echo "name".$point->id; ?>" name = "name" placeholder = "Enter name.." value = "<?php echo $point->name; ?>">
                                </div>
                                
                                <div class="form-group col-md-6">
                                    <label>Contact:</label>
                                    <input type="text" class="form-control" id = "<?php echo "contact".$point->id; ?>" name = "contact" placeholder = "Enter contact.." value="<?php echo $point->contact; ?>">
                                    <input type="hidden"  id = "<?php echo "orig_contact".$point->id; ?>" value="<?php echo $point->contact; ?>">
                                </div>
                                </div>

                                <div class = "row" style = "margin-top:5px;">
                                <div class="form-group col-md-12">
                                    <label>Location:</label>
                                    <input type="text" class="form-control" id = "<?php echo "location".$point->id; ?>" name = "location" placeholder = "Enter location.." value="<?php echo $point->location; ?>">
                                </div>
                            </div>

                            <input type="hidden" name = "add" value = "add">
                          </div>
                        </form>
                        <div class="modal-footer">
                          <button type="button" class="button" id = "<?php echo "update".$point->id; ?>" onclick ="updatePoint(event, <?php echo $point->id; ?>)" style = "margin-right:8px;">Update</button>
                          <button type="button" class="button" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <tr>
                      <td class = "data"><?php echo $i; ?></td>
                      <td class = "data"><?php echo $point->name; ?></td>                  
                      <td class = "data"><?php echo $point->contact; ?></td>                  
                      <td class = "data"><?php echo $point->location; ?></td>                  
                                                
                      <td class = "action">
                          <div style = "display: flex;">
                            <button type = "button" class = "button" data-toggle = "modal" data-target = "#<?php echo $point->id."update"; ?>" data-backdrop = "true">Update</button>
                            <button type = "button" class = "button" style = "margin-left: 10px;" data-toggle = "modal" data-target = "#<?php echo $point->id."delete"; ?>" data-backdrop = "true">Delete</button>
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
        <button type = "button" style = "margin-left : 5px;" class = "button" data-toggle = "modal" data-target = "#myModal" data-backdrop = "true"><span class = "add">&plus;</span>Add Point</button>
    </div>
  </div>
</div>

<script>
    $(document).ready(function () {

      $('#aircraft_type').multiselect({		
          nonSelectedText: 'Select Aircraft',	
          buttonWidth: '100%',
          includeSelectAllOption: true,
          enableFiltering: true
      });

      $('#table').DataTable( {
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
    });
</script>