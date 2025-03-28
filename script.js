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

document.addEventListener('DOMContentLoaded', function() {
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
});
