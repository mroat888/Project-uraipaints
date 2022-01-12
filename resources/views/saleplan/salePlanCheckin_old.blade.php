 <!-- Modal -->
 <div class="modal fade" id="Modalcheckin" tabindex="-1" role="dialog" aria-labelledby="Modalcheckin" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Check-in 2 Check-out</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-xl-12 pa-0">
                        <div id="map_canvas" class="gmap"></div>
                    </div>
                    <!-- 
                    <div class="mt-20 text-center">
                        <button type="button" class="btn btn-primary">Check-in</button>
                    </div> -->
                    <div class="mt-20 text-center">
                        <!-- <button type="button" class="btn btn-primary" onclick="getLocation()">GetLocation</button> -->
                        <p>ตำแหน่งของคุณ</p>
                        <p id="demo" class="mt-5"></p>
                    </div>
                    <div class="mt-20 text-center">
                        <!-- <div id="basic" style="text-align:center;">
                            <video class="videostream" autoplay></video>
                            <img id="screenshot-img">
                            <p><button class="capture-button">Capture video</button>
                            <button id="stop-button">Stop</button></p>
                            <input type="text" id="capture_img" accept="image/*;capture=camera">
                        </div> -->

                        <div id="screenshot" style="text-align:center;">
                            <video class="videostream" autoplay></video>
                            <img id="screenshot-img">
                            <p><button class="capture-button">Capture video</button>
                            <p><button id="screenshot-button" disabled>Take screenshot</button></p>
                            <input type="file" id="capture_img" accept="image/*;capture=camera">
                            <canvas id="myCanvas">
                            </canvas>
                        </div>
                    </div>
  
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                    <button type="button" class="btn btn-primary">บันทึก</button>
                </div>
            </div>
        </div>
    </div>

<script>

var x = document.getElementById("demo");

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) {
    x.innerHTML = "Latitude: " + position.coords.latitude + "<br>Longitude: " + position.coords.longitude;
}

function showError(error){  
    switch(error.code){    
        case error.PERMISSION_DENIED:
            x.innerHTML="User denied the request for Geolocation."
            reak;     
        case error.POSITION_UNAVAILABLE:
            x.innerHTML="Location information is unavailable."
            break;     
        case error.TIMEOUT:
            x.innerHTML="The request to get user location timed out."
            break;     
        case error.UNKNOWN_ERROR:
            x.innerHTML="An unknown error occurred."       
            break;    
    }  
}

        function hasGetUserMedia() {
            return !!(navigator.mediaDevices && navigator.mediaDevices.getUserMedia);
        }
        if (hasGetUserMedia()) {
            // Good to go!
        } else {
            alert("getUserMedia() is not supported by your browser");
        }

        const hdConstraints = {
            video: { width: { min: 150 }, height: { min: 150 } },
        };

        function handleError(error) {
            console.error('navigator.getUserMedia error: ', error);
        }

         // (function() {
            //     const captureVideoButton = document.querySelector('#basic .capture-button');
            //     const screenshotButton = document.querySelector('#screenshot-button');
            //     const video = document.querySelector('#basic video');
            //     const img = document.querySelector('#basic img');
            //     const input_f = document.querySelector('#capture_img');

            //     let localMediaStream;

            //     function handleSuccess(stream) {
            //         //localMediaStream = stream;
            //         video.srcObject = stream;
            //     }

            //     captureVideoButton.onclick = function() {
            //         navigator.mediaDevices.getUserMedia(hdConstraints).
            //         then(handleSuccess).catch(handleError);
            //     };

            //     document.querySelector('#stop-button').onclick = video.onclick = function() {
            //         video.pause();
            //         //localMediaStream.stop();

            //         canvas.width = video.videoWidth;
            //         canvas.height = video.videoHeight;
            //         canvas.getContext('2d').drawImage(video, 0, 0);
            //         // Other browsers will fall back to image/png
            //         img.src = canvas.toDataURL('image/webp');
            //         input_f.value = canvas.toDataURL('image/webp');
            //     };
            // })();

        (function() {
            const captureVideoButton = document.querySelector('#screenshot .capture-button');
            const screenshotButton = document.querySelector('#screenshot-button');
            const img = document.querySelector('#screenshot img');
            const video = document.querySelector('#screenshot video');
            const input_f = document.querySelector('#capture_img');

            const canvas = document.createElement('canvas');

            captureVideoButton.onclick = function() {
                navigator.mediaDevices.getUserMedia(hdConstraints).
                then(handleSuccess).catch(handleError);
            };

            screenshotButton.onclick = video.onclick = function() {
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                canvas.getContext('2d').drawImage(video, 0, 0);
                // Other browsers will fall back to image/png
                img.src = canvas.toDataURL('image/webp');
                input_f.value = canvas.toDataURL('image/webp')
            };

            function handleSuccess(stream) {
                screenshotButton.disabled = false;
                video.srcObject = stream;
            }
            })();

    </script>