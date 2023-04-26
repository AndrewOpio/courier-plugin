<?php
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if($_POST['order_id']) {
            global $wpdb;
            $table_name = $wpdb->prefix."order_locations";
            $locations = $wpdb->get_results("SELECT * FROM $table_name WHERE order_id = '$_POST[order_id]'");
        }
    }
?>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>


<script type ="text/javascript">

   //Check order
   function checkOrder(e)
    {
       e.preventDefault();

       var order_id = document.getElementById("order_id").value;
      

       if (order_id == "") {
          alert("Please enter all required fields")
          return;
       }

       var check = document.getElementById("check").innerHTML ="Checking...";

       var ajaxurl = '<?php echo admin_url('admin-ajax.php');?>';

       var data = {
            action: 'track',
            order_id,
       }

        $.ajax({ 
            url:ajaxurl,
            type:"POST",
            data: data,
            success : function( response ){
                //console.log(JSON.parse(response)[0]);
                if($.trim(response) == "failed") {
                    alert("Order not found.");
                    var check = document.getElementById("check").innerHTML ="Submit";

                } else {
                    var order = JSON.parse(response)[0];
                    document.getElementById("order_number").innerHTML ="Order ID:" + "  " + order.order_id;
                    document.getElementById("location").innerHTML ="Current Location:" + "  " + order.order_location;
                    document.getElementById("container").style.display = "block";
                    var check = document.getElementById("check").innerHTML ="Submit";
                }
            },

        });
    }
</script>

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


<div>
    <form method="POST" action="<?php the_permalink(); ?>">
        <div>
            <div class="form-group col-md-12">
                <label>Enter Order Number:</label><br>
                <input type="text" class="form-control" id = "order_id" name = "order_id" style = "width: 100%;" name = "order_id" placeholder = "Enter order number..">
            </div>
            <div class="form-group col-md-12">
                <button class = "button" type = "submit" id = "check" style = "width: 100%; margin-top: 15px;">Submit</button>
            </div>
        </div>
    </form>
  
    <?php
        if ($locations) {
            foreach ($locations as $location) {
               if($location->order_type == "parcel_order") {
    ?>
    <h4 style = "margin-top: 40px;">Parcel Details</h4>
    <?php
              }
            }
        }
    ?>
    <div class = "row"  style = "margin-top: 30px;">
        <div class = "col-md-6">
            <table>
                <?php
                    if ($locations) {
                        foreach ($locations as $location) {
                            if($location->order_type == "parcel_order") {
                    global $wpdb;
                    $table_name = $wpdb->prefix."parcels";
                    $parcels = $wpdb->get_results("SELECT * FROM $table_name WHERE parcel_number = '$_POST[order_id]'");
                    
                    foreach ($parcels as $parcel) {
                ?>
                <tr>
                    <td>Parcel Content</td>
                    <td><?php echo $parcel->parcel_content; ?></td>
                </tr>
                <tr>
                    <td>Sending Date</td>
                    <td><?php echo $parcel->sending_date; ?></td>
                </tr>
                <tr>
                    <td>Sender's Name</td>
                    <td><?php echo $parcel->sender_name; ?></td>
                </tr>
                <tr>
                    <td>Sender's Contact</td>
                    <td><?php echo $parcel->sender_contact; ?></td>
                </tr>
                <tr>
                    <td>Receiving Date</td>
                    <td><?php echo $parcel->receiving_date; ?></td>
                </tr>
                <tr>
                    <td>Receiver's Name</td>
                    <td><?php echo $parcel->receiver_name; ?></td>
                </tr>
                <tr>
                    <td>Receiver's Contact</td>
                    <td><?php echo $parcel->receiver_contact; ?></td>
                </tr>
                <tr>
                    <td>Destination</td>
                    <td><?php echo $parcel->destination; ?></td>
                </tr>
                <?php
                    }
                }}
                }
                ?>
            </table>

            <table>
                <?php

                    if ($locations) {
                        foreach ($locations as $location) {
                            if($location->order_type == "shop_order") {
                    global $wpdb;
                    $table_name1 = $wpdb->prefix."postmeta";
                    $table_name2 = $wpdb->prefix."posts";
                    $order_header = $wpdb->get_results("SELECT * FROM `$table_name2` WHERE post_type = 'shop_order' AND ID = '$_POST[order_id]'");
            
                    $order_body = $wpdb->get_results("SELECT * FROM `$table_name1` WHERE  post_id = '$_POST[order_id]' AND (  meta_key = '_shipping_route' || meta_key = '_order_total' || meta_key = '_billing_first_name' || meta_key = '_billing_last_name' || meta_key = '_billing_country' || meta_key = '_billing_email' || meta_key = '_billing_phone')");
                    
                    foreach ($order_header as $header) {
                    ?>
                    <span  style = "margin-top: 40px;">Order <b>#<?php echo $_POST['order_id']; ?></b> was placed on <b><?php echo $header->post_title; ?></b></span>
                
                    <h4>Order Details</h4>
                <?php
                    }

                    foreach ($order_body as $data) {     
                ?>

               <?php 
                  if($data->meta_key == '_billing_first_name') {
               ?>
                <tr>
                    <td>First Name</td>
                    <td><?php echo $data->meta_value; ?></td>
                </tr>
                <?php
                  }
                ?>

               <?php 
                  if($data->meta_key == '_billing_last_name') {
               ?>
                <tr>
                    <td>Last Name</td>
                    <td><?php echo $data->meta_value; ?></td>
                </tr>
                <?php
                  }
                ?>

                <?php 
                  if($data->meta_key == '_billing_country') {
                ?>
                <tr>
                    <td>Country</td>
                    <td><?php echo $data->meta_value; ?></td>
                </tr>
                <?php
                  }
                ?>
                <?php 
                  if($data->meta_key == '_billing_email') {
                ?>
                <tr>
                    <td>Email</td>
                    <td><?php echo $data->meta_value; ?></td>
                </tr>
                <?php
                  }
                ?>
                <?php 
                  if($data->meta_key == '_billing_phone') {
                ?>
                <tr>
                    <td>Phone</td>
                    <td><?php echo $data->meta_value; ?></td>
                </tr>
                <?php
                  }
                ?>

                <?php 
                  if($data->meta_key == '_shipping_route') {
                ?>
                <tr>
                    <td>Shipping Route</td>
                    <td><?php echo $data->meta_value; ?></td>
                </tr>
                <?php
                  }
                ?>

                <?php 
                  if($data->meta_key == '_order_total') {
                ?>
                <tr>
                    <td>Order Total</td>
                    <td><?php echo $data->meta_value; ?></td>
                </tr>
               
                <?php
                      }
                    }
                }}
                }
                ?>
            </table>
        </div>
        <div class="form-group col-md-6" id = "container">
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
                            if ($customer == false && $locations) {
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
