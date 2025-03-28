<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ganimet Mağazası</title>
    <link rel="icon" href="Png/Logo.png" type="image/png">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<header>
    <div class="logo">
        <img src="Png/Logo.png" alt="Logo">
    </div>
    <nav>
        <ul class="main-nav">
            <li><a href="index.php">Anasayfa</a></li>
            <li><a href="magaza.php">Mağaza</a></li>
            <li><a href="topluluk.php">Topluluk</a></li>
            <li><a href="hakkinda.php">Hakkında</a></li>
            <li><a href="destek.php">Destek</a></li>
        </ul>
    </nav>
    <div class="auth">
        <?php
        session_start();
        include("./baglanti.php");
        if (isset($_SESSION['user_name'])) {
            // Kullanıcı giriş yapmışsa profilini göster
            $userName = $_SESSION['user_name'];

            // Veritabanından kullanıcı bilgilerini çek
            $query = $conn->prepare("SELECT profile_picture, balance FROM user WHERE name = ?");
            $query->execute([$userName]);
            $user = $query->fetch(PDO::FETCH_ASSOC);
            $profilePicture = isset($user['profile_picture']) && !empty($user['profile_picture']) ? $user['profile_picture'] : 'Png/user.png';
            $balance = isset($user['balance']) ? $user['balance'] : '0.00';
            echo '<div class="user-profile">';
            echo '<div class="profile-info">';
             if (!empty($profilePicture)) {
                echo '<img src="' . htmlspecialchars($profilePicture) . '" alt="Profil Fotoğrafı" style="width: 40px; height: 40px; border-radius: 50%;">';
            } else {
                echo '<i class="fa-solid fa-circle-user" style="font-size: 40px; color: #fff; cursor: pointer;"></i>';
            }
            echo '</div>';
            echo '<div class="menu left transition" tabindex="-1">';
            echo '<div class="username">' . htmlspecialchars($userName) . '</div>';
            echo '<div class="item"><a href="bakiye.php"><i class="fas fa-coins"></i> Bakiye İşlemleri (' . htmlspecialchars($balance) . ' ₺)</a></div>';
            echo '<div class="item"><a href="profil.php"><i class="fas fa-user-circle"></i> Profilim</a></div>';
            echo '<div class="item"><a href="kontrol-merkezi.php"><i class="fas fa-user-tie"></i> Kontrol Merkezi</a></div>';
            echo '<div class="item"><a href="tum-siparislerim.php"><i class="fas fa-shopping-cart"></i> Siparişler</a></div>';
            echo '<div class="item"><a href="siparislerim.php"><i class="fas fa-shopping-basket"></i> Siparişlerim</a></div>';
            echo '<div class="item"><a href="ilanlarim.php"><i class="fas fa-store"></i> İlanlarım</a></div>';
            echo '<div class="item"><a href="favori-ilanlarim.php"><i class="fas fa-heart"></i> Favori İlanlarım</a></div>';
            echo '<div class="item"><a href="destek-sistemi.php"><i class="far fa-life-ring"></i> Destek Sistemi</a></div>';
            echo '<div class="item"><a href="https://discord.gg/UtjXNfpdG9" target="_blank"><i class="fab fa-discord"></i> Discord</a></div>';
            echo '<div class="item"><a href="cikis.php" class="cikisYapBtn"><i class="fas fa-sign-out-alt"></i> Çıkış</a></div>';
            echo '</div>';
            echo '</div>';
            } else {
                // Kullanıcı giriş yapmamışsa Giriş Yap ve Kaydol linklerini göster
                echo '<a href="login.php">Giriş Yap</a>';
                echo '<a href="register.php">Kaydol</a>';
            }
        ?>
        <div class="search-container">
            <input type="search" id="search-input" placeholder="Oyun Ara..." value=""
                data-gtm-form-interact-field-id="0">
            <button class="search-btn" type="submit">Ara</button>
            <div id="search-results" class="search-results"></div>
        </div>
        <div class="language-dropdown">
            <a href="#" id="dil">Dil</a>
            <div class="language-dropdown-content">
                <a href="#" onclick="changeLanguage('tr')">Türkçe</a>
                <a href="#" onclick="changeLanguage('en')">İngilizce</a>
                <a href="#" onclick="changeLanguage('es')">İspanyolca</a>
                <a href="#" onclick="changeLanguage('zh')">Çince</a>
            </div>
        </div>
    </div>
    <div class="menu-toggle">
        <span></span>
        <span></span>
        <span></span>
    </div>
</header>
    <main>
    <?php include('./adsense.php'); ?>
        <section class="content">
            <h1>Mağaza</h1>
            <p>Mağaza içeriği burada olacak.</p>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Ganimet Mağazası. Tüm hakları saklıdır.</p>
    </footer>
</body>
</html>
