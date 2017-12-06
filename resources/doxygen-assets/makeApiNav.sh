#!/bin/bash

DOC_DIR="./doc"

HEADER="<select class='version-selector'>"
FOOTER="</select>"
CONTENT=""

for DIR in `ls -d $DOC_DIR/*/`; do
    # echo "$DIR"
    DIR_NAME=$(echo $DIR| cut -d'/' -f 3)
    # echo "$DIR_NAME"
    CONTENT="$CONTENT  <option value='$DIR_NAME'>$DIR_NAME</option>\n"
done

printf "$HEADER\n$CONTENT$FOOTER\n" >> ./versionSelector.html
cat ./versionSelector.html
