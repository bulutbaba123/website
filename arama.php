<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Arama Sonuçları - Ganimet Mağazası</title>
    <link rel="icon" href="Png/Logo.png" type="image/png">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>
    <?php include("header.php"); ?>
    <main>
        <section class="content">
            <h1>Arama Sonuçları</h1>
            <?php
            include("./baglanti.php");

            if (isset($_GET['q'])) {
                $search = $_GET['q'];

                // Veritabanında arama yap
                $query = $conn->prepare("SELECT * FROM oyunlar WHERE ad LIKE ?");
                $query->execute(["%" . $search . "%"]);
                $results = $query->fetchAll(PDO::FETCH_ASSOC);

                if ($results) {
                    echo "<ul>";
                    foreach ($results as $result) {
                        echo "<li><a href='" . htmlspecialchars($result['link']) . "'>" . htmlspecialchars($result['ad']) . "</a></li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>Arama sonuç bulunamadı.</p>";
                }
            } else {
                echo "<p>Arama yapmak için bir terim girin.</p>";
            }
            ?>
        </section>
    </main>
    <?php include("footer.php"); ?>
</body>
</html>
