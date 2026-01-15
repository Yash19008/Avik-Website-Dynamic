<?php
include 'inc/db.php';
include 'inc/header.php';
include 'inc/sidebar.php';

$id = (int)($_GET['id'] ?? 0);
$data = [
    'title' => '',
    'slug' => '',
    'date' => '',
    'time' => '',
    'content' => '',
    'info' => '',
    'speaker_name' => '',
    'speaker_desg' => '',
    'speaker_desc' => '',
    'speaker_image' => '',
    'speaker_socials' => '[]'
];

if ($id) {
    $res = mysqli_query($conn, "SELECT * FROM events WHERE id=$id");
    $data = mysqli_fetch_assoc($res);
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1><?php echo $id ? 'Edit' : 'Add'; ?> Event</h1>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-body">

                <form id="eventForm" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="old_image" value="<?php echo $data['speaker_image']; ?>">

                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" id="title" class="form-control" value="<?php echo htmlspecialchars($data['title']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Slug</label>
                        <input type="text" name="slug" id="slug" class="form-control" value="<?php echo $data['slug']; ?>">
                    </div>

                    <div class="form-group">
                        <label>Event Images</label>
                        <input type="file" name="images[]" class="form-control mb-2" multiple>

                        <?php
                        $imgs = json_decode($data['images'] ?? '[]', true);
                        if ($imgs):
                        ?>
                            <div class="row">
                                <?php foreach ($imgs as $img): ?>
                                    <div class="col-md-2 text-center">
                                        <img src="<?php echo $img; ?>" class="img-fluid mb-1">
                                        <button type="button"
                                            class="btn btn-danger btn-sm removeImage"
                                            data-img="<?php echo $img; ?>">
                                            Remove
                                        </button>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <input type="hidden" name="removed_images" id="removed_images">
                    </div>

                    <div class="form-group">
                        <label>Date</label>
                        <input type="text" name="date" class="form-control" value="<?php echo $data['date']; ?>">
                    </div>

                    <div class="form-group">
                        <label>Time</label>
                        <input type="text" name="time" class="form-control" value="<?php echo $data['time']; ?>">
                    </div>

                    <div class="form-group">
                        <label>Info</label>
                        <input type="text" name="info" class="form-control" value="<?php echo htmlspecialchars($data['info']); ?>">
                    </div>

                    <div class="form-group">
                        <label>Content</label>
                        <textarea name="content" id="content" class="form-control"><?php echo $data['content']; ?></textarea>
                    </div>

                    <hr>
                    <h5>Speaker</h5>

                    <input class="form-control mb-2" name="speaker_name" placeholder="Name" value="<?php echo $data['speaker_name']; ?>">
                    <input class="form-control mb-2" name="speaker_desg" placeholder="Designation" value="<?php echo $data['speaker_desg']; ?>">
                    <textarea class="form-control mb-2" name="speaker_desc" placeholder="Description"><?php echo $data['speaker_desc']; ?></textarea>

                    <input type="file" name="speaker_image" class="form-control mb-2">
                    <?php if ($data['speaker_image']): ?>
                        <img src="<?php echo $data['speaker_image']; ?>" width="120">
                    <?php endif; ?>

                    <hr>
                    <h5>Speaker Socials</h5>

                    <table class="table" id="socialTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Link</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                    <button type="button" class="btn btn-sm btn-secondary" id="addSocial">Add Social</button>

                    <input type="hidden" name="speaker_socials" id="speaker_socials">

                    <br><br>
                    <button class="btn btn-success">Save</button>
                </form>

            </div>
        </div>
    </section>
</div>

<?php include 'inc/footer.php'; ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $('#content').summernote({
        height: 250
    });

    /* slug */
    $('#title').keyup(function() {
        $('#slug').val($(this).val().toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, ''));
    });

    /* socials */
    let socials = <?php echo $data['speaker_socials'] ?: '[]'; ?>;

    function renderSocials() {
        let html = '';
        socials.forEach((s, i) => {
            html += `<tr>
            <td><input class="form-control" value="${s.name}" onchange="socials[${i}].name=this.value"></td>
            <td><input class="form-control" value="${s.link}" onchange="socials[${i}].link=this.value"></td>
            <td><button type="button" class="btn btn-danger btn-sm" onclick="socials.splice(${i},1);renderSocials()">X</button></td>
        </tr>`;
        });
        $('#socialTable tbody').html(html);
        $('#speaker_socials').val(JSON.stringify(socials));
    }
    renderSocials();

    $('#addSocial').click(() => {
        socials.push({
            name: '',
            link: ''
        });
        renderSocials();
    });

    /* save */
    $('#eventForm').submit(function(e) {
        e.preventDefault();
        let fd = new FormData(this);
        fd.append('action', 'save');

        $.ajax({
            url: 'process_events.php',
            type: 'POST',
            data: fd,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: r => {
                if (r.status == 'success') {
                    Swal.fire('Saved', '', 'success').then(() => location.href = 'manage-events.php');
                } else Swal.fire('Error', r.message, 'error');
            }
        });
    });

    let removedImages = [];

    $('.removeImage').click(function() {
        let img = $(this).data('img');
        removedImages.push(img);
        $('#removed_images').val(JSON.stringify(removedImages));
        $(this).parent().remove();
    });
</script>