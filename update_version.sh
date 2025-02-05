#!/bin/bash

# Get the current date
DATE=$(date "+%Y-%m-%d")

# Increment version (modify this part based on how your versioning works)
VERSION_FILE="VERSION.txt"  # Change to the file where your version is stored
if [ -f "$VERSION_FILE" ]; then
    CURRENT_VERSION=$(cat $VERSION_FILE)
    NEXT_VERSION=$(echo "$CURRENT_VERSION + 0.1" | bc)
else
    NEXT_VERSION="1.0" # Default version if no file exists
fi

# Update version file
echo "$NEXT_VERSION" > $VERSION_FILE
echo "🔄 Updated project version to v$NEXT_VERSION ($DATE)"

# Commit and push changes
git add .
git commit -m "🚀 Updated project version to v$NEXT_VERSION ($DATE)"
git push origin main
