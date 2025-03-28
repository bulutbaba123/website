<header>
    <div class="logo">
        <img src="/SatisWebsite/Png/Logo.png" alt="Logo">
    </div>
    <nav>
        <ul class="main-nav">
            <li><a href="../index.php">Anasayfa</a></li>
            <li><a href="../magaza.php">Mağaza</a></li>
            <li><a href="../topluluk.php">Topluluk</a></li>
            <li><a href="../hakkinda.php">Hakkında</a></li>
            <li><a href="../destek.php">Destek</a></li>
        </ul>
    </nav>
    <div class="auth">
        <?php
        session_start();
        include("../baglanti.php");
        if (isset($_SESSION['user_name'])) {
            // Kullanıcı giriş yapmışsa profilini göster
            $userName = $_SESSION['user_name'];
s
            // Veritabanından kullanıcı bilgilerini çek
            $query = $conn->prepare("SELECT profile_picture, balance FROM user WHERE name = ?");
            $query->execute([$userName]);
            $user = $query->fetch(PDO::FETCH_ASSOC);
            $profilePicture = isset($user['profile_picture']) && !empty($user['profile_picture']) ? $user['profile_picture'] : '/SatisWebsite/Png/user.png';
            $balance = isset($user['balance']) ? $user['balance'] : '0.00';
            echo '<div class="user-profile">';
            echo '<div class="profile-info">';
             if (!empty($profilePicture)) {
                echo '<img src="' . htmlspecialchars($profilePicture) . '" alt="Profil Fotoğrafı" style="width: 40px; height: 40px; border-radius: 50%;">';
            } else {
                echo '<img src="/SatisWebsite/Png/user.png" alt="Profil Fotoğrafı" style="width: 40px; height: 40px; border-radius: 50%;">';
            }
            echo '</div>';
            echo '<div class="menu left transition" tabindex="-1">';
            echo '<div class="username">' . htmlspecialchars($userName) . '</div>';
            echo '<div class="item"><a href="../bakiye.php"><i class="fas fa-coins"></i> Bakiye İşlemleri (' . htmlspecialchars($balance) . ' ₺)</a></div>';
            echo '<div class="item"><a href="../profil.php"><i class="fas fa-user-circle"></i> Profilim</a></div>';
            echo '<div class="item"><a href="../kontrol-merkezi.php"><i class="fas fa-user-tie"></i> Kontrol Merkezi</a></div>';
            echo '<div class="item"><a href="../tum-siparislerim.php"><i class="fas fa-shopping-cart"></i> Siparişler</a></div>';
            echo '<div class="item"><a href="../siparislerim.php"><i class="fas fa-shopping-basket"></i> Siparişlerim</a></div>';
            echo '<div class="item"><a href="../ilanlarim.php"><i class="fas fa-store"></i> İlanlarım</a></div>';
            echo '<div class="item"><a href="../favori-ilanlarim.php"><i class="fas fa-heart"></i> Favori İlanlarım</a></div>';
            echo '<div class="item"><a href="../destek-sistemi.php"><i class="far fa-life-ring"></i> Destek Sistemi</a></div>';
            echo '<div class="item"><a href="https://discord.gg/UtjXNfpdG9" target="_blank"><i class="fab fa-discord"></i> Discord</a></div>';
            echo '<div class="item"><a href="../cikis.php" class="cikisYapBtn"><i class="fas fa-sign-out-alt"></i> Çıkış</a></div>';
            echo '</div>';
            echo '</div>';
            } else {
                // Kullanıcı giriş yapmamışsa Giriş Yap ve Kaydol linklerini göster
                echo '<a href="../login.php">Giriş Yap</a>';
                echo '<a href="../register.php">Kaydol</a>';
            }
        ?>
        <div class="search-container">
            <form action="arama.php" method="GET">
                <input type="search" id="search-input" name="q" placeholder="Oyun Ara..." value=""
                    data-gtm-form-interact-field-id="0">
                <button class="search-btn" type="submit">Ara</button>
            </form>
            <div id="search-results" class="search-results"></div>
        </div>
        <script>
        const gameAbbreviations = {
            "pubg mobile": ["pubg", "pm"],
            "valorant": ["val"],
            "league of legends": ["lol"],
            "cs2-counter-strike-2": ["cs", "csgo", "cs2"],
            "black-desert-online": ["bdo"],
            "knight-online": ["ko"],
            "google-play-hediye-kartlari": ["google play", "gp"],
            "twitter-x": ["x", "twitter"]
            // Diğer oyun kısaltmaları buraya eklenecek
        };

        function searchGames(searchTerm, searchResults) {
            const gameCards = document.querySelectorAll(".game-card");
            searchResults.innerHTML = "";

            gameCards.forEach(card => {
                const gameName = card.querySelector("h3").textContent.toLowerCase();
                const gameLink = card.parentElement.href;
                const gameImage = card.querySelector("img").src;

                const abbreviations = gameAbbreviations[gameName] || [];
                const matchesAbbreviation = abbreviations.includes(searchTerm);

                if (gameName.includes(searchTerm) || matchesAbbreviation) {
                    const result = document.createElement("a");
                    result.href = gameLink;
                    result.classList.add("search-result-item");
                    result.innerHTML = `
                        <img src="${gameImage}" alt="${gameName}">
                        <div>
                            <span>${gameName}</span>
                        </div>
                    `;
                    searchResults.appendChild(result);
                }
            });

            // Arama sonuçları varsa göster, yoksa gizle
            searchResults.style.display = searchResults.children.length > 0 ? "block" : "none";
        }

        const searchInput = document.getElementById("search-input");
        const searchResults = document.getElementById("search-results");

        searchInput.addEventListener("input", function() {
            searchGames(searchInput.value.toLowerCase(), searchResults);
        });
    </script>
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
