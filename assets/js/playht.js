document.addEventListener('DOMContentLoaded', function() {
    const playerDiv = document.getElementById('playht-player');

    // Function to fetch audio from Play.Ht API
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
                const audioPlayer = `<audio controls src="${audioUrl}"></audio>`;
                playerDiv.innerHTML = audioPlayer;
            })
            .catch(err => console.error(err));
    }

    // Fetch audio for the article content
    const articleText = document.querySelector('article').innerText; // Get article text
    fetchAudio(articleText);
});
