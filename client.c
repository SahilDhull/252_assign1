#include<stdio.h>
#include<string.h>
#include<sys/socket.h>
#include<arpa/inet.h>
#include<sys/ioctl.h>
#include<unistd.h>
#include<stdlib.h>
// #include<fstream>
#include<errno.h>
//using namespace std;

//This function is to be used once we have confirmed that an image is to be sent
//It should read and output an image file

char count[5] = {'0','0','0','0','\0'};
char name[100];

void reverse(char *x, int begin, int end)
{
   char c;

   if (begin >= end)
      return;

   c          = *(x+begin);
   *(x+begin) = *(x+end);
   *(x+end)   = c;

   reverse(x, ++begin, --end);
}


void make_name(int i)
{
  int j = 0;
  while(i > 0)
  {
    name[j++] = (i%10) + 48;
    i/=10;
  }
  name[j] = '\0';
  reverse(name,0,j-1);
  char ext[6] = ".jpeg";
  //itoa(i,name,3);
  strcat(name,ext);

}


void parse(char s[])
{
    int i=0;
    int dogs=0,cats=1,cars=2,trucks=3;
    char d[]="dog";
    char ds[]="dogs";
    char c[]="car";
    char cs[]="cars";
    char ct[]="cat";
    char cts[]="cats";
    char t[]="truck";
    char ts[]="trucks";
    while(s[i]!='\0')
    {
        while(s[i]>'4' || s[i]<'1') i++;
        char n = s[i];
        i++;
        while(s[i]<'a' || s[i]>'z') i++;
        char temp[10];
        int j=0;
        while(s[i]>='a' && s[i]<='z')
        {
            temp[j]=s[i];
            i++;
            j++;
        }
        temp[j]='\0';
        if(!strcmp(d,temp) || !strcmp(ds,temp)) count[dogs] = n;
        else if (!strcmp(c,temp) || !strcmp(cs,temp)) count[cars] = n;
        else if (!strcmp(ct,temp) || !strcmp(cts,temp)) count[cats] = n;
        else if (!strcmp(t,temp) || !strcmp(ts,temp)) count[trucks] = n;
    }
}



int receive_image(int socket, char name[])
{ // Start function

    int buffersize = 0, recv_size = 0,size = 0, read_size, write_size, packet_index =1,stat;

    char imagearray[10241],verify = '1';
    FILE *image;

    //Find the size of the image
    do{
        stat = read(socket, &size, sizeof(int));
    }while(stat<0);

    printf("Packet received.\n");
    printf("Packet size: %i\n",stat);
    printf("Image size: %i\n",size);
    printf(" \n");

    char buffer[] = "Got it";

    //Send our verification signal
    do{
        stat = write(socket, &buffer, sizeof(int));
    }while(stat<0);

    printf("Reply sent\n");
    printf(" \n");

    image = fopen(name, "w");

    if( image == NULL) {
        printf("Error has occurred. Image file could not be opened\n");
        return -1;
    }

        //Loop while we have not received the entire file yet


    int need_exit = 0;
    struct timeval timeout = {10,0};

    fd_set fds;
    int buffer_fd, buffer_out;

    while(recv_size < size) {
        //while(packet_index < 2){

    FD_ZERO(&fds);
    FD_SET(socket,&fds);

    buffer_fd = select(FD_SETSIZE,&fds,NULL,NULL,&timeout);

    if (buffer_fd < 0)
    printf("error: bad file descriptor set.\n");

    if (buffer_fd == 0)
    printf("error: buffer read timeout expired.\n");

    if (buffer_fd > 0)
    {
        do{
            read_size = read(socket,imagearray, 10241);
        }while(read_size <0);

        printf("Packet number received: %i\n",packet_index);
        printf("Packet size: %i\n",read_size);


        //Write the currently read data into our image file
        write_size = fwrite(imagearray,1,read_size, image);
        printf("Written image size: %i\n",write_size);

        if(read_size !=write_size) {
            printf("error in read write\n");    }


            //Increment the total number of bytes read
            recv_size += read_size;
            packet_index++;
            printf("Total received image size: %i\n",recv_size);
            printf(" \n");
            printf(" \n");
        }

    }


    fclose(image);
    printf("Image %s successfully Received!\n",name);
    return 1;
}

int main(int argc , char *argv[])
{

    int socket_desc;
    struct sockaddr_in server;
    char *parray;

    char query[100];

    //Create socket
    socket_desc = socket(AF_INET , SOCK_STREAM , 0);

    if (socket_desc == -1) {
        printf("Could not create socket");
    }

    memset(&server,0,sizeof(server));
    server.sin_addr.s_addr = inet_addr("127.0.0.1");
    server.sin_family = AF_INET;
    server.sin_port = htons( 5000 );

    //Connect to remote server
    if (connect(socket_desc , (struct sockaddr *)&server , sizeof(server)) < 0) {
        // cout<<strerror(errno);
        close(socket_desc);
        puts("Connect Error");
        return 1;
    }

    puts("Connected\n");

    printf("Enter Query: ");
    scanf("%s", query);
    parse(query);

    int n;

    for(int i = 0 ; i < 4 ; i++)
    {
      n+=(count[i] - '0');
    }



    for(int i = 0 ; i < n ; i++)
    {
      make_name(i);
      receive_image(socket_desc,name);
    }

    close(socket_desc);

    return 0;
}
