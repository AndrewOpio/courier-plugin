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
   //Updating location
   
   function updateLocation(id)
   {
      var ajaxurl = '<?php echo admin_url('admin-ajax.php');?>';
      var location = document.getElementById("location"+id).value;
      var contact_person = document.getElementById("contact_person"+id).value;
      var location_note = document.getElementById("location_note"+id).value;

      if ( location == '' || location_note == '' || contact_person == '') {
        alert('Please enter all fields');

      } else {
        var edit = document.getElementById("update" + id).innerHTML = "Updating...";

        var data = {
            action: 'order_location',
            id: id,
            location,
            location_note
        };

        $.post(ajaxurl, data, function(response) {

            //console.log(response);

            if ($.trim(response) == "success") {
              var edit = document.getElementById("update" + id).innerHTML = "Update";
              alert("Location updated successfully.");
              window.location.reload(true);

            } else if($.trim(response) == "failed") {
                alert("An error occured.");
                var edit = document.getElementById("update" + id).innerHTML = "Update";

            }            
        }); 
      }
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
    
<div class = "car">
  <div class = "card-header" style = "height: 35px; display: flex;">
      <h6><b>Order Location</b></h6>
      <img width=20 height=20 style = "float:right; margin-left: auto;" src = "<?php echo plugin_dir_url( __FILE__ ) .'images/location.png';?>" alt = "location icon"/>
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
                    <td class = "text">Order Number</td>
                    <td class = "text">Current Location</td>
                    <td class = "text">Destination</td>
                    <td class = "text">Date</td>
                    <td class = "text">Status</td>
                    <td class = "text notexport">Actions</td>
                </tr>
            </thead>
            <tbody>
            <?php

            if($orders){
              $i = 1;
              //global $wpdb;

              foreach ($orders as $order) {

                global $wpdb; 
                $table_name = $wpdb->prefix."order_locations";
                $locations = $wpdb->get_results("SELECT * FROM $table_name WHERE order_id = '$order->ID'");
                
                if (!$locations) {
                  continue;
                }

                $destinations = $wpdb->get_results("SELECT * FROM `$table_name1` WHERE meta_key = '_shipping_route' AND post_id = '$order->ID'");

                foreach ($destinations as $dest) {
                  $destination = $dest->meta_value;
                }

                foreach ($locations as $loc) {
                  $location = $loc->order_location;
                }
            ?>

                <div id="<?php echo $order->ID."update"; ?>" class="modal fade" role="dialog">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Update Order Location</h4>
                      </div>

                      <form>
                        <div class="input">
                          <div class = "row" style = "padding-left: 20px; padding-right: 20px; margin-top:8px;">
                            <div class="form-group col-md-12">
                              <label style = "margin-bottom: 5px;">Current location</label>
                              <input type="text" class="form-control"  id= "<?php echo 'location'.$order->ID;?>" placeholder = "Enter current location..">
                              <input type = "hidden" name = "contact_person" id = "<?php echo "contact_person".$order->ID; ?>" required/>
                              <div class="dropdown-menu" style="margin-left: 15px; margin-top: 0px;" id="<?php echo "suggestion-box".$order->ID; ?>"></div>
                            </div>
                          </div>

                          <div class = "row" style = "margin-top:8px; margin-bottom: 5px; padding-left: 20px; padding-right: 20px;">
                            <div class="form-group col-md-12">
                              <label style = "margin-bottom: 5px;">Location Note:</label>
                              <textarea class="form-control"  id= "<?php echo 'location_note'.$order->ID;?>"></textarea>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" id = "<?php echo 'update'.$order->ID;?>" class="button" onclick = "updateLocation(<?php echo $order->ID;?>)" style = "margin-right: 10px;">Update</button>
                          <button type="button" class="button" data-dismiss="modal">Close</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>


                <script>
                    // AJAX call for autocomplete 
                    $(document).ready(function(){
                        $("#<?php echo "location".$order->ID; ?>").keyup(function(){
                            if ($(this).val()) {
                                var ajaxurl = '<?php echo admin_url('admin-ajax.php');?>';

                                var data = {
                                    action: 'update_search_locations',
                                    keyword: $(this).val(),
                                    id: <?php echo $order->ID; ?>
                                };
                                $.ajax({
                                type: "POST",
                                url: ajaxurl,
                                data: data,
                                beforeSend: function(){
                                    $("#<?php echo "location".$order->ID; ?>").css("background","#e2e2e2");
                                    document.getElementById("<?php echo "update".$order->ID; ?>").disabled = true;
                                },
                                success: function(data){
                                    document.getElementById("<?php echo "update".$order->ID; ?>").disabled = false;
                                    $("#<?php echo "suggestion-box".$order->ID; ?>").show();
                                    $("#<?php echo "suggestion-box".$order->ID; ?>").html(data);
                                    $("#<?php echo "location".$order->ID; ?>").css("background","#FFF");
                                }
                                });
                            } else {
                                $("#<?php echo "suggestion-box".$order->ID; ?>").hide(); 
                            }
                        });

                    });

                    <?php 
                        echo '
                        function selectLocation'.$order->ID.'(val1, val2)
                        {
                            $("#location'.$order->ID.'").val(val2);
                            $("#contact_person'.$order->ID.'").val(val1);
                            $("#suggestion-box'.$order->ID.'").hide();
                        }';
                    ?>
                </script>

                <div id="<?php echo $order->ID."journey"; ?>" class="modal fade" role="dialog">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Order Journey</h4>
                      </div>
                      <?php //var_dump($locations); ?>
                      <div style="margin:auto;">
                        <div class="wrapper">
                          <ul class="StepProgress">
                          <?php 
                            $customer = false;

                            foreach ($locations as $node) {
                              if ($node->order_location == "Customer") {
                                $customer = true;

                                echo "<script>
                                    document.getElementById('"."location".$order->ID."').disabled = true;
                                    document.getElementById('"."location_note".$order->ID."').disabled = true;
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
                    <td class = "data"><a href = "http://localhost/duka_mart/wp-admin/post.php?post=<?php echo $order->ID; ?>&action=edit"><?php echo $order->ID; ?></a></td>                  
                    <td class = "data"><?php echo $location; ?></td> 
                    <td class = "data"><?php echo $destination; ?></td> 
                    <td class = "data"><?php echo $order->post_date; ?></td> 
                    <td class = "data"><?php echo $location == "Customer" ? "delivered" : "intransit"; ?></td>         
                    <td class = "action">
                        <div style = "display: flex;">
                          <button type = "button" class = "button" data-toggle = "modal" data-target = "#<?php echo $order->ID."update"; ?>" data-backdrop = "true">Update</button>
                          <button type = "button" class = "button" style = "margin-left: 10px;" data-toggle = "modal" data-target = "#<?php echo $order->ID."journey"; ?>" data-backdrop = "true">Journey</button>
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
            var date = new Date( data[4] );
    
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
            }]
        } );

        // Refilter the table
        $('#min, #max').on('change', function () {
            table.draw();
        });
    });


    function resetTable()
   {
    window.location.reload(true);
   }
 
</script>