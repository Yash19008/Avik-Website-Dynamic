<?php
include 'inc/db.php';
include 'inc/header.php';
include 'inc/sidebar.php';

$id = (int)($_GET['id'] ?? 0);
$data = [
    'title' => '',
    'slug' => '',
    'cat_id' => '',
    'content' => '',
    'tags' => '',
    'bg_image' => ''
];

if ($id) {
    $res = mysqli_query($conn, "SELECT * FROM blogs WHERE id=$id");
    $data = mysqli_fetch_assoc($res);
}

$cats = mysqli_query($conn, "SELECT id,name FROM blog_categories");
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1><?php echo $id ? 'Edit' : 'Add'; ?> Blog</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="card">
                <div class="card-body">

                    <form id="blogForm" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="old_image" value="<?php echo $data['bg_image']; ?>">

                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" id="title" class="form-control"
                                value="<?php echo htmlspecialchars($data['title']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Slug</label>
                            <input type="text" name="slug" id="slug" class="form-control"
                                value="<?php echo $data['slug']; ?>">
                        </div>

                        <div class="form-group">
                            <label>Category</label>
                            <select name="cat_id" class="form-control" required>
                                <option value="">Select</option>
                                <?php while ($c = mysqli_fetch_assoc($cats)): ?>
                                    <option value="<?php echo $c['id']; ?>"
                                        <?php if ($c['id'] == $data['cat_id']) echo 'selected'; ?>>
                                        <?php echo $c['name']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Background Image</label>
                            <input type="file" name="bg_image" class="form-control">
                            <?php if ($data['bg_image']): ?>
                                <img src="<?php echo $data['bg_image']; ?>" width="150" class="mt-2">
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label>Content</label>
                            <textarea name="content" id="content" class="form-control"><?php echo $data['content']; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label>Tags (comma separated)</label>
                            <input type="text" name="tags" class="form-control"
                                value="<?php echo htmlspecialchars($data['tags']); ?>">
                        </div>

                        <button class="btn btn-success">Save</button>

                    </form>

                </div>
            </div>

        </div>
    </section>
</div>
<?php
include 'inc/footer.php';
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $('#content').summernote({
        height: 300
    });

    /* AUTO SLUG */
    $('#title').on('keyup', function() {
        let slug = $(this).val()
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/(^-|-$)/g, '');
        $('#slug').val(slug);
    });

    /* SAVE */
    $('#blogForm').submit(function(e) {
        e.preventDefault();
        let fd = new FormData(this);
        fd.append('action', 'save');

        $.ajax({
            url: 'process_blogs.php',
            type: 'POST',
            data: fd,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    Swal.fire('Saved', res.message, 'success')
                        .then(() => location.href = 'manage-blogs.php');
                } else {
                    Swal.fire('Error', res.message, 'error');
                }
            }
        });
    });
</script>