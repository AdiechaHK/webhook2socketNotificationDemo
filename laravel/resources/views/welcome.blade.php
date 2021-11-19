<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Demo</title>

        <script src="https://cdn.socket.io/4.3.2/socket.io.min.js" integrity="sha384-KAZ4DtjNhLChOB/hxXuKqhMLYvx3b5MlT55xPEiNmREKRzeEm+RVPlTnAn0ajQNs" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    </head>
    <body>
        <h1>Hello</h1>
        <p>Counter: <span id="counter">0</span></p>   

        <input type="text" id="project" placeholder="Project ID">
        {{-- <input type="text" id="device" placeholder="Device ID"> --}}
        <button id="connect">Connect</button>

        <div id="content"></div>

        <script>
            const initSocket = () => {
                const socket = io("http://localhost:3000");
                socket.on("connect", () => {
                    
                    console.log("Connected", socket.id); // x8WIv7-mJelg7on_ALbx

                });

                $("#connect").click(function() {
                    const projectId = $("#project").val();
                    alert("Project = " + projectId);
                    socket.emit('join_project', projectId);
                })

                socket.on('priority_video', data => {
                    console.log("Recieved Priority Video", data.url, new Date());
                });


                socket.on("disconnect", () => {
                    console.log("Disconnected", socket.id); // undefined
                });
            }

            initSocket();

</script>
    </body>
</html>
