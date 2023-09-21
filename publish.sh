#!/bin/bash

while IFS=":::::" read -r SOURCE TARGET; do
    # Remove leading and trailing spaces and dots
    SOURCE="${SOURCE#.}"
    TARGET="${TARGET#.}"

    if [ -e "$SOURCE" ]; then
        echo "Copying: $SOURCE to $TARGET"

        # Ensure the target directory exists
        mkdir -p "$(dirname "$TARGET")"

        # Copy files and directories
        cp -r "$SOURCE" "$TARGET"
    else
        echo "File not found - $SOURCE"
    fi
done < publish.txt

echo "Files and folders copied successfully."
