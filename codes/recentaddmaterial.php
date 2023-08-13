<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recent Add Material</title>
     
    <link rel="stylesheet" href="https://code.jquery.com/jquery-1.11.1.min.js">
  
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap.min.css">
  <!--CSS-->
  <link rel="stylesheet" href="dashboard2.css">
  <!--Boxicons-->
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <!-- Font Awesome -->
  

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
</head>
<body>

    <div class="container">
    
        <div class="row justify-content-center">
        
            <div class="col-md-12">
            
                <div class="card mt-5">
                
                    <div class="card-header">
                
                        <h4>LASTEST ADD ON INVENTORY</h4>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                    <th>No</th>
						            <th>Material</th>
						            <th>Quantity</th>
						            <th>Purchase date</th>
						            <th>Expiration date</th>
                                    
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $con = mysqli_connect("localhost","root","","capstone");

                                    $query = "SELECT * FROM add_medicine ORDER BY id DESC LIMIT 5";
                                    $query_run = mysqli_query($con, $query);

                                    if(mysqli_num_rows($query_run) > 0)
                                    {
                                        foreach($query_run as $row)
                                    {
                                        ?>
                                        <tr>
                                            <td><?= $row['id']; ?></td>
                                            <td><?= $row['name']; ?></td>
                                            <td><?= $row['quantity']; ?></td>
                                            <td><?= $row['purchasedate']; ?></td>
                                            <td><?= $row['expirationdate']; ?></td>
                                        </tr>
                                        <?php
                                    }
                                    
                                }
                                else
                                {
                                    ?>
                                    <tr>   
                                        <td colspan="4"> NO RECORD FOUND </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>

                       
                            </table>
                            <a href="inventory.php" class="btn btn-success"><span class=""></span>Back</a>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
</html>