<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productId = $_POST['product_id'];
    $newName = $_POST['new_name'];
    $editedBy = $_POST['edited_by'];

    // ค้นชื่อสินค้าปัจจุบัน
    $sql = "SELECT name FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $oldName = $product['name'];

    // อัพเดทชื่อสินค้า
    $sql = "UPDATE products SET name = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $newName, $productId);
    $stmt->execute();

    // บันทึกการแก้ไข
    $sql = "INSERT INTO product_log (product_id, old_name, new_name, edited_by) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issi", $productId, $oldName, $newName, $editedBy);
    $stmt->execute();

    echo json_encode(['status' => 'success', 'message' => 'แก้ไขชื่อสินค้าเรียบร้อยแล้ว']);
    exit;
}
?>
