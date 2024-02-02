$(document).ready(function () {
    var fragment = window.location.hash;
    if (fragment.includes('type')) { var typeValue = parseInt(fragment.split('=')[1]); } 
    else { console.log('Type parameter not found in the URL.'); }

    console.log(typeValue);

    if(typeValue == 1){
        type = 'Read Aloud';
        image = 'images/img/78c8b120464e6b53b3877ad0de114ad3.jpg';
    }else if(typeValue == 2){
        type = 'Repeat Sentence';
        image = 'images/img/cta-bg.jpg';
    }else if(typeValue == 3){
        type = 'Describe image';
        image = 'images/img/top-banner.jpg';
    }else if(typeValue == 4){
        type = 'Re-tell Lecture';
        image = 'images/img/R.jpg';    
    }else if(typeValue == 5){
        type = 'Answer Short Question';
        image = 'images/img/slider3.png';        
    }

    console.log(type);

    $('#type_name').text(type);
    $('#home').css({'background': 'url('+image+') right'})


    const toggleRecordingButton = $('#recordButton');
    var progressBar = document.getElementById('myProgressBar');
    const audioPlayer = $('#audioPlayer');

/***********************************************************************************************************************************************************/
    
    var currentPage = 1;
    var questionsPerPage = 1;

    function fetchAndDisplayQuestions(page){
        
        $.ajax({
            url: `src/controllers/getController.php?data_type=questionDisplay&page=${page}&per_page=${questionsPerPage}&test_id=${11}&type=${type}`,
            method: 'GET',
            success: function (data) {
                resetTimer(2)
                isRecording = false;
                startTimer(2)
                $('#title').empty();
                $('#Question').empty();
                $('#solution').empty();
                totalPages = data['totalItems'].Count;
                for (var i = 0; i < data['data'].length; i++) {
                    Solution = data['data'][i].solution;
                    type = data['data'][i].type;
                    KeyWords = data['data'][i].key_words
                    question_id = data['data'][i].question_id;

                    $('#title').append(`<h2 style="color: white;">${data['data'][i].question}</h2>`);
                    if(type == "Read Aloud"){
                        $('#solution').append(`<p>${data['data'][i].solution}</p>`);
                    }else if(type == "Describe image"){
                        try{
                            $('#solution').append(`<img src="${data['data'][i].imageFile}" style="width:450px; padding-left: 25%; height: 250px">`);
                        }catch(error){
                            console.log(error.message)
                        }
                    }else if(type == "Repeat Sentence" || type == "Re-tell Lecture" || type == "Answer Short Question"){
                        $('#solution').append(`
                            <audio controls style="padding-left: 25%">
                                <source src="${data['data'][i].audio}" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>`);
                    }
                }
                function updatePagination() {
                    $("#currentPage").text(currentPage);
                    $("#totalPages").text(totalPages);
                    
                }
                updatePagination()
                discussion(question_id)
            },
                error: function () {
                    alert('Error fetching data.');
            }

        })
    }    

    fetchAndDisplayQuestions(currentPage)

    // Event listener for Previous button
    $("#previous").on("click", function() {
        if (currentPage > 1) {
            currentPage--;
            fetchAndDisplayQuestions(currentPage);
            resetTimer();
            resetTimer();
        }
    });

    // Event listener for Next button
    $("#next").on("click", function() {
        if (currentPage < totalPages) {
            currentPage++;
            fetchAndDisplayQuestions(currentPage);
            resetTimer();
            resetTimer();
        }
    });


/***********************************************************************************************************************************************************/

    let seconds1 = 0;
    let seconds2 = 35;
    let minutes = 0;
    let hours = 0;

    function startTimer(task) {
        timer = setInterval(function(){updateTimer(task)}, 1000);
    }

    function stopTimer() {
        clearInterval(timer);
        console.log('timer off')
    }

    function resetTimer(task) { 
        console.log('timer reset')              
        clearInterval(timer);
        if(task==1){
            seconds1 = 0;
            progressBar.style.width = 0+'%'
        }else if(task == 2){
            seconds2 = 35;
        }
        minutes = 0;
        hours = 0;
        updateTimerDisplay(task);
    }

    function updateTimer(task) {
        if(task==2){
            seconds2--;
            if (seconds2 === 30) {
                clearInterval(timer);
                toggleRecordingButton.click();                        
            }
        }else if(task==1){
            //this is progress increasing
            var currentWidth = parseFloat(progressBar.style.width, 10);
            var newWidth = (currentWidth + 2.5) % 101; 
            progressBar.style.width = newWidth + '%';

            seconds1++;
            if (seconds1 === 40) {
                clearInterval(timer);
                toggleRecordingButton.click();
            }
        }else if(task==3){
            seconds1++;
            if (seconds1 === 60) {
            seconds1 = 0;
            minutes++;
            if (minutes === 60) {
                minutes = 0;
                hours++;
            }
            }
        }
        updateTimerDisplay(task);
    }

    function updateTimerDisplay(task) { 
        if(task==1){
            const formattedTime = `${pad(hours)}:${pad(minutes)}:${pad(seconds1)}`;
            $("#timer").text(formattedTime);
        }else if(task==2){
            const formattedTime = `${pad(hours)}:${pad(minutes)}:${pad(seconds2)}`;
            $("#prepair-timer").text(formattedTime);
        }
    }

    function pad(value) {
        return value < 10 ? `0${value}` : value;
    }

/***********************************************************************************************************************************************************/

    $(document).ready(function() {
        // Show default tab content
        $('#tab1').show();

        // Tab click event
        $('.tab').click(function() {
            // Hide all tab content
            $('.tab-content').hide();

            // Show the selected tab content
            var tabId = $(this).data('tab');
            $('#' + tabId).show();
        });
    });


/***********************************************************************************************************************************************************/
   
    /**$(document).ready(function() {
        $('#score').on("click", function(){
            $('#overlay-content-popup').toggle();
            $('#cb').toggle();
        });

        $('#close-btn').on("click", function(){
            $('#overlay-content-popup').hide();
            $('#cb').hide();
        });

        $(document).on("click", function(event){
            if(!$(event.target).closest('#score').length && !$(event.target).closest('#cb').length) {
                $('#overlay-content-popup').hide();
                $('#cb').hide();
            }
        });
    });**/

/***********************************************************************************************************************************************************/



    function discussion(question_id){
        $.ajax({
            url: 'src/controllers/getController.php?data_type=fetchAndDisplay&question_id='+question_id,
            method: 'GET',
            success: function(data){
                console.log(data)
                $('#tab3').empty();
                for (var i = 0; i < data.length; i++) {
                    $('#tab3').append(`
                    <div class="row d-flex mb-4">
                        <div class="col-md-7 col-xl-5">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-start align-items-center">
                                        <img class="rounded-circle shadow-1-strong me-3"
                                        src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(19).webp" alt="avatar" width="60"
                                        height="60" />
                                    <div>
                                        <h6 class="fw-bold text-primary mb-1">`+data[i].name+`<span class="pe-3" style="font-size: 13px; font-weight: 300; color: black; float: right;">`+data[i].attempted_on+`</span></h6>
                                        <audio controls style="width: 330px; height: 40px;">
                                            <source src="`+data[i].mp4File+`" type="audio/mpeg">
                                            Your browser does not support the audio element.
                                        </audio><br>
                                        <div id="score" class="score_info btn btn-outline-primary fw-bold rounded"  style="font-size: 10px;" 
                                            data-content="`+data[i].content+`" 
                                            data-pronounciation="`+data[i].pronunciation+`" 
                                            data-oral_fluency="`+data[i].oral_fluency+`" 
                                            data-totalScore="`+data[i].totalScore+`"
                                            data-additional="`+data[i].additional_words+`"
                                            data-missed="`+data[i].missed_words+`"
                                            data-audio="`+data[i].mp4File+`"
                                            data-solution= "`+data[i].solution+`"
                                        >Score Info</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    `);
                }

/***********************************************************************************************************************************************************/                


                $('.score_info').click(function (e) {

                    var content = $(this).data('content');
                    var pronounciation = $(this).data('pronounciation');
                    var oral_fluency = $(this).data('oral_fluency');
                    var totalScore = $(this).data('totalScore');
                    var additional = $(this).data('additional');
                    var missed = $(this).data('missed');
                    var audio = $(this).data('audio');
                    var solution = $(this).data('solution')
                    var audioDiv = $('#user-answer-recording')


                    
                    $('.b1').css('display','block')
                    $('#overlay-content-popup').toggle();
                    $('#cb').toggle();

                    $('#content-marks').text(content)
                    $('#pronoun-marks').text(pronounciation)
                    $('#fluency-marks').text(oral_fluency)
                    var paragraph = $('#question-solution').text(solution)



                    $('#pronoun-progress').css('width', pronounciation + '%')
                    $('#pronoun-precentage').text(pronounciation + '%')

                    $('#fluent-progress').css('width', oral_fluency + '%')
                    $('#fluent-precentage').text(oral_fluency + '%')

                    audioDiv.attr('src', audio)
                    audioDiv.attr('type', 'audio/mpeg')

                    console.log(content+pronounciation+oral_fluency)

                    var word_set = missed.split(/[ ,.:]+/).filter(Boolean)

                    $.each(word_set, function(index, word) {
                        var regex = new RegExp('\\b' + word + '\\b', 'gi'); // Use word boundaries and case-insensitive matching
                        paragraph.html(paragraph.html().replace(regex, '<span class="highlight" style="color: #b80707;">' + word + '</span>'));
                    });


                });

                $('#close-btn').on("click", function(){
                    $('.b1').css('display','none')
                    $('#overlay-content-popup').hide();
                    $('#cb').hide();
                });
            
                $(document).on("click", function(event){
                    if(!$(event.target).closest('#score').length && !$(event.target).closest('#cb').length) {
                        $('.b1').css('display','none')
                        $('#overlay-content-popup').hide();
                        $('#cb').hide();
                    }
                });
            },
            error: function(){
                alert('Error fetching data.');
            }
        })
    }

/***********************************************************************************************************************************************************/    
    
    toggleRecordingButton.on('click', function () {
        if (!isRecording) {
            stopTimer(2)
            resetTimer()
            startTimer(1)
            startRecording();
            console.log("start")
            toggleRecordingButton.text('Stop Recording');
        } else {
            stopTimer(1)
            stopRecording();
            console.log("stop")
            toggleRecordingButton.text('Start Recording');
        }
        isRecording = !isRecording;
    });

/***********************************************************************************************************************************************************/    

    let audioChunks = [];

    function startRecording() {
        navigator.mediaDevices.getUserMedia({ audio: true })
            .then(function (stream) {
                mediaRecorder = new MediaRecorder(stream);

                mediaRecorder.ondataavailable = function (event) {
                    if (event.data.size > 0) {
                        audioChunks.push(event.data);
                    }
                };

                mediaRecorder.onstop = function () {
                    const audioBlob = new Blob(audioChunks, { type: 'audio/wav' });
                    const audioUrl = URL.createObjectURL(audioBlob);
                    audioPlayer.attr('src', audioUrl);
                    console.log(audioUrl)
                    const formData = new FormData();
                    formData.append('audio', audioBlob, 'recording.wav');
                    formData.append('task','save_audio');

                    // Send the recorded audio to the server using $.ajax or $.post
                    saveAudio(formData);

                    audioChunks = [];
                };

                mediaRecorder.start();
                toggleRecordingButton.prop('disabled', false);
            })
            .catch(function (error) {
                console.error('Error accessing microphone:', error);
            });
    }

/***********************************************************************************************************************************************************/    

    function stopRecording() {
        if (mediaRecorder && mediaRecorder.state === 'recording') {
            mediaRecorder.stop();
        }
    }

/***********************************************************************************************************************************************************/    

    function saveAudio(formData) {
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
                audioFile = response.audioFile1;
            },
            error: function (error) {
                console.error('Error saving audio:', error);
            }
        });
    }

/***********************************************************************************************************************************************************/    

    $('#submit').on('click', function(){
        console.log(type);
        console.log(KeyWords);
        if(type == 'Read Aloud' || type == 'Repeat Sentence'){
            task = 'normal_comparison'
        }else if(type == 'Describe image' || type == 'Repeat Sentence' || type == 'Answer Short Question'){
            task = 'ai_analysis'
        }

        $.ajax({
            url:'src/controllers/postController.php',
            type: 'POST',
            data: { task : task, audioFile: audioFile, Solution: Solution, question_id: question_id, student_id: 2, key_words: KeyWords, type: type},
            success: function(response){
                if(response.success){
                    console.log(response.message);
                    discussion()
                }else{
                    console.log(response.message);
                    
                }
            },
            error: function (error) {
                console.log(response.message);
                console.log(response.comment);
                console.error('Error saving audio:', error); 
            }
        })
    });

}) 