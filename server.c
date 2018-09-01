#include<stdio.h>
#include<string.h>
#include<sys/socket.h>
#include<arpa/inet.h>
#include<unistd.h>
// #include<iostream>
// #include<fstream>
#include<errno.h>

// using namespace std;

char count[5] = {'0','0','0','0','\0'};

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

int send_image(int socket){

    FILE *picture;
    int size, read_size, stat, packet_index;
    char send_buffer[10240], read_buffer[256];
    packet_index = 1;

    picture = fopen("mac.jpg", "r");
    printf("Getting Picture Size\n");

    if(picture == NULL) {
        printf("Error Opening Image File"); }

        fseek(picture, 0, SEEK_END);
        size = ftell(picture);
        fseek(picture, 0, SEEK_SET);
        printf("Total Picture size: %i\n",size);

        //Send Picture Size
        printf("Sending Picture Size\n");
        write(socket, (void *)&size, sizeof(int));

        //Send Picture as Byte Array
        printf("Sending Picture as Byte Array\n");

        do { //Read while we get errors that are due to signals.
            stat=read(socket, &read_buffer , 255);
            printf("Bytes read: %i\n",stat);
        } while (stat < 0);

        printf("Received data in socket\n");
        printf("Socket data: %s\n", read_buffer);

        while(!feof(picture)) {
            //while(packet_index = 1){
            //Read from the file into our send buffer
            read_size = fread(send_buffer, 1, sizeof(send_buffer)-1, picture);

            //Send data through our socket
            do{
                stat = write(socket, send_buffer, read_size);
            }while (stat < 0);

            printf("Packet Number: %i\n",packet_index);
            printf("Packet Size Sent: %i\n",read_size);
            printf(" \n");
            printf(" \n");


            packet_index++;

            //Zero out our send buffer
            bzero(send_buffer, sizeof(send_buffer));
        }
    }

    int main(int argc , char *argv[])
    {
        int socket_desc , new_socket , c, read_size,buffer = 0;
        struct sockaddr_in server , client;
        char *readin;

        //Create socket
        socket_desc = socket(AF_INET , SOCK_STREAM , 0);
        if (socket_desc == -1)
        {
            printf("Could not create socket");
        }

        //Prepare the sockaddr_in structure
        server.sin_family = AF_INET;
        server.sin_addr.s_addr = INADDR_ANY/*inet_addr("127.0.0.1")*/;
        server.sin_port = htons( 5000 );
        int opt = 1;
        /*if (setsockopt(<Master socket FD>, SOL_SOCKET, SO_REUSEADDR, (char *)&opt, sizeof(opt))<0)
        {
        perror("setsockopt");
        exit(EXIT_FAILURE);
    }
    if(setsockopt(<Master socket FD>, SOL_SOCKET, SO_REUSEPORT, (char *)&opt, sizeof(opt))<0){
    perror("setsockopt");
    exit(EXIT_FAILURE);
}*/
//Bind
if( bind(socket_desc,(struct sockaddr *)&server , sizeof(server)) < 0)
{
    puts("bind failed");
    return 1;
}

puts("bind done");

//Listen
listen(socket_desc , 3);

//Accept and incoming connection
puts("Waiting for incoming connections...");
c = sizeof(struct sockaddr_in);

if((new_socket = accept(socket_desc, (struct sockaddr *)&client,(socklen_t*)&c))){
    puts("Connection accepted");
}

fflush(stdout);

if (new_socket<0)
{
    perror("Accept Failed");
    return 1;
}

send_image(new_socket);

close(socket_desc);
fflush(stdout);
return 0;
}
