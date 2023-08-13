<?php
session_start();
include_once('db_connection.php');

if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = $_GET['id'];
    $select_sql = "SELECT * FROM add_medicine WHERE id = $id";
    $result = $conn->query($select_sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $quantity = $row['quantity'];
        $purchasedate = $row['purchasedate'];
        $expirationdate = $row['expirationdate'];

        // Determine the deletion reason based on the action
        if ($action === 'delete') {
            $deletionReason = "Deleted";
        } elseif ($action === 'mark_expired') {
            $deletionReason = "Expired";
            $update_sql = "UPDATE add_medicine SET expirationdate = NOW() WHERE id = $id";
            $conn->query($update_sql);
        }

        // Insert the material into the "deleted_materials" table with the deletion reason
        $insert_sql = "INSERT INTO deleted_materials (name, quantity, purchasedate, expirationdate, deletion_reason) 
                       VALUES ('$name', $quantity, '$purchasedate', '$expirationdate', '$deletionReason')";
        $conn->query($insert_sql);

        // Delete related records in the "material_edits" table first
        $delete_material_edits_stmt = $conn->prepare("DELETE FROM material_edits WHERE material_id = ?");
        $delete_material_edits_stmt->bind_param("i", $id);
        $delete_material_edits_stmt->execute();

        // Delete related records in the "patient_tools" table first
        $delete_patient_tools_stmt = $conn->prepare("DELETE FROM patient_tools WHERE tool_id = ?");
        $delete_patient_tools_stmt->bind_param("i", $id);
        $delete_patient_tools_stmt->execute();

        // Delete the material from the "add_medicine" table
        $delete_material_stmt = $conn->prepare("DELETE FROM add_medicine WHERE id = ?");
        $delete_material_stmt->bind_param("i", $id);
        $delete_material_stmt->execute();

        // Set a success message in the session and redirect back to inventory.php
        $_SESSION['success'] = "Material has been successfully deleted.";
        header("Location: inventory.php");
        exit();
    }
}

// If the action or id is not set or there was an error, redirect back to inventory.php with an error message
$_SESSION['error'] = "Error occurred during deletion.";
header("Location: inventory.php");
exit();
?>
