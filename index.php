<?php
include 'db.php';

// ดึงข้อมูลพนักงาน
$sql = "SELECT * FROM employees";
$employees = $conn->query($sql);

// ดึงข้อมูลสินค้า
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="custom.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>รายการสินค้า</title>
</head>
<body>
<div class="container">
    <h1 class="mt-5">รายการสินค้า</h1>
    <table id="productTable" class="table mt-3">
        <thead>
            <tr>
                <th>รหัสสินค้า</th>
                <th>ชื่อสินค้า</th>
                <th>แก้ไข</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td>
                        <button class="btn btn-primary edit-btn" data-id="<?= $row['id'] ?>" data-name="<?= $row['name'] ?>" data-bs-toggle="modal" data-bs-target="#editModal">แก้ไข by modal</button>
                        <a href="product_edit.php?id=<?= $row['id'] ?>" class="btn btn-secondary">แก้ไข by page </a> <!-- ปุ่มที่สอง -->
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Modal สำหรับแก้ไขชื่อสินค้า -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">แก้ไขชื่อสินค้า</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editForm">
          <input type="hidden" id="product_id" name="product_id">
          <div class="mb-3">
            <label for="new_name" class="form-label">ชื่อสินค้าใหม่</label>
            <input type="text" class="form-control" id="new_name" name="new_name" required>
          </div>
          <div class="mb-3">
            <label for="edited_by" class="form-label">เลือกพนักงาน</label>
            <select class="form-select" id="edited_by" name="edited_by" required>
              <option value="">เลือกพนักงาน</option>
              <?php while ($employee = $employees->fetch_assoc()): ?>
                  <option value="<?= $employee['id'] ?>"><?= $employee['name'] ?></option>
              <?php endwhile; ?>
            </select>
          </div>
          <button type="submit" class="btn btn-primary">บันทึก</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/toastr/build/toastr.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastr/build/toastr.min.css">

<script>
    // Initialize DataTable
    $(document).ready(function() {
        $('#productTable').DataTable();
    });

    $(document).on('click', '.edit-btn', function() {
        const productId = $(this).data('id');
        const oldName = $(this).data('name');

        $('#product_id').val(productId);
        $('#new_name').val(oldName);
    });

    $('#editForm').on('submit', function(e) {
        e.preventDefault();
        const formData = $(this).serialize();

        $.ajax({
            url: 'edit.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                const res = JSON.parse(response);
                if (res.status === 'success') {
                    toastr.success(res.message);
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                } else {
                    toastr.error(res.message);
                }
            },
            error: function() {
                toastr.error('เกิดข้อผิดพลาดในการแก้ไขชื่อสินค้า');
            }
        });
    });
</script>
</body>
</html>
