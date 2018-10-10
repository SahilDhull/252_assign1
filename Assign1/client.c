
/* credit @Daniel Scocco */

/****************** CLIENT CODE ****************/

#include <stdio.h>
#include <sys/socket.h>
#include <netinet/in.h>
#include <string.h>
#include <arpa/inet.h>
#include <stdlib.h>

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

void receive_image(int clientSocket,char name[]) {
    //Read Picture Size
    // printf("Reading Picture Size\n");
    int fsize;
    // result = recv(clientSocket, &fsize, sizeof(int),0);
    recv(clientSocket,&fsize,sizeof(int),0);
    // if(result<0) printf("wrong\n" );
    int size = ntohl(fsize);
    printf("size = %d\n",size );
    //Read Picture Byte Array
    // printf("Reading Picture Byte Array\n");
    char buffer[size];
    recv(clientSocket, buffer, size,0);
    // printf("okay\n" );

    //Convert it Back into Picture
    // printf("Converting Byte Array to Picture\n");
    FILE *image;
    // printf("okay");
    image = fopen(name, "w");
    int i=0;
    while(i<=size) fputc(buffer[i++],image);
    // fwrite(p_array, 1, sizeof(p_array), image);
    fclose(image);
}

int main(){
    int clientSocket;
    // char buffer[1024];
    int xsocket;
    int result;
    struct sockaddr_in serverAddr;
    socklen_t addr_size;

    /*---- Create the socket. The three arguments are: ----*/
    /* 1) Internet domain 2) Stream socket 3) Default protocol (TCP in this case) */
    clientSocket = socket(PF_INET, SOCK_STREAM, 0);

    /*---- Configure settings of the server address struct ----*/
    /* Address family = Internet */
    serverAddr.sin_family = AF_INET;
    /* Set port number, using htons function to use proper byte order */
    serverAddr.sin_port = htons(5432);
    /* Set IP address to localhost */
    serverAddr.sin_addr.s_addr = inet_addr("0.0.0.0");
    /* Set all bits of the padding field to 0 */
    memset(serverAddr.sin_zero, '\0', sizeof serverAddr.sin_zero);

    /*---- Connect the socket to the server using the address struct ----*/
    addr_size = sizeof serverAddr;
    connect(clientSocket, (struct sockaddr *) &serverAddr, addr_size);


    char query[100];
    printf("Enter Query: ");
    fgets(query,100,stdin);
    send(clientSocket,&query,100,0);
    // printf("okay\n" );
    parse(query);

    system("./remove.sh");

    int c1,c2,c3,c4;
    c1=count[0]-'0';
    c2=count[1]-'0';
    c3=count[2]-'0';
    c4=count[3]-'0';
    int cnt[4]={c1,c2,c3,c4};
    int n=c1+c2+c3+c4;
    char name[15];
    // printf("%d\n",n );
    for(int i = 0 ; i < n ; i++)
    {
      // make_name(i);
      printf("image number %d\n", i+1);
      sprintf(name,"%d.jpg",i+1 );
      receive_image(clientSocket,name);
    }
    char com[30];
	sprintf(com,"./script.sh %d %d %d %d",c1,c2,c3,c4);
	system(com);
    // setsockopt(sock,SOL_SOCKET,SO_REUSEADDR,&true,sizeof(int));
    return 0;
}
