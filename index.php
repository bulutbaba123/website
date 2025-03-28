<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ganimet Mağazası</title>
    <link rel="icon" href="Png/Logo.png" type="image/png">
    <link rel="stylesheet" href="styles.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js" integrity="sha512-DUC8yqWf7ez3JD1jszxCWSVB0DMP78eOyBpMa5aJki1bIRARykviOuImIczkxlj1KhVSyS16w2FSQetkD4UU2w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style>
        .menu {
            display: none;
            position: absolute;
            background-color: #333;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
            z-index: 1000;
            width: 200px;
            right: 0;
            top: 50px;
            padding: 5px;
        }
        .category {
            padding: 20px;
        }
       .category img{
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 5px;
       }
        .user-profile.active .menu {
            display: block;
            text-align: center;
        }

        .item {
            padding: 5px; /* Daha az boşluk */
            text-align: left;
        }

        .item a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 3px 5px; /* Daha az padding */
            transition: background 0.3s;
            border-radius: 5px;
            font-size: 14px; /* Yazı boyutunu küçült */
        }

        .item a:hover {
            background: #555;
        }
    </style>
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
        <?php
        if (isset($_SESSION['login_successful']) && $_SESSION['login_successful'] === true) {
            echo '<div id="successMessage" style="text-align: center; color: black; margin-bottom: 10px; background-color: #8fdda3;">Giriş Başarılı!</div>';
            unset($_SESSION['login_successful']); // Mesajı sadece bir kere göster
        }

        if (isset($_SESSION['register_successful']) && $_SESSION['register_successful'] === true) {
            echo '<div id="successMessage" style="text-align: center; color: black; margin-bottom: 10px; background-color: #8fdda3;">Kayıt Başarılı!</div>';
            unset($_SESSION['register_successful']); // Mesajı sadece bir kere göster
        }
        ?>
        <section id="game-categories" class="games-section">
            <h2>Oyun Kategorileri</h2>
            <div class="game-list">
                <a class="category" href="oyun-sayfalari/pubg-mobile.php">
                    <div class="game-card">
                        <img src="Png/pubgmobile.png"
                            alt="Pubg Mobile">
                        <h3>Pubg Mobile</h3>
                    </div>
                </a>
                <a class="category" href="oyun-sayfalari/valorant.php">
                    <div class="game-card">
                        <img src="Png/valorant.png"
                            alt="Valorant">
                        <h3>Valorant</h3>
                    </div>
                </a>
                <a class="category" href="oyun-sayfalari/league-of-legends.php">
                    <div class="game-card">
                        <img src="Png/lol.png"
                            alt="League Of Legends">
                        <h3>League Of Legends</h3>
                    </div>
                </a>
                <a class="category" href="oyun-sayfalari/cs2-counter-strike-2.php">
                    <div class="game-card">
                        <img src="Png/cs2.png"
                            alt="Counter Strike 2">
                        <h3>Counter Strike 2</h3>
                    </div>
                </a>
                <a class="category" href="oyun-sayfalari/black-desert-online.php">
                    <div class="game-card">
                        <img src="Png/blackdesert.png"
                            alt="Black Desert Online Acoin">
                        <h3>Black Desert Online Acoin</h3>
                    </div>
                </a>
                <a class="category" href="oyun-sayfalari/knight-online.php">
                    <div class="game-card">
                        <img src="Png/knightonline.png"
                            alt="Knight Online">
                        <h3>Knight Online</h3>
                    </div>
                </a>
                <a class="category" href="oyun-sayfalari/growtopia.php">
                    <div class="game-card">
                        <img src="Png/growtopia.png
                        " alt="Growtopia">
                        <h3>Growtopia</h3>
                    </div>
                </a>
                <a class="category" href="oyun-sayfalari/roblox.php">
                    <div class="game-card">
                        <img src="Png/roblox.png
                        " alt="Roblox">
                        <h3>Roblox</h3>
                    </div>
                </a>
                <a class="category" href="oyun-sayfalari/steam.php">
                    <div class="game-card">
                        <img src="Png/steam.png" alt="Roblox">
                        <h3>Steam</h3>
                    </div>
                </a>
                <a class="category" href="oyun-sayfalari/google-play-hediye-kartlari.php">
                    <div class="game-card">
                        <img src="Png/playcard.png" alt="Google Play Hediye Kartları">
                        <h3>Google Play Hediye Kartları</h3>
                    </div>
                </a>
                <a class="category" href="oyun-sayfalari/supercell.php">
                    <div class="game-card">
                        <img src="Png/supercell.png" alt="Supercell">
                        <h3>Supercell</h3>
                    </div>
                </a>
                <a class="category" href="oyun-sayfalari/instagram.php">
                    <div class="game-card">
                        <img src="Png/instagram.png" alt="Instagram">
                        <h3>Instagram</h3>
                    </div>
                </a>
                <a class="category" href="oyun-sayfalari/tiktok.php">
                    <div class="game-card">
                        <img src="Png/tiktok.png" alt="Tiktok">
                        <h3>Tiktok</h3>
                    </div>
                </a>
                 <a class="category" href="oyun-sayfalari/youtube.php">
                    <div class="game-card">
                        <img src="Png/youtube.png" alt="Youtube">
                        <h3>Youtube</h3>
                    </div>
                </a>
                <a class="category" href="oyun-sayfalari/kick.php">
                    <div class="game-card">
                        <img src="Png/kick.png" alt="Kick">
                        <h3>Kick</h3>
                    </div>
                </a>
                <a class="category" href="oyun-sayfalari/twitch.php">
                    <div class="game-card">
                        <img src="Png/twitch.png" alt="Twitch">
                        <h3>Twitch</h3>
                    </div>
                </a>
                <a class="category" href="oyun-sayfalari/twitter-x.php">
                    <div class="game-card">
                        <img src="Png/twitter.png" alt="Twitter (X)">
                        <h3>Twitter (X)</h3>
                    </div>
                </a>
                <a class="category" href="oyun-sayfalari/xbox.php">
                    <div class="game-card">
                        <img src="Png/xbox.png" alt="Xbox">
                        <h3>Xbox</h3>
                    </div>
                </a>
            </div>
        </section>
    </main>
    <script src="script.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.querySelector('.menu-toggle');
            const mainNav = document.querySelector('.main-nav');
            const searchInput = document.getElementById("search-input");
            const searchResults = document.getElementById("search-results");

            menuToggle.addEventListener('click', function() {
                mainNav.classList.toggle('active');
            });

            searchInput.addEventListener("input", function() {
                searchGames(searchInput.value.toLowerCase(), searchResults);
            });

            // Kullanıcı adını veritabanından çekme işlemi
            fetch('/get-username')
                .then(response => response.json())
                .then(data => {
                    const usernameElement = document.getElementById('username');
                    usernameElement.textContent = data.username;
                })
                .catch(error => {
                    console.error('Kullanıcı adı alınamadı:', error);
                });

            const userProfile = document.querySelector('.user-profile');

            if (userProfile) {
                userProfile.addEventListener('click', function(event) {
                    userProfile.classList.toggle('active');
                    event.stopPropagation(); // Tıklama olayının yukarıya doğru yayılmasını engelle
                });

                document.addEventListener('click', function(event) {
                    if (!userProfile.contains(event.target)) {
                        userProfile.classList.remove('active');
                    }
                });
            }

            // Başarı mesajını otomatik olarak gizle
            const successMessage = document.getElementById('successMessage');
            if (successMessage) {
                setTimeout(function() {
                    successMessage.style.display = 'none';
                }, 4000); // 4 saniye sonra kaybol
            }
        });

        function changeLanguage(lang) {
            // Sayfa dilini değiştirme işlemleri burada yapılacak
            // Örnek: Sayfayı yenileyerek dili değiştir
            window.location.href = '?lang=' + lang;
        }
    </script>
</body>

</html>