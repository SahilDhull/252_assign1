# 252_assign1
Repository for Assignment 1 of the course CS252

The repository contains server.c,client.c and other files



To load docker image from .tar:
  docker load -i server.tar
To run the docker image, command:
  docker run -it -p 5432:5432 server
To run the server:
  cd home/server/
  ./se                  #or server.c can be compiled as gcc server.c -o se

Now simultaneously run following command on another terminal (in the directory containing client.c and other files)
  ./cl                  #or client.c can be compiled as gcc client.c -o cl
