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

   //Deleting location
   function deleteLocation(id)
   {
      var ajaxurl = '<?php echo admin_url('admin-ajax.php');?>';
      
      var data = {
          action: 'locations',
          type: 'delete',
          id: id
      };

      var del = document.getElementById("delete"+id).innerHTML ="Deleting...";

      $.post(ajaxurl, data, function(response) {
           if ($.trim(response) == "success") {
                alert("Location deleted successfully.")
                location.reload(true);

            } else if($.trim(response) == "failed") {
                alert("An error occured.")
                var del = document.getElementById("delete"+id).innerHTML ="Delete";
            }
      }); 
   }


   //Updating a location
   function updateLocation(e, id)
   {
        e.preventDefault();

        var location = document.getElementById("location"+id).value;
        var note = document.getElementById("note"+id).value;
        
       if (location== "" || note == "") {
          alert("Please enter all required fields")
          return;
       }

        var edit = document.getElementById("update" + id).innerHTML = "Updating...";

        var ajaxurl = '<?php echo admin_url('admin-ajax.php');?>';

        var data = {
            action: 'locations',
            type: 'update',
            id,
            location,
            note
        }

        $.ajax({ 
            url:ajaxurl,
            type:"POST",
            data: data,
            success : function( response ){  

              //console.log(response);

                if ($.trim(response) == "success") {
                    alert("Location details updated successfully.")
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


<div class = "main" style = "margin-top: 20px; width: 98%;">

  <div class = "car">
    <div class = "card-header" style = "height: 35px; display: flex;">
        <h6><b>Parcel / Order Location</b></h6>
        <img width=20 height=20 style = "float:right; margin-left: auto;" src = "<?php echo plugin_dir_url( __FILE__ ) .'images/location.png';?>" alt = "location icon"/>
    </div>

    <div>
      <div class = "card-body table-responsive">
          <table id = "table" class="table table-striped table-hover" border = "0">
              <thead>
                  <tr class = "header" style = "background-color: white !important;">
                      <td class = "text">Id</td>
                      <td class = "text">Parcel / Order Number</td>
                      <td class = "text">Location</td>
                      <td class = "text">Note</td>
                      <td class = "text">Timestamp</td>
                      <td class = "text notexport">Actions</td>
                  </tr>
              </thead>
              <tbody>
              <?php
              if ($locations) {
                $i = 1;

                foreach ($locations as $location) {       
              ?>

                  <div id="<?php echo $location->id."delete"; ?>" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-dialog-centered">
                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Delete Location</h4>
                        </div>
                        <div class="modal-body">
                          <p>Are sure you want to delete this location?</p>
                          <button class="button" id = "<?php echo "delete".$location->id; ?>" style = "width: 100%;" onclick ="deleteLocation(<?php echo $location->id; ?>)">Delete</button>
                        </div>                      
                      </div>
                    </div>
                  </div>

                  <div id="<?php echo $location->id."update"; ?>" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Update Location</h4>
                        </div>

                        <form method="POST">
                          <div class="input" style = "padding: 10px;">
                            <div class = "row" style = "margin-top:5px;">
                              <div class="form-group col-md-6">
                                <label>Location:</label>
                                <input type="text" class="form-control" id = "<?php echo "location".$location->id; ?>" name = "location" placeholder = "Enter location.." value = "<?php echo $location->order_location; ?>">
                              </div>
                              
                              <div class="form-group col-md-6">
                                <label>Note:</label>
                                <textarea class="form-control" id = "<?php echo "note".$location->id; ?>"><?php echo $location->location_note; ?></textarea>
                              </div>
                            </div>

                            <input type="hidden" class="form-control" id = "<?php echo "id".$location->id; ?>" value = "<?php echo $location->id; ?>">
                          </div>
                        </form>
                        <div class="modal-footer">
                          <button type="button" class="button" id = "<?php echo "update".$location->id; ?>" onclick ="updateLocation(event, <?php echo $location->id; ?>)" style = "margin-right:8px;">Update</button>
                          <button type="button" class="button" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <tr>
                      <td class = "data"><?php echo $i; ?></td>
                      <td class = "data"><?php echo $location->order_id; ?></td>                  
                      <td class = "data"><?php echo $location->order_location; ?></td>                  
                      <td class = "data"><?php echo $location->location_note; ?></td> 
                      <td class = "data"><?php echo $location->time_stamp; ?></td>                                                                       
                      <td class = "action">
                          <div style = "display: flex;">
                            <button type = "button" class = "button" data-toggle = "modal" data-target = "#<?php echo $location->id."update"; ?>" data-backdrop = "true">Update</button>
                            <button type = "button" class = "button" style = "margin-left: 10px;" data-toggle = "modal" data-target = "#<?php echo $location->id."delete"; ?>" data-backdrop = "true">Delete</button>
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