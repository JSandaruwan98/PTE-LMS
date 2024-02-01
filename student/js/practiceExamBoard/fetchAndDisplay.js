class FetchAndDisplayManager{
    constructor(ajaxManager){
        this.ajaxManager = ajaxManager
    }

    discussion(question_id){
        console.log(question_id)
        this.ajaxManager.fetchData('data_type=fetchAndDisplay&question_id='+question_id, function (data) {
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
                

                e.preventDefault();
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
                event.preventDefault();
                if(!$(event.target).closest('#score').length && !$(event.target).closest('#cb').length) {
                    $('.b1').css('display','none')
                    $('#overlay-content-popup').hide();
                    $('#cb').hide();
                }
            });
        }, function (error) {
            $('#tab3').empty();
            console.error('Error fetching data:', error);
        });
     
    }


}