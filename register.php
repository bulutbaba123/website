<?php
session_start();
include("./baglanti.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ad_soyad = $_POST["ad_soyad"];
    $email = $_POST["email"];
    $telefon = $_POST["telefon"];
    $sifre = $_POST["sifre"];
    $date = date("Y-m-d H:i:s");
    // Kullanıcı adı ve şifre uzunluğunu kontrol et
    if (strlen($ad_soyad) > 25) {
        $error = "Hata: Kullanıcı adı en fazla 25 karakter olmalıdır.";
    } elseif (strlen($sifre) > 25) {
        $error = "Hata: Şifre en fazla 25 karakter olmalıdır.";
    } else {
        // Aynı e-posta, telefon veya kullanıcı adı ile kayıt olup olmadığını kontrol et
        $checkQuery = $conn->prepare("SELECT COUNT(*) FROM user WHERE name = ? OR gmail = ? OR phone = ?");
        $checkQuery->execute([$ad_soyad, $email, $telefon]);
        $count = $checkQuery->fetchColumn();

        if ($count > 0) {
            $error = "Hata: Bu kullanıcı adı, e-posta veya telefon numarası zaten kullanımda.";
        } else {
            try {
                // Şifreyi olduğu gibi kaydet - hash'leme kaldırıldı çünkü veritabanı sütunu 25 karakter ile sınırlı
                $i = $conn->prepare("INSERT INTO user (name, gmail, phone, pass, date, profile_picture, balance) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $i->execute([
                    $ad_soyad,
                    $email, 
                    $telefon, 
                    $sifre, // Şifre artık hash'lenmeden kaydediliyor
                    $date,
                    'Png/user.png', // Varsayılan profil resmi
                    '0.00' // Başlangıç bakiyesi
                ]);

                if ($i) {
                    $_SESSION['success_message'] = "Kayıt Başarılı!";
                    $_SESSION['user_name'] = $ad_soyad;
                    $_SESSION['profile_picture'] = 'Png/user.png';
                    $_SESSION['balance'] = '0.00';
                    $_SESSION['register_successful'] = true; // Kayıt başarılı oturum değişkeni
                    header("Location: index.php");
                    exit;
                } else {
                    $error = "Kayıt Başarısız!";
                }
            } catch (PDOException $e) {
                $error = "Veritabanı hatası: " . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kaydol</title>
    <link rel="icon" href="Png/Logo.png" type="image/png">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .register-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background: rgba(0, 0, 0, 0.8);
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
            transition: transform 0.3s, opacity 0.3s;
        }

        .register-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .register-container input {
            width: calc(100% - 20px); /* Taşmayı önlemek için */
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            box-sizing: border-box; /* Taşmayı önlemek için */
            height: 30px;
        }

        .register-container button {
            width: calc(100% - 20px); /* Taşmayı önlemek için */
            padding: 10px;
            background: #007bff;
            border: none;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
            box-sizing: border-box; /* Taşmayı önlemek için */
        }

        .register-container button:hover {
            background: #0056b3;
        }

        .register-container a {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #fff;
            text-decoration: none;
        }

        .input-group {
            display: flex;
            align-items: center;
        }

        .input-group .input-group-addon {
            padding: 5px; /* Ayarlanmış padding */
            background: #eee;
            border-radius: 5px 0 0 5px;
            color: #555;
            height: 20px; /* Küçültülmüş yükseklik */
            display: flex; /* İkonu dikeyde ortalamak için */
            align-items: center; /* İkonu dikeyde ortalamak için */
            justify-content: center; /* İkonu yatayda ortalamak için */
        }

        .input-group input {
            border-radius: 0 5px 5px 0;
            padding-left: 10px;
            height: 30px; /* Küçültülmüş yükseklik */
            flex: 1;
        }
    </style>
</head>

<body>
    <div class="register-container">
        <h2>Kaydol</h2>
        <form action="register.php" method="post">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" name="ad_soyad" placeholder="Ad Soyad" required>
            </div>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                <input type="email"  name="email" placeholder="Email" required>
            </div>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                <input type="tel"  name="telefon" placeholder="Telefon Numarası" required>
            </div>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="password"  name="sifre" placeholder="Şifre" required>
            </div>
            <button type="submit">Kaydol</button>
        </form>
        <a href="login.php">Zaten hesabınız var mı? Giriş Yapın</a>
    </div>
</body>
</html>