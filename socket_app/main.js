const PORT = process.env.PORT || 3000;
const HOST = process.env.HOST || "localhost";


const express = require('express');
const cors = require('cors')
const bodyParser = require('body-parser')
const app = express();
const http = require('http');
const server = http.createServer(app);
const { Server } = require("socket.io");
const io = new Server(server,{ 
  cors: {
    origin: "*",
    methods: ["GET", "POST"]
  }
});

// parse application/x-www-form-urlencoded
app.use(bodyParser.urlencoded({ extended: false }))

// parse application/json
app.use(bodyParser.json())

app.use(cors({origin: "*"}))

var projectList = {};
var socketList = {};

const joinProject = (pid, sid) => {
  if(!projectList.hasOwnProperty(pid)) {
    projectList[pid] = [sid];
  } else {
    projectList[pid].push(sid);
  }

  if(!socketList.hasOwnProperty(sid)) {
    socketList[sid] = [pid];
  } else {
    socketList[sid].push(pid);
  }
}

const removeSocket = sid => {
  if(socketList.hasOwnProperty(sid)) {
    let plist = socketList[sid];
    plist.forEach(pid => {
      let i = projectList[pid].indexOf(sid);
      if (i != -1) projectList[pid].splice(i, 1);
    });
    delete socketList[sid];
  }
}

app.get('/', (req, res) => {
  res.sendFile(__dirname + '/index.html');
});

app.post('/notify/:projectId', (req, res) => {
  const {projectId} = req.params;
  if(projectList.hasOwnProperty(projectId)) {
    let sList = projectList[projectId];
    sList.forEach(socket => {
      io.to(socket).emit("priority_video", {projectId, ...req.body});
    });
    res.end("Ok");
  }
  else {
    res.end("No listeners for this project !");
  }
});


app.get('/details', (req, res) => {
  console.log(socketList, projectList);
  res.end(JSON.stringify({socketList, projectList}));
});



io.on('connection', (socket) => {
  console.log('a user connected', socket.id);

  socket.on('join_project', projectId => {
    console.log(`${socket.id} is joining ${projectId}`)
    joinProject(projectId, socket.id);
  });

  socket.on('disconnect', () => {
    console.log('Got disconnecting! '  + socket.id);
    removeSocket(socket.id)
  });
});

server.listen(PORT, () => {
  console.log(`listening on ${HOST}:${PORT}`);
});
