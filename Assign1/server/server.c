/* credit @Daniel Scocco */

/****************** SERVER CODE ****************/

#include <stdio.h>
#include <netinet/in.h>
#include <string.h>
#include <sys/socket.h>
#include <arpa/inet.h>

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

void send_image(int newSocket, char query[]){
    FILE *fp = fopen(query,"rb+");
    int lsize;
    //char *buffer;

    fseek(fp , 0 ,SEEK_END);
    lsize = ftell(fp);
    //printf("%ld",lsize);
    rewind(fp);
    //buffer = (char*)malloc(sizeof(char)*lsize);
    char buffer[lsize];
    fread(buffer,1,lsize,fp);
    // printf("okay\n" );
    printf("size = %d\n", lsize);
    int cn=htonl(lsize);

    send(newSocket,&cn,sizeof(int),0);
    // printf("okay\n" );
    send(newSocket,buffer,lsize,0);
    // printf("okay\n" );
}

int main(){
    int welcomeSocket, newSocket;

    struct sockaddr_in serverAddr;
    struct sockaddr_storage serverStorage;
    socklen_t addr_size;
    int result;

    /*---- Create the socket. The three arguments are: ----*/
    /* 1) Internet domain 2) Stream socket 3) Default protocol (TCP in this case) */
    welcomeSocket = socket(PF_INET, SOCK_STREAM, 0);

    /*---- Configure settings of the server address struct ----*/
    /* Address family = Internet */
    serverAddr.sin_family = AF_INET;
    /* Set port number, using htons function to use proper byte order */
    serverAddr.sin_port = htons(5432);
    /* Set IP address to localhost */
    serverAddr.sin_addr.s_addr = inet_addr("0.0.0.0");
    /* Set all bits of the padding field to 0 */
    memset(serverAddr.sin_zero, '\0', sizeof serverAddr.sin_zero);

    /*---- Bind the address struct to the socket ----*/
    bind(welcomeSocket, (struct sockaddr *) &serverAddr, sizeof(serverAddr));

    /*---- Listen on the socket, with 5 max connection requests queued ----*/
    if(listen(welcomeSocket,5)==0)
    printf("Send Query\n");
    else
    printf("Error\n");
	while(1){
    /*---- Accept call creates a new socket for the incoming connection ----*/
    addr_size = sizeof serverStorage;
    newSocket = accept(welcomeSocket, (struct sockaddr *) &serverStorage, &addr_size);
	count[0]='0';
	count[1]='0';
	count[2]='0';
	count[3]='0';
    char inp[100];
    recv(newSocket,&inp,100,0);
    printf("%s\n", inp);
    parse(inp);

    // printf("okay\n" );
    int c1,c2,c3,c4;
    c1=count[0]-'0';
    c2=count[1]-'0';
    c3=count[2]-'0';
    c4=count[3]-'0';
    int cnt[4]={c1,c2,c3,c4};
    char str[4][10]={"dogs","cats","cars","trucks"};
    int n=c1+c2+c3+c4;
    // printf("n = %d\n", n);
    int i,j;
    for(i=0;i<4;i++){
        // printf("cnt = %d\n", cnt[i]);
        if(cnt[i]!=0){
            for(j=0;j<cnt[i];j++){
                char query[15];
                // sprintf(query,"%s/%d.jpg",str[i],j+1);
                sprintf(query,"%s/%d.jpg",str[i],j+1);
                printf("query = %s\n", query);
                send_image(newSocket,query);
                // printf("okay till now --------------------\n" );
            }
        }
    }
}
	return 0;
}
