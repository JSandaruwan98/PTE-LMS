class Recording {
    constructor(audioPlayer) {
        this.mediaRecorder = null;
        this.audioChunks = [];
        this.audioPlayer = audioPlayer;
        this.audioFile = null;
    }

    startRecording() {
        navigator.mediaDevices.getUserMedia({ audio: true })
                .then(stream => {
                    this.mediaRecorder = new MediaRecorder(stream);

                this.mediaRecorder.ondataavailable = event => {
                    if (event.data.size > 0) {
                        this.audioChunks.push(event.data);
                    }
                };

                this.mediaRecorder.onstop = () => {
                    const audioBlob = new Blob(this.audioChunks, { type: 'audio/wav' });
                    const audioUrl = URL.createObjectURL(audioBlob);
                    console.log('Recording complete. Audio URL:', audioUrl);
                    this.audioPlayer.attr('src', audioUrl);
                    console.log(audioUrl)
                    const formData = new FormData();
                    formData.append('audio', audioBlob, 'recording.wav');
                    formData.append('task','save_audio');
                    this.saveAudio(formData);

                    // You can perform additional actions with the recorded audio here
                };

                /*this.mediaRecorder.onstop = function () {
                    const audioBlob = new Blob(this.audioChunks, { type: 'audio/wav' });
                    const audioUrl = URL.createObjectURL(audioBlob);
                    audioPlayer.attr('src', audioUrl);
                    console.log(audioUrl)
                    const formData = new FormData();
                    formData.append('audio', audioBlob, 'recording.wav');
                    formData.append('task','save_audio');

                    // Send the recorded audio to the server using $.ajax or $.post
                    saveAudio(formData);

                    
                };*/

                this.mediaRecorder.start();
                })
                .catch(error => {
                    console.error('Error accessing microphone:', error);
                });
    }

    stopRecording() {
        if (this.mediaRecorder && this.mediaRecorder.state === 'recording') {
            this.mediaRecorder.stop();
        }
    }

    saveAudio(formData) {
        // Send the recorded audio data to the server using $.ajax or $.post
        $.ajax({
            url: 'src/controllers/postController.php',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                console.log('Audio saved successfully:');
                console.log(response.audioFile1);
                console.log(response.audioFile2);
                console.log(response)
                this.audioFile = response.audioFile1;

            },
            error: function (error) {
                console.error('Error saving audio:', error);
            }
        });
    }

    getResult() {
        return this.audioFile;
    }


}
