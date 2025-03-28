<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Giriş Yap</title>
    <link rel="icon" href="Png/Logo.png" type="image/png">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .login-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background: rgba(0, 0, 0, 0.8);
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
            transition: transform 0.3s, opacity 0.3s;
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .login-container input {
            width: calc(100% - 20px); /* Taşmayı önlemek için */
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            box-sizing: border-box; /* Taşmayı önlemek için */
            height: 38px;
        }

        .login-container button {
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

        .login-container button:hover {
            background: #0056b3;
        }

        .login-container a {
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
        }
    </style>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>
    <div class="login-container">
        <h2>Giriş Yap</h2>
        <form action="login.php" method="post">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" name="ad_soyad" placeholder="Ad Soyad" required>
            </div>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="password" name="sifre" placeholder="Şifre" required>
            </div>
            <button type="submit">Giriş Yap</button>
        </form>
        <a href="register.php">Hesabınız yok mu? Kaydolun</a>
        <?php
        if (isset($login_error)) {
            echo '<p style="color: red;">' . $login_error . '</p>';
        }
        ?>
    </div>
</body>
<?php
session_start();
include("./baglanti.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ad_soyad = $_POST["ad_soyad"];
    $sifre = $_POST["sifre"];

    if (strlen($ad_soyad) > 25) {
        $login_error = "Hata: Kullanıcı adı en fazla 25 karakter olmalıdır!";
    } elseif (strlen($sifre) > 25) {
        $login_error = "Hata: Şifre en fazla 25 karakter olmalıdır!";
    } else {
        $query = $conn->prepare("SELECT * FROM user WHERE name = ? AND pass = ?");
        $query->execute([$ad_soyad, $sifre]);
        $user = $query->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['success_message'] = "Giriş Başarılı!";
            $_SESSION['user_name'] = $ad_soyad;
            $_SESSION['profile_picture'] = isset($user['profile_picture']) ? $user['profile_picture'] : 'Png/user.png';
            $_SESSION['balance'] = isset($user['balance']) ? $user['balance'] : '0.00';
            $_SESSION['login_successful'] = true; // Giriş başarılı oturum değişkeni
            header("Location: index.php");
            exit;
        } else {
            $login_error = "Şifre veya kullanıcı adı hatalı!";
        }
    }
}
?>
</html>
