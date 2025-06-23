<?php
session_start();
include("../connection/connect.php");
error_reporting(0);

if (!isset($_SESSION['adm_id'])) {
    // Redirect to login page
    header("Location: index.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the status is updated
    if (isset($_POST['status']) && isset($_POST['order_id'])) {
        $order_id = $_POST['order_id'];
        $status = $_POST['status'];

        // Update the order status in the database
        $update_query = "UPDATE users_orders SET order_status = '$status' WHERE o_id = $order_id";
        $result = mysqli_query($db, $update_query);

        if ($result) {
            // If the status is delivered, remove the order from the user's view
            if ($status === "delivered") {
                $remove_query = "DELETE FROM users_orders WHERE o_id = $order_id";
                $remove_result = mysqli_query($db, $remove_query);
                if ($remove_result) {
                    // Notify the user that their order has been delivered and removed
                    echo json_encode(array("success" => true, "newStatus" => $status, "message" => "Order delivered successfully and removed from your view."));
                    exit();
                } else {
                    echo json_encode(array("success" => false, "error" => "Failed to remove the order from the user's view."));
                    exit();
                }
            } else {
                // If status is updated successfully
                echo json_encode(array("success" => true, "newStatus" => $status));
                exit();
            }
        } else {
            echo json_encode(array("success" => false, "error" => "Failed to update status."));
            exit();
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" >
    <title>Admin Dashboard Template</title>
    <!-- Bootstrap Core CSS -->
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
   

</head>

<body class="fix-header fix-sidebar">
    <!-- Preloader - style you can find in spinners.css -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
			<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- Main wrapper  -->
    <div id="main-wrapper">
        <!-- header header  -->
         <div class="header">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <!-- Logo -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.html">
                        <!-- Logo icon -->
                        <b>Admin panel</b>
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        <span></span>
                    </a>
                </div>
                <!-- End Logo -->
                <div class="navbar-collapse">
                    <!-- toggle and nav items -->
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted  " href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                        <li class="nav-item m-l-10"> <a class="nav-link sidebartoggler hidden-sm-down text-muted  " href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                   
                       
                    </ul>
                    <!-- User profile and search -->
                    <ul class="navbar-nav my-lg-0">
                        
                        <!-- Search -->
                        <li class="nav-item hidden-sm-down search-box"> <a class="nav-link hidden-sm-down text-muted  " href="javascript:void(0)"><i class="ti-search"></i></a>
                            <form class="app-search">
                                <input type="text" class="form-control" placeholder="Search here"> <a class="srh-btn"><i class="ti-close"></i></a> </form>
                        </li>
                        <!-- Comment -->
                        <li class="nav-item dropdown">
                           
                            <div class="dropdown-menu dropdown-menu-right mailbox animated zoomIn">
                                <ul>
                                    <li>
                                        <div class="drop-title">Notifications</div>
                                    </li>
                                    
                                    <li>
                                        <a class="nav-link text-center" href="javascript:void(0);"> <strong>Check all notifications</strong> <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!-- End Comment -->
                      
                        <!-- Profile -->
                        <li class="nav-item dropdown">
                            
                            <a class="nav-link dropdown-toggle text-muted  " href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="images/bookingSystem/2.png" alt="user" class="profile-pic" /></a>
                            <div class="dropdown-menu dropdown-menu-right animated zoomIn">
                                <ul class="dropdown-user">
                                   <li><a href="logout.php"><i class="fa fa-power-off"></i> Logout</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- End header header -->
        <!-- Left Sidebar  -->
        <div class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                   <ul id="sidebarnav">
                        <li class="nav-devider"></li>
                        <li class="nav-label">Home</li>
                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-tachometer"></i><span class="hide-menu">Dashboard</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="dashboard.php">Dashboard</a></li>
                                
                            </ul>
                        </li>
                        <li class="nav-label">Log</li>
                        <li> <a class="has-arrow  " href="#" aria-expanded="false">  <span><i class="fa fa-user f-s-20 "></i></span><span class="hide-menu">Users</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="allusers.php">All Users</a></li>
								<li><a href="add_users.php">Add Users</a></li>
								
                               
                            </ul>
                        </li>
                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-archive f-s-20 color-warning"></i><span class="hide-menu">Store</span></a>
                            <ul aria-expanded="false" class="collapse">
								<li><a href="allrestraunt.php">All Stores</a></li>
								<li><a href="add_category.php">Add Category</a></li>
                                <li><a href="add_restraunt.php">Add Restaurant</a></li>
                                
                            </ul>
                        </li>
                      <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-cutlery" aria-hidden="true"></i><span class="hide-menu">Menu</span></a>
                            <ul aria-expanded="false" class="collapse">
								<li><a href="all_menu.php">All Menues</a></li>
								<li><a href="add_menu.php">Add Menu</a></li>
                              
                                
                            </ul>
                        </li>
						 <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span class="hide-menu">Orders</span></a>
                            <ul aria-expanded="false" class="collapse">
								<li><a href="all_orders.php">All Orders</a></li>
                                <li><a href="all_order_history.php">Delivered Order</a></li>
                                <li><a href="all_order_reject.php">Cancelled Order</a></li>
                            </ul>
                        </li>
                         
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </div>
        <!-- End Left Sidebar  -->
        <!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Dashboard</h3> </div>
               
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                <div class="row">
                    <div class="col-12">
                        
                       
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">All user Orders</h4>
                               
                                <div class="table-responsive m-t-40">
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Username</th>
                                                <th>Order ID</th>		
                                                <th>Title</th>
                                                <th>Quantity</th>
                                                <th>price</th>
                                                <th>Address</th>
                                                <th>Instruction</th>
												<th>status</th>						
												<th>Reg-Date</th>
												<th>View Order</th>
                                                                                                
												 
                                            </tr>
                                        </thead>
                                        <tbody>
                                           
											
										<?php
$sql = "SELECT users.username, users_orders.*, users.address AS user_address FROM users INNER JOIN users_orders ON users.u_id=users_orders.u_id ORDER BY users_orders.u_id";
$query = mysqli_query($db, $sql);

$prevUsername = null; // Variable to store the previous username

if (!mysqli_num_rows($query) > 0) {
    echo '<td colspan="9"><center>No Orders-Data!</center></td>';
} else {
    while ($rows = mysqli_fetch_array($query)) {
        if ($prevUsername !== $rows['username']) {
            // If the current username is different from the previous one, display the username
            echo '<tr><td rowspan="' . countRowsWithSameUsername($db, $rows['username']) . '">' . $rows['username'] . '</td>';
        }
        echo '<td>' . $rows['o_id'] . '</td>'; // Displaying order ID
        echo '<td>' . $rows['title'] . '</td>
              <td>' . $rows['quantity'] . '</td>
              <td>' . $rows['price'] . '</td>
              <td>' . $rows['user_address'] . '</td>
              <td>' . $rows['instruction'] . '</td>'; // Displaying instruction

        // Assigning the value of order status to $status variable
        $status = $rows['order_status'];

        // Output the status dropdown inside a table cell
        echo '<td>
                <form id="update-form-' . $rows['o_id'] . '" method="post" action="update_status.php">
                    <input type="hidden" name="order_id" value="' . $rows['o_id'] . '">
                    <select name="status" onchange="updateOrderStatus(this, ' . $rows['o_id'] . ')">
                        <option value="dispatch" class="btn btn-info" ' . ($status == "" or $status == "NULL" ? 'selected' : '') . '>Dispatch</option>
                        <option value="on_way" class="btn btn-warning" ' . ($status == "on_way" ? 'selected' : '') . '>On the way</option>
                        <option value="delivered" class="btn btn-success" ' . ($status == "delivered" ? 'selected' : '') . '>Delivered</option>
                        <option value="rejected" class="btn btn-danger" ' . ($status == "rejected" ? 'selected' : '') . '>Rejected</option>
                    </select>
                </form>
              </td>';

        // Output the date column
        echo '<td>' . $rows['date'] . '</td>';

        // Output the action buttons
        echo '<td>
                  <a href="delete_orders.php?order_del=' . $rows['o_id'] . '" onclick="return confirm(\'Are you sure?\');" class="btn btn-danger btn-flat btn-addon btn-xs m-b-10"><i class="fa fa-trash-o" style="font-size:16px"></i></a> 
                  <a href="view_order.php?user_upd=' . $rows['o_id'] . '" class="btn btn-info btn-flat btn-addon btn-sm m-b-10 m-l-5"><i class="ti-settings"></i></a>
              </td>
              </tr>';

        // Update the previous username variable
        $prevUsername = $rows['username'];
    }
}

function countRowsWithSameUsername($db, $username)
{
    $sql = "SELECT COUNT(*) AS count FROM users INNER JOIN users_orders ON users.u_id=users_orders.u_id WHERE users.username='$username'";
    $query = mysqli_query($db, $sql);
    $result = mysqli_fetch_assoc($query);
    return $result['count'];
}
?>


                                                                                                 <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
$(document).ready(function() {
    // Function to update order status
    function updateOrderStatus(selectElement, orderId) {
        var formData = $(selectElement).closest('form').serialize();

        $.ajax({
            type: 'POST',
            url: 'update_status.php',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Update the status HTML element with the new status
                    $('#status_' + orderId).html(response.newStatus);
                    // Show alert after each successful update
                    alert('Status updated successfully');
                } else {
                    alert('Error updating status: ' + response.error);
                }
            },
            error: function() {
                alert('Failed to communicate with the server.');
            }
            
        });
    }

    // When the document is ready, retrieve order statuses from local storage and set the selected options
    $('select[name="status"]').each(function() {
        var orderId = $(this).closest('form').find('input[name="order_id"]').val();
        var status = localStorage.getItem('order_status_' + orderId);
        if (status) {
            $(this).val(status);
        }
    });

    // Unbind any existing event listeners for the change event on select elements
    $('select[name="status"]').off('change');

    // Listen for change event on select elements to update order status
    $('select[name="status"]').on('change', function() {
        var orderId = $(this).closest('form').find('input[name="order_id"]').val();
        var status = $(this).val();
        updateOrderStatus(this, orderId);
        // Store the updated status in local storage
        localStorage.setItem('order_status_' + orderId, status);
    });
});


</script>
														
                                            
                                           
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
						 </div>
                      
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End PAge Content -->
            </div>
            <!-- End Container fluid  -->
			
			
			
			
            <!-- footer -->
            <footer class="footer"><a href="https://colorlib.com"></a></footer>
            <!-- End footer -->
        </div>
        <!-- End Page wrapper  -->
    </div>
    <!-- End Wrapper -->
    <!-- All Jquery -->
    <script src="js/lib/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="js/lib/bootstrap/js/popper.min.js"></script>
    <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Menu sidebar -->
    <script src="js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <!--Custom JavaScript -->
    <script src="js/custom.min.js"></script>


    <script src="js/lib/datatables/datatables.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="js/lib/datatables/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <script src="js/lib/datatables/datatables-init.js"></script>
</body>

</html>
