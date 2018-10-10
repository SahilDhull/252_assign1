#!/bin/bash

rm index.html
touch index.html

s=$(cat begin.txt)
e=$(cat end.txt)

echo $s>>index.html

counter=1

if [ $1 -gt 0 ]
then
    echo '<font size="6"><b>DOGS</b> <br></font>' >>index.html
    echo '<table style="width:100%">'>>index.html
    echo '<tr>'>>index.html
    i=1
    while [ $i -le $1 ]
    do
        echo '<td>'>>index.html
        echo '<img src="'"$counter"'.jpg" width="400" height="300"/>' >>index.html
        echo '</td>'>>index.html
        ((counter++))
        ((i++))
    done
    echo '</tr>'>>index.html
    echo '</table>'>>index.html
fi

if [ $2 -gt 0 ]
then
    echo '<font size="6"><b>CATS</b> <br></font>' >>index.html
    echo '<table style="width:100%">'>>index.html
    echo '<tr>'>>index.html
    i=1
    while [ $i -le $2 ]
    do
        echo '<td>'>>index.html
        echo '<img src="'"$counter"'.jpg" width="400" height="300"/>' >>index.html
        echo '</td>'>>index.html
        ((counter++))
        ((i++))
    done
    echo '</tr>'>>index.html
    echo '</table>'>>index.html
fi

if [ $3 -gt 0 ]
then
    echo '<font size="6"><b>CARS</b> <br></font>' >>index.html
    echo '<table style="width:100%">'>>index.html
    echo '<tr>'>>index.html
    i=1
    while [ $i -le $3 ]
    do
        echo '<td>'>>index.html
        echo '<img src="'"$counter"'.jpg" width="400" height="300"/>' >>index.html
        echo '</td>'>>index.html
        ((counter++))
        ((i++))

    done
    echo '</tr>'>>index.html
    echo '</table>'>>index.html
fi

if [ $4 -gt 0 ]
then
    echo '<font size="6"><b>TRUCKS</b> <br></font>' >>index.html
    echo '<table style="width:100%">'>>index.html
    echo '<tr>'>>index.html
    i=1
    while [ $i -le $4 ]
    do
        echo '<td>'>>index.html
        echo '<img src="'"$counter"'.jpg" width="400" height="300"/>' >>index.html
        echo '</td>'>>index.html
        ((counter++))
        ((i++))
    done
    echo '</tr>'>>index.html
    echo '</table>'>>index.html
fi

echo $e>>index.html

firefox index.html
