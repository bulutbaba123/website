<?php
session_start();
include("./baglanti.php");
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Profil - Ganimet Mağazası</title>
    <link rel="icon" href="Png/Logo.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #1a1a2e;
            --secondary-color: #16213e;
            --accent-color: #0f3460;
            --gold-color: #ffd700;
            --platinum-color: #e5e4e2;
            --text-light: #f1f1f1;
            --text-dark: #333;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            --transition: all 0.3s ease;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--primary-color);
            color: var(--text-light);
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* Premium Header */
        .lux-header {
            background: linear-gradient(135deg, var(--accent-color) 0%, var(--primary-color) 100%);
            padding: 15px 0;
            box-shadow: var(--shadow);
            position: relative;
            z-index: 1000;
        }

        .lux-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--gold-color), var(--platinum-color), var(--gold-color));
        }

        /* Wallpaper Container */
        .lux-wallpaper {
            height: 400px;
            width: 100%;
            position: relative;
            overflow: hidden;
            background: linear-gradient(45deg, #0a0a1a, #1a1a2e);
        }

        .lux-wallpaper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            transition: var(--transition);
        }

        .lux-wallpaper:hover img {
            transform: scale(1.02);
        }

        .wallpaper-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(0,0,0,0.2) 0%, rgba(0,0,0,0.7) 100%);
        }

        /* Profile Card */
        .lux-profile-card {
            max-width: 1200px;
            margin: -100px auto 0;
            position: relative;
            z-index: 2;
            background: rgba(26, 26, 46, 0.9);
            border-radius: 15px;
            box-shadow: var(--shadow);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            overflow: hidden;
        }

        .profile-header {
            display: flex;
            padding: 30px;
            position: relative;
        }

        .profile-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 5px solid var(--gold-color);
            object-fit: cover;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            transition: var(--transition);
            margin-right: 30px;
        }

        .profile-avatar:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
        }

        .profile-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .profile-name {
            font-size: 2.5rem;
            margin: 0;
            color: var(--text-light);
            font-weight: 700;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }

        .profile-status {
            display: inline-block;
            padding: 5px 15px;
            background: rgba(0, 255, 0, 0.2);
            border-radius: 20px;
            font-size: 0.9rem;
            margin: 10px 0;
            color: #0f0;
            border: 1px solid rgba(0, 255, 0, 0.3);
        }

        .profile-meta {
            display: flex;
            gap: 20px;
            margin-top: 10px;
        }

        .meta-item {
            display: flex;
            align-items: center;
            font-size: 0.9rem;
        }

        .meta-item i {
            margin-right: 8px;
            color: var(--gold-color);
        }

        .profile-actions {
            position: absolute;
            right: 30px;
            top: 30px;
            display: flex;
            gap: 15px;
        }

        .action-btn {
            padding: 10px 20px;
            border-radius: 30px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .primary-btn {
            background: var(--gold-color);
            color: var(--text-dark);
        }

        .primary-btn:hover {
            background: #ffc600;
            transform: translateY(-2px);
        }

        .secondary-btn {
            background: transparent;
            color: var(--text-light);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .secondary-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--gold-color);
        }

        /* Profile Navigation */
        .profile-nav {
            background: rgba(15, 52, 96, 0.7);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .nav-list {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .nav-item {
            position: relative;
        }

        .nav-link {
            display: block;
            padding: 20px 25px;
            color: var(--text-light);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
        }

        .nav-link:hover {
            color: var(--gold-color);
        }

        .nav-link.active {
            color: var(--gold-color);
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: var(--gold-color);
        }

        .badge {
            margin-left: 8px;
            background: var(--gold-color);
            color: var(--text-dark);
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 0.7rem;
            font-weight: 700;
        }

        /* Profile Content */
        .profile-content {
            padding: 30px;
        }

        .section-title {
            font-size: 1.8rem;
            margin-bottom: 25px;
            color: var(--gold-color);
            position: relative;
            padding-bottom: 10px;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 2px;
            background: var(--gold-color);
        }

        /* Photo Selection */
        .photo-selection {
            margin: 30px 0;
        }

        .photo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .photo-option {
            position: relative;
            border-radius: 10px;
            overflow: hidden;
            cursor: pointer;
            transition: var(--transition);
            aspect-ratio: 1/1;
        }

        .photo-option img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .photo-option:hover img {
            transform: scale(1.1);
        }

        .photo-option.selected {
            border: 3px solid var(--gold-color);
            box-shadow: 0 5px 15px rgba(255, 215, 0, 0.3);
        }

        .photo-option input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* Upload Section */
        .upload-section {
            background: rgba(15, 52, 96, 0.3);
            padding: 30px;
            border-radius: 10px;
            margin: 30px 0;
            border: 1px dashed rgba(255, 255, 255, 0.2);
            text-align: center;
        }

        .upload-btn {
            display: inline-block;
            padding: 15px 30px;
            background: var(--accent-color);
            color: var(--text-light);
            border-radius: 30px;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 15px;
            border: none;
            font-weight: 600;
        }

        .upload-btn:hover {
            background: var(--gold-color);
            color: var(--text-dark);
            transform: translateY(-3px);
        }

        .file-input {
            display: none;
        }

        /* Stats Section */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .stat-card {
            background: rgba(15, 52, 96, 0.3);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            transition: var(--transition);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow);
            border-color: var(--gold-color);
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--gold-color);
            margin: 10px 0;
        }

        .stat-label {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .profile-header {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }
            
            .profile-avatar {
                margin-right: 0;
                margin-bottom: 20px;
            }
            
            .profile-actions {
                position: static;
                justify-content: center;
                margin-top: 20px;
            }
            
            .profile-meta {
                justify-content: center;
            }
            
            .nav-list {
                overflow-x: auto;
                white-space: nowrap;
            }
        }

        @media (max-width: 768px) {
            .lux-wallpaper {
                height: 300px;
            }
            
            .profile-avatar {
                width: 120px;
                height: 120px;
            }
            
            .profile-name {
                font-size: 2rem;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <header class="lux-header">
        <div class="container">
            <!-- Header content from your original file -->
            <?php include('header_content.php'); ?>
        </div>
    </header>

    <div class="lux-wallpaper">
        <?php if (!empty($wallpapers)): ?>
            <img src="<?php echo htmlspecialchars($wallpapers[0]['image_url']); ?>" alt="Premium Duvar Kağıdı">
        <?php else: ?>
            <img src="ArkaPlan/premium-wallpaper.jpg" alt="Premium Duvar Kağıdı">
        <?php endif; ?>
        <div class="wallpaper-overlay"></div>
    </div>

    <div class="lux-profile-card">
        <div class="profile-header">
            <img src="<?php echo isset($_SESSION['profile_picture']) ? htmlspecialchars($_SESSION['profile_picture']) : 'Png/user.png'; ?>" 
                 alt="Profil Fotoğrafı" class="profile-avatar">
            
            <div class="profile-info">
                <h1 class="profile-name"><?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'Misafir'; ?></h1>
                <span class="profile-status">Çevrimiçi</span>
                
                <div class="profile-meta">
                    <div class="meta-item">
                        <i class="fas fa-medal"></i>
                        <span>Premium Üye</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Üyelik: <?php echo date('d M Y', strtotime('2025-02-24')); ?></span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-coins"></i>
                        <span>Bakiye: <?php echo isset($balance) ? htmlspecialchars($balance) : '0.00'; ?> ₺</span>
                    </div>
                </div>
            </div>
            
            <div class="profile-actions">
                <button class="action-btn primary-btn">
                    <i class="fas fa-crown"></i> Premium Yükselt
                </button>
                <button class="action-btn secondary-btn">
                    <i class="fas fa-cog"></i> Ayarlar
                </button>
            </div>
        </div>
        
        <nav class="profile-nav">
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="#" class="nav-link active"><i class="fas fa-user-circle"></i> Profil</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link"><i class="fas fa-shopping-bag"></i> Siparişler <span class="badge">5</span></a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link"><i class="fas fa-heart"></i> Favoriler <span class="badge">12</span></a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link"><i class="fas fa-trophy"></i> Başarımlar</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link"><i class="fas fa-users"></i> Arkadaşlar <span class="badge">23</span></a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link"><i class="fas fa-chart-line"></i> İstatistikler</a>
                </li>
            </ul>
        </nav>
        
        <div class="profile-content">
            <h2 class="section-title">Profil Fotoğrafınızı Özelleştirin</h2>
            <p>Premium seçeneklerimizden birini seçin veya kendi fotoğrafınızı yükleyin.</p>
            
            <div class="photo-selection">
                <h3>Premium Profil Fotoğrafları</h3>
                <div class="photo-grid">
                    <?php
                    $premiumPhotos = [
                        "FotografProfil/premium-1.png",
                        "FotografProfil/premium-2.png",
                        "FotografProfil/premium-3.png",
                        "FotografProfil/premium-4.png",
                        "FotografProfil/premium-5.png",
                        "FotografProfil/premium-6.png",
                        "FotografProfil/premium-7.png",
                        "FotografProfil/premium-8.png",
                        "FotografProfil/premium-9.png",
                        "FotografProfil/premium-10.png",
                        "FotografProfil/premium-11.png",
                        "FotografProfil/premium-12.png",
                    ];
                    
                    foreach ($premiumPhotos as $index => $photo) {
                        echo '<label class="photo-option ' . ($index === 0 ? 'selected' : '') . '">';
                        echo '<input type="radio" name="profile_picture" value="' . htmlspecialchars($photo) . '" ' . ($index === 0 ? 'checked' : '') . '>';
                        echo '<img src="' . htmlspecialchars($photo) . '" alt="Premium Profil ' . ($index + 1) . '">';
                        echo '</label>';
                    }
                    ?>
                </div>
            </div>
            
            <div class="upload-section">
                <h3>Veya Kendi Fotoğrafınızı Yükleyin</h3>
                <p>PNG, JPG veya GIF formatında (maks. 5MB)</p>
                
                <form action="profil_guncelle.php" method="post" enctype="multipart/form-data">
                    <label for="file-upload" class="upload-btn">
                        <i class="fas fa-cloud-upload-alt"></i> Dosya Seç
                    </label>
                    <input id="file-upload" type="file" name="new_profile_picture" class="file-input">
                    <button type="submit" class="action-btn primary-btn" style="margin-top: 20px;">
                        <i class="fas fa-save"></i> Profili Güncelle
                    </button>
                </form>
            </div>
            
            <h2 class="section-title">Profil İstatistikleri</h2>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-value">24</div>
                    <div class="stat-label">Tamamlanan Sipariş</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">4.9</div>
                    <div class="stat-label">Ortalama Puan</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">12</div>
                    <div class="stat-label">Favori Oyun</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">3</div>
                    <div class="stat-label">Yıldız Seviye</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Photo selection functionality
        document.querySelectorAll('.photo-option').forEach(option => {
            option.addEventListener('click', function() {
                document.querySelectorAll('.photo-option').forEach(opt => {
                    opt.classList.remove('selected');
                });
                this.classList.add('selected');
                this.querySelector('input[type="radio"]').checked = true;
            });
        });
        
        // File upload display
        document.getElementById('file-upload').addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                const fileName = this.files[0].name;
                document.querySelector('.upload-btn').innerHTML = 
                    `<i class="fas fa-check"></i> ${fileName}`;
            }
        });
    </script>
</body>
</html>