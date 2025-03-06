<?php
/**
 * Plugin Name: WP Play.Ht Reader
 * Description: A plugin to read WordPress articles aloud using Play.Ht API.
 * Version: 1.0
 * Author: Your Name
 */

function playht_admin_menu() {
    add_menu_page(
        'Play.Ht API Test',
        'Play.Ht API Test',
        'manage_options',
        'playht-api-test',
        'playht_api_test_page'
    );
}
add_action('admin_menu', 'playht_admin_menu');

function playht_api_test_page() {
    ?>
    <div class="wrap">
        <h1>Play.Ht API Test</h1>
        <form id="playht-test-form">
            <textarea id="playht-text" rows="5" cols="50" placeholder="Geben Sie den Text ein, der vorgelesen werden soll..."></textarea><br>
            <button type="button" id="playht-test-button">API Testen</button>
        </form>
        <div id="playht-test-result"></div>
    </div>
    <script>
        document.getElementById('playht-test-button').addEventListener('click', function() {
            const text = document.getElementById('playht-text').value;
            fetchAudio(text);
        });

        function fetchAudio(text) {
            const options = {
                method: 'POST',
                headers: {
                    AUTHORIZATION: 'ntCobGCIKZXyHZLirIbZpOC3cW43',
                    'X-USER-ID': '12ab42082eca43aab60df1471b4f3ece',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    model: 'PlayDialog',
                    text: text,
                    voice: 's3://voice-cloning-zero-shot/baf1ef41-36b6-428c-9bdf-50ba54682bd8/original/manifest.json',
                    outputFormat: 'mp3',
                    speed: 1,
                    sampleRate: 44100,
                    language: 'english',
                }),
            };

            fetch('https://api.play.ai/api/v1/tts', options)
                .then(response => response.json())
                .then(response => {
                    const audioUrl = response.audioUrl; // Assuming the response contains the audio URL
                    document.getElementById('playht-test-result').innerHTML = `<audio controls src="${audioUrl}"></audio>`;
                })
                .catch(err => {
                    document.getElementById('playht-test-result').innerHTML = 'Fehler beim Abrufen der Audio-Datei.';
                    console.error(err);
                });
        }
    </script>
function playht_enqueue_scripts() {
    wp_enqueue_script('playht-js', plugin_dir_url(__FILE__) . 'assets/js/playht.js', array('jquery'), null, true);
    wp_enqueue_style('playht-css', plugin_dir_url(__FILE__) . 'assets/css/playht.css');
}
add_action('wp_enqueue_scripts', 'playht_enqueue_scripts');

// Add player to the beginning of the article
function playht_add_player($content) {
    if (is_single()) {
        $player_html = '<div id="playht-player"></div>';
        $content = $player_html . $content;
    }
    return $content;
}
add_filter('the_content', 'playht_add_player');
