#include <stdio.h>
#include <stdlib.h>
int main()
{
    int c, i;
    char thing[500];
    FILE *file1;
    FILE *file2;
    file1 = fopen("champion.txt", "r");
    file2 = fopen("itemIDs.txt","w");
if (file1) {
    while ((c = getc(file1)) != EOF)
    {
        if(c>='0'&&c<='9')
            fputc(c,file2);
        else if(c == '\n')
            fputc(c,file2);
    }

    
    fclose(file1);
    fclose(file2);
}
getchar();
}

/*
#include <stdio.h>
#include <stdlib.h>
int main()
{
    int c, flag = 0;
    FILE *file1;
    FILE *file2;
file1 = fopen("champion.txt", "r");
    file2 = fopen("champions.txt","w");
if (file1) {
    while ((c = getc(file1)) != EOF)
    {
        if(c == '\n') flag++;
        if(flag%2!=0) fputc(c,file2);
        if(c!='\n')
        fputc(c,file2);
    }
    
    
    fclose(file1);
    fclose(file2);
}
}
*/
