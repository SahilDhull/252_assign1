# 252_assign1
Repository for Assignment 1 of the course CS252

The repository contains client.c, cl (executable) and other files.

client.c : client side code
server.c : server side code
remove.sh : removes already present images
script.sh : creates html file depending on number of images, appends begin.txt and end.txt to complete the html

Contributions:
Parsing function: Shubham
Server.c: Sahil
Client.c: Siddhant
script.sh, remove.sh, begin.txt, end.txt: Shubham and Lyazii Ng
Dockerization: Sahil and Shubham

For Running:

To pull docker image:
  docker pull sahil25dhull/server
To run the docker image, command:
  docker run -it -p 5432:5432 sahil25dhull/server
To run the server: (inside the container)
  cd home
  ./se                  

Now simultaneously run following command on another terminal (in the directory containing client.c and other files)
  ./cl                  #or client.c can be compiled as gcc client.c -o cl
