import myModule from './encapsulateModel01.js';

$(document).ready(function () {
    var fragment = window.location.hash;
    if (fragment.includes('type')) { var typeValue = parseInt(fragment.split('=')[1]); } 
    else { console.log('Type parameter not found in the URL.'); }

    console.log(typeValue)
    var type;
    var image;
    
    //banner image and type assign
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

    //display type name and banner image
    $('#type_name').text(type);
    $('#home').css({'background': 'url('+image+') right'})


})