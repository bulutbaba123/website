<?php
session_start();
include("./baglanti.php");

if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userName = $_SESSION['user_name'];

    // Hazır profil fotoğrafı seçimi
    if (isset($_POST['profile_picture'])) {
        $profilePicture = $_POST['profile_picture'];

        // Veritabanına güncelleme
        $query = $conn->prepare("UPDATE user SET profile_picture = ? WHERE name = ?");
        $update = $query->execute([$profilePicture, $userName]);

        if ($update) {
            $_SESSION['profile_picture'] = $profilePicture;
            header("Location: profil.php");
            exit;
        } else {
            echo "Profil fotoğrafı güncellenirken bir hata oluştu.";
        }
    }

    // Yeni profil fotoğrafı yükleme
    if (isset($_FILES['new_profile_picture']) && $_FILES['new_profile_picture']['error'] == 0) {
        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
        $filename = $_FILES['new_profile_picture']['name'];
        $filetype = $_FILES['new_profile_picture']['type'];
        $filesize = $_FILES['new_profile_picture']['size'];

        // Dosya uzantısını kontrol et
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!array_key_exists($ext, $allowed)) {
            die("Hata: Lütfen geçerli bir dosya formatı seçin.");
        }

        // Dosya boyutunu kontrol et - örnek olarak 5MB
        $maxsize = 5 * 1024 * 1024;
        if ($filesize > $maxsize) {
            die("Hata: Dosya boyutu çok büyük. Lütfen 5MB'den küçük bir dosya seçin.");
        }

        // MIME türünü kontrol et
        if (!in_array($filetype, $allowed)) {
            die("Hata: İzin verilmeyen dosya türü.");
        }

        // Dosyayı yükle
        $uploadDir = "FotografProfil/";
        $uploadPath = $uploadDir . uniqid() . "_" . basename($filename);

        if (move_uploaded_file($_FILES['new_profile_picture']['tmp_name'], $uploadPath)) {
            // Veritabanına güncelleme
            $query = $conn->prepare("UPDATE user SET profile_picture = ? WHERE name = ?");
            $update = $query->execute([$uploadPath, $userName]);

            if ($update) {
                $_SESSION['profile_picture'] = $uploadPath;
                header("Location: profil.php");
                exit;
            } else {
                echo "Profil fotoğrafı güncellenirken bir hata oluştu.";
            }
        } else {
            echo "Dosya yüklenirken bir hata oluştu.";
        }
    } else {
         if (isset($_FILES['new_profile_picture'])) {
            switch ($_FILES['new_profile_picture']['error']) {
                case UPLOAD_ERR_INI_SIZE:
                    $_SESSION['error_message'] = "Yüklenen dosya çok büyük. Lütfen daha küçük bir dosya seçin.";
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    $_SESSION['error_message'] = "Yüklenen dosya çok büyük. Lütfen daha küçük bir dosya seçin.";
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $_SESSION['error_message'] = "Dosya yüklenirken bir sorun oluştu. Lütfen tekrar deneyin.";
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $_SESSION['error_message'] = "Lütfen bir dosya seçin.";
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    $_SESSION['error_message'] = "Sunucuda geçici klasör yapılandırılmamış.";
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    $_SESSION['error_message'] = "Dosya diske yazılamadı. Lütfen sunucu yöneticisine başvurun.";
                    break;
                case UPLOAD_ERR_EXTENSION:
                    $_SESSION['error_message'] = "Dosya yükleme bir PHP eklentisi tarafından durduruldu.";
                    break;
                default:
                    $_SESSION['error_message'] = "Bilinmeyen bir hata oluştu.";
                    break;
            }
        }
    }

    header("Location: profil.php");
    exit();
}
?>