<?php
include_once('db_connection.php'); // Include your database connection

if(isset($_POST['submit'])) {
    $dateFrom = $_POST['date_from'];
    $dateTo = $_POST['date_to'];

    // Check if both date fields are not empty
    if (!empty($dateFrom) && !empty($dateTo)) {
        // Query to retrieve data within the selected date range
        $sql = "SELECT * FROM sales_report WHERE Date BETWEEN '$dateFrom' AND '$dateTo'";
        $result = $conn->query($sql);

        echo '<table class="table table-bordered">';
        echo '<thead>';
        echo '<tr>';
        echo '<th colspan="3">Service Sales</th>';
        echo '<th>0</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $totalSales = 0;

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row["ID"] . '</td>';
                echo '<td>' . $row["Date"] . '</td>';
                echo '<td>' . $row["Name"] . '</td>';
                echo '<td>' . $row["Service"] . '</td>';
                echo '</tr>';

                // Assuming there's a SalesValue column in the sales_report table
            }
        } else {
            echo '<tr><td colspan="4">No results found.</td></tr>';
        }

        echo '</tbody>';
        echo '<tfoot>';
        echo '<tr>';
        echo '<th colspan="3">Total:</th>';
        echo '<th>' . $totalSales . '</th>';
        echo '</tr>';
        echo '</tfoot>';
        echo '</table>';
    } else {
        echo "Please enter both date values.";
    }
}
?>
