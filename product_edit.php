<?php
// เชื่อมต่อฐานข้อมูล
require_once 'db.php';


// ตรวจสอบว่ามีรหัสสินค้าหรือไม่
if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // ดึงข้อมูลสินค้าจากฐานข้อมูล
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        die("ไม่พบสินค้า.");
    }
} else {
    die("ไม่พบ Product ID.");
}

?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="custom.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"> 
    <title>แก้ไขสินค้า</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-5 mx-auto">
            <h1 class="mt-5">แก้ไขสินค้า</h1>
            <form id="editForm" method="POST">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <div class="mb-3">
                    <label for="new_name" class="form-label">รายการ <?= $product['id']. ' : '.$product['name'];  ?>  : </label>
                    <input type="text" class="form-control" id="new_name" name="new_name" value="<?= $product['name'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="edited_by" class="form-label">เลือกพนักงาน</label>
                    <select class="form-select" id="edited_by" name="edited_by" required>
                        <option value="">เลือกพนักงาน</option>
                        <?php
                        
                        $employeeSql = "SELECT * FROM employees"; 
                        $employees = $conn->query($employeeSql);

                        while ($employee = $employees->fetch_assoc()): ?>
                            <option value="<?= $employee['id'] ?>"><?= $employee['name'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">บันทึก</button>
                <a href="index.php" class="btn btn-secondary">กลับ</a>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script> 
<script>

    $('#editForm').on('submit', function(e) {
        e.preventDefault();
        const formData = $(this).serialize();

        $.ajax({
            url: 'edit.php?id=<?= $productId ?>',
            type: 'POST',
            data: formData,
            success: function(response) {
                const res = JSON.parse(response);
                if (res.status === 'success') {
                    toastr.success(res.message); 
                    setTimeout(() => {
                        window.location.href = 'index.php'; 
                    }, 2000); // รอ 2 วินาทีก่อนเปลี่ยนหน้า
                } else {
                    toastr.error(res.message); 
                }
            },
            error: function() {
                toastr.error('เกิดข้อผิดพลาดในการอัปเดตสินค้า'); 
            }
        });
    });
</script>
</body>
</html>
