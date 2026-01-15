<?php
include 'inc/db.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include 'inc/header.php';
include 'inc/sidebar.php';
?>

<!-- DataTables -->
<link rel="stylesheet" href="./plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="./plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="./plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Manage Contacts</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Manage Contacts</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Contact Form Submissions</h3>
                        </div>
                        <?php
                        $query = "SELECT id, name, email, phone, subject, message, created_at FROM contacts ORDER BY id DESC";
                        $result = mysqli_query($conn, $query);
                        ?>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Subject</th>
                                        <th>Message</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (mysqli_num_rows($result) > 0): ?>
                                        <?php $i = 1;
                                        while ($row = mysqli_fetch_assoc($result)): ?>
                                            <tr id="row_<?php echo $row['id']; ?>">
                                                <td><?php echo $i++; ?></td>
                                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                                <td><?php echo htmlspecialchars($row['phone']); ?></td>
                                                <td><?php echo htmlspecialchars($row['subject']); ?></td>
                                                <td><?php echo htmlspecialchars($row['message']); ?></td>
                                                <td><?php echo date('d-m-Y', strtotime($row['created_at'])); ?></td>
                                                <td>
                                                    <button
                                                        class="btn btn-danger btn-sm delete-btn"
                                                        data-id="<?php echo $row['id']; ?>">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<?php
include 'inc/footer.php';
?>

<!-- DataTables  & Plugins -->
<script src="./plugins/datatables/jquery.dataTables.min.js"></script>
<script src="./plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="./plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="./plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="./plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="./plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="./plugins/jszip/jszip.min.js"></script>
<script src="./plugins/pdfmake/pdfmake.min.js"></script>
<script src="./plugins/pdfmake/vfs_fonts.js"></script>
<script src="./plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="./plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="./plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        $(document).on('click', '.delete-btn', function() {
            let id = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "This contact will be permanently deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'delete_contact.php',
                        type: 'POST',
                        data: {
                            id: id
                        },
                        success: function(response) {
                            if (response === 'success') {
                                $('#row_' + id).remove();

                                Swal.fire(
                                    'Deleted!',
                                    'Contact has been deleted.',
                                    'success'
                                );
                            } else {
                                Swal.fire(
                                    'Error!',
                                    'Something went wrong.',
                                    'error'
                                );
                            }
                        }
                    });
                }
            });
        });
    });
</script>