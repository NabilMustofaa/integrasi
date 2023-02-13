//get planId from url
let planId = window.location.pathname.split("/")[2];
let latitude,longitude ;

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, function(error) {
          console.log(error.code);
            if (error.code == 1)
                $("#error-placeholder").removeClass('hidden').append("Error: Access is denied!");
        });
    } else {
         $("#error-placeholder").removeClass('hidden').append("Sorry, browser does not support geolocation!");
    }
}

function showPosition(position) {
    latitude = position.coords.latitude;
    longitude = position.coords.longitude;
    $("#snapshot-button").attr("disabled", false).click(function(){
        takeSnapshot();
    });
}  

getLocation();

const video = document.querySelector('video');
const constraints = {
  audio: false,
  video: true
};

navigator.mediaDevices.getUserMedia(constraints)
  .then((stream) => {
    const videoTracks = stream.getVideoTracks();
    console.log('Got stream with constraints:', constraints);
    console.log(`Using video device: ${videoTracks[0].label}`);
    stream.onremovetrack = () => {
      console.log('Stream ended');
    };
    video.srcObject = stream;
  })
  .catch((error) => {
    if (error.name === 'ConstraintNotSatisfiedError') {
      console.error(
        `The resolution ${constraints.video.width.exact}x${constraints.video.height.exact} px is not supported by your device.`
      );
    } else if (error.name === 'PermissionDeniedError') {
      console.error(
        'Permissions have not been granted to use your camera and ' +
          'microphone, you need to allow the page access to your devices in ' +
          'order for the demo to work.'
      );
    } else {
      console.error(`getUserMedia error: ${error.name}`, error);
    }
  });

  const videoSelect = document.querySelector('select#camera-select');


  function displayMediaOptions() {
    if (!navigator.mediaDevices?.enumerateDevices) {
      console.log("enumerateDevices() not supported.");
    } else {
      // List cameras and microphones.
      navigator.mediaDevices.enumerateDevices()
        .then((devices) => {
          devices.forEach((device) => {
            if (device.kind === 'videoinput') {
              const option = document.createElement('option');
              option.value = device.deviceId;
              const label = device.label || `Camera ${videoSelect.length + 1}`;
              const textNode = document.createTextNode(label);
              option.appendChild(textNode);
              videoSelect.appendChild(option);

              videoSelect.onchange = () => {
                const videoSource = videoSelect.value;
                const constraints = {
                  video: { deviceId: videoSource ? { exact: videoSource } : undefined }
                };
                navigator.mediaDevices.getUserMedia(constraints)
                  .then((stream) => {
                    video.srcObject = stream;
                  })
                  .catch((error) => {
                    console.error(`Error: ${error}`);
                  });
              };
            }
          });
        })
        .catch((err) => {
          console.error(`${err.name}: ${err.message}`);
        });
    }
  }
  displayMediaOptions();

  const snapshot= document.querySelector('#snapshot');

  function takeSnapshot() {
    const video = document.querySelector('video');

    // buat elemen img
    var img = document.createElement('img');
    var context;

    // ambil ukuran video
    var width = video.videoWidth, height = video.videoHeight;

    // buat elemen canvas
    canvas = document.createElement('canvas');
    canvas.width = width;
    canvas.height = height;

    // ambil gambar dari video dan masukan 
    // ke dalam canvas
    context = canvas.getContext('2d');
    context.drawImage(video, 0, 0, width, height);

    let coordinates = latitude + ", " + longitude;
    let time = new Date().toLocaleString();
    //tambahkan lokasi ke canvas
    context.font = "30px Arial";
    context.fillStyle = "white";
    context.fillText(coordinates, 10, 50);
    context.fillText(time, 10, 100);

    // render hasil dari canvas ke elemen img


    //kirim gambar ke server
    $.ajax({
        url: '/api/plans/' + planId + '/snapshot',
        type: 'POST',
        data: {
            file: canvas.toDataURL('image/png')
        }
    }).done(function(data){
      img.src = canvas.toDataURL('image/png');
      snapshot.appendChild(img);

      $('#form').removeClass('hidden');
    });
}

let formTimeout;



console.log($('form[class="question-form"]').serialize());
  $('form[class="question-form"]').on('change', function(e){
    thisForm = $(this);
    clearTimeout(formTimeout);
    formTimeout = setTimeout(function(){
      const type = thisForm[0].elements[0].value;
      const id = thisForm.attr('id').split('_')[2];
      console.log(type, id);
      if (type == 'checkbox') {
        let answer = [];
        $('input[type="checkbox"]:checked').each(function(){
          answer.push($(this).val());
        });
        console.log(answer);
        $.ajax({
          url: thisForm.attr('action'),
          type: 'GET',
        }).done(function(data){
          console.log(data);
          if(data.length == 0){
            answer.forEach(function(item){
              $.ajax({
                url: thisForm.attr('action'),
                type: 'POST',
                data: {
                  question_option_id: item
                }
              }).done(function(data){
                console.log(data);
              }).fail(function(err){
                console.log(err);
              });
            });
          }
          else{
            let optionId = [];
            data.forEach(function(item){
              // make string first before push
              optionId.push(item.question_option_id.toString());
            });
            
            console.log(optionId, answer);
            const diff = optionId.filter(x => !answer.includes(x)); 
            
            diff.forEach(function(item){
              //get index of item from data
              const index = data.findIndex(x => x.question_option_id == item);

              $.ajax({
                url: thisForm.attr('action') + '/' + data[index].id,
                type: 'DELETE',
              }).done(function(data){
                console.log(data);
              }).fail(function(err){
                console.log(err);
              });
            });

            const diff2 = answer.filter(x => !optionId.includes(x));
            console.log(diff2);

            diff2.forEach(function(item){
              $.ajax({
                url: thisForm.attr('action'),
                type: 'POST',
                data: {
                  question_option_id: item
                }
              }).done(function(data){
                console.log(data);
              }).fail(function(err){
                console.log(err);
              });
            });
          }
        }).fail(function(err){
          console.log(err);
        });
      }
      else if(type == 'radio' || type == 'select'){
        $.ajax({
          url: thisForm.attr('action'),
          type: 'GET',
        }).done(function(data){
          console.log(data);
          if (data.length == 0) {
            $.ajax({
              url: thisForm.attr('action'),
              type: 'POST',
              data: {
                question_option_id: thisForm[0].elements[2].value
              }
            }).done(function(data){
              console.log(data);
            }).fail(function(err){
              console.log(err);
            });
          }
          else{
            $.ajax({
              url: thisForm.attr('action') + '/' + data[0].id,
              type: 'PUT',
              data: {
                question_option_id: thisForm[0].elements[2].value
              }
            }).done(function(data){
              console.log(data);
            }).fail(function(err){
              console.log(err);
            });
          }
        }).fail(function(err){
          console.log(err);
        });
      }
      else{
        $.ajax({
          url: thisForm.attr('action'),
          type: 'GET',
        }).done(function(data){
          console.log(data,thisForm[0].elements[2].value);
          if (data.length == 0) {
            $.ajax({
              url: thisForm.attr('action'),
              type: 'POST',
              data: {
                answer: thisForm[0].elements[2].value
              }
            }).done(function(data){
              console.log(data);
            }).fail(function(err){
              console.log(err);
            });
          }
          else{
            $.ajax({
              url: thisForm.attr('action') + '/' + data[0].id,
              type: 'PUT',
              data: {
                answer: thisForm[0].elements[2].value
              }
            }).done(function(data){
              console.log(data);
            }).fail(function(err){
              console.log(err);
            });
          }
        }).fail(function(err){
          console.log(err);
        });

      }
    }, 1000);
    
  });

