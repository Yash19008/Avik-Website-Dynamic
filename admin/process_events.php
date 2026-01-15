<?php

declare(strict_types=1);

include 'inc/db.php';
header('Content-Type: application/json');

/* -------------------- CONFIG -------------------- */
$uploadDir = __DIR__ . '/uploads/events/';
$allowedExt = ['jpg', 'jpeg', 'png', 'webp'];
$allowedMime = ['image/jpeg', 'image/png', 'image/webp'];

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

/* -------------------- HELPERS -------------------- */
function clean(string $val): string
{
    return trim(htmlspecialchars($val, ENT_QUOTES, 'UTF-8'));
}

function generateSlug(string $text): string
{
    return strtolower(trim(preg_replace('/[^a-z0-9]+/', '-', $text), '-'));
}

function safeDelete(string $file, string $baseDir): void
{
    $real = realpath($file);
    if ($real && str_starts_with($real, realpath($baseDir)) && file_exists($real)) {
        unlink($real);
    }
}

function uploadImage(array $file, string $dir, array $allowedExt, array $allowedMime): ?string
{
    if ($file['error'] !== UPLOAD_ERR_OK) return null;

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $mime = mime_content_type($file['tmp_name']);

    if (!in_array($ext, $allowedExt) || !in_array($mime, $allowedMime)) {
        return null;
    }

    $name = time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
    $path = $dir . $name;

    return move_uploaded_file($file['tmp_name'], $path) ? $path : null;
}

/* -------------------- VALIDATE ACTION -------------------- */
$action = $_POST['action'] ?? '';
if (!in_array($action, ['save', 'delete'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
    exit;
}

/* ==================== SAVE ==================== */
if ($action === 'save') {
    try {
        $id = (int)($_POST['id'] ?? 0);

        $title = clean($_POST['title'] ?? '');
        $slug = clean($_POST['slug'] ?? '');
        $slug = $slug ?: generateSlug($title);

        $date = clean($_POST['date'] ?? '');
        $time = clean($_POST['time'] ?? '');
        $info = clean($_POST['info'] ?? '');
        $content = $_POST['content'] ?? '';

        $speaker_name = clean($_POST['speaker_name'] ?? '');
        $speaker_desg = clean($_POST['speaker_desg'] ?? '');
        $speaker_desc = clean($_POST['speaker_desc'] ?? '');
        $socials = clean($_POST['speaker_socials'] ?? '');
        $oldImage = $_POST['old_image'] ?? '';

        /* SLUG UNIQUENESS */
        $stmt = $conn->prepare(
            "SELECT id FROM events WHERE slug=? AND id!=?"
        );
        $stmt->bind_param('si', $slug, $id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            throw new Exception('Slug already exists.');
        }
        $stmt->close();

        /* SPEAKER IMAGE */
        $speakerImage = $oldImage;
        if (!empty($_FILES['speaker_image']['name'])) {
            $newImg = uploadImage($_FILES['speaker_image'], $uploadDir, $allowedExt, $allowedMime);
            if ($newImg) {
                safeDelete($oldImage, $uploadDir);
                $speakerImage = $newImg;
            }
        }

        /* EXISTING GALLERY */
        $existingImages = [];
        if ($id > 0) {
            $r = $conn->prepare("SELECT images FROM events WHERE id=?");
            $r->bind_param('i', $id);
            $r->execute();
            $r->bind_result($imgJson);
            if ($r->fetch()) {
                $existingImages = json_decode($imgJson ?? '[]', true) ?: [];
            }
            $r->close();
        }

        /* REMOVED IMAGES */
        $removed = json_decode($_POST['removed_images'] ?? '[]', true);
        if (is_array($removed)) {
            foreach ($removed as $rm) {
                safeDelete($rm, $uploadDir);
                $existingImages = array_diff($existingImages, [$rm]);
            }
        }

        /* NEW GALLERY UPLOAD */
        if (!empty($_FILES['images']['name'][0])) {
            foreach ($_FILES['images']['name'] as $i => $n) {
                $file = [
                    'name' => $_FILES['images']['name'][$i],
                    'tmp_name' => $_FILES['images']['tmp_name'][$i],
                    'error' => $_FILES['images']['error'][$i]
                ];
                $img = uploadImage($file, $uploadDir, $allowedExt, $allowedMime);
                if ($img) $existingImages[] = $img;
            }
        }

        $imagesJson = json_encode(array_values($existingImages));

        /* INSERT / UPDATE */
        if ($id === 0) {
            $stmt = $conn->prepare("
                INSERT INTO events
                (title, slug, date, time, info, content,
                 speaker_name, speaker_desg, speaker_desc,
                 speaker_image, speaker_socials, images)
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?)
            ");
            $stmt->bind_param(
                'ssssssssssss',
                $title,
                $slug,
                $date,
                $time,
                $info,
                $content,
                $speaker_name,
                $speaker_desg,
                $speaker_desc,
                $speakerImage,
                $socials,
                $imagesJson
            );
        } else {
            $stmt = $conn->prepare("
                UPDATE events SET
                title=?, slug=?, date=?, time=?, info=?, content=?,
                speaker_name=?, speaker_desg=?, speaker_desc=?,
                speaker_image=?, speaker_socials=?, images=?
                WHERE id=?
            ");
            $stmt->bind_param(
                'ssssssssssssi',
                $title,
                $slug,
                $date,
                $time,
                $info,
                $content,
                $speaker_name,
                $speaker_desg,
                $speaker_desc,
                $speakerImage,
                $socials,
                $imagesJson,
                $id
            );
        }

        $stmt->execute();
        $stmt->close();

        echo json_encode(['status' => 'success']);
    } catch (Throwable $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}

/* ==================== DELETE ==================== */
if ($action === 'delete') {
    $id = (int)($_POST['id'] ?? 0);

    $stmt = $conn->prepare("SELECT images, speaker_image FROM events WHERE id=?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->bind_result($imgsJson, $speakerImg);
    if ($stmt->fetch()) {
        $imgs = json_decode($imgsJson ?? '[]', true) ?: [];
        foreach ($imgs as $img) {
            safeDelete($img, $uploadDir);
        }
        safeDelete($speakerImg, $uploadDir);
    }
    $stmt->close();

    $del = $conn->prepare("DELETE FROM events WHERE id=?");
    $del->bind_param('i', $id);
    $del->execute();
    $del->close();

    echo json_encode(['status' => 'success']);
}
