<?php
// Check if an ID already exist 
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config file
    require_once "config.php";
    
    // Select the record from the table by ID
    $sql = "SELECT * FROM employees WHERE id = ?";
    
    if($stmt = mysqli_prepare($con, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["id"]);
        
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* Fetch result as an associative array because it contains only one row */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Retrieve individual field value
                $name = $row["name"];
                $address = $row["address"];
                $salary = $row["salary"];
            } else{
                // Url doesn't contain valid id parameter.
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Something went very wrong. Please try again.";
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($con);
} else{
    // Url doesn't contain valid id parameter.
    header("location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>View Record</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
            .wrapper{
                width: 500px;
                margin: 0 auto;
            }
        </style>
    </head>

    <body>
        <div class="wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-header">
                            <h1>Employee Detail</h1>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <p class="form-control-static"><?php echo $row["name"]; ?></p>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <p class="form-control-static"><?php echo $row["address"]; ?></p>
                        </div>
                        <div class="form-group">
                            <label>Salary</label>
                            <p class="form-control-static"><?php echo $row["salary"]; ?></p>
                        </div>
                        <p><a href="index.php" class="btn btn-default">Return to home page</a></p>
                    </div>
                </div>        
            </div>
        </div>
    </body>
</html>