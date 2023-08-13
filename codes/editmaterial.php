<?php
session_start();
include_once('db_connection.php');

if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $quantity = $_POST['quantity'];
    $purchasedate = $_POST['purchasedate'];
    $expirationdate = $_POST['expirationdate'];

    // Retrieve the current material record to be edited
    $select_sql = "SELECT * FROM add_medicine WHERE id = '$id'";
    $result = $conn->query($select_sql);
    $row = $result->fetch_assoc();

    // Insert the previous version of the material into the material_edits table
    $insert_sql = "INSERT INTO material_edits (material_id, name, quantity, purchasedate, expirationdate)
                   VALUES ('$id', '{$row['name']}', '{$row['quantity']}', '{$row['purchasedate']}', '{$row['expirationdate']}')";
    $conn->query($insert_sql);

    // Update the record in the add_medicine table with the new values
    $update_sql = "UPDATE add_medicine SET name = '$name', quantity = '$quantity', purchasedate = '$purchasedate', expirationdate = '$expirationdate' WHERE id = '$id'";

    if ($conn->query($update_sql)) {
        $_SESSION['success'] = 'Material updated successfully';
    } else {
        $_SESSION['error'] = 'Something went wrong in updating Material';
    }
} else {
    $_SESSION['error'] = 'Select material to edit first';
}

header('location: inventory.php');
?>
