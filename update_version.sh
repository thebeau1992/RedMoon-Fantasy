#!/bin/bash

DATE=$(date "+%Y-%m-%d")

VERSION_FILE="VERSION.txt"  
if [ -f "$VERSION_FILE" ]; then
    CURRENT_VERSION=$(cat $VERSION_FILE)
    NEXT_VERSION=$(echo "$CURRENT_VERSION + 0.1" | bc)
else
    NEXT_VERSION="1.0"
fi

echo "$NEXT_VERSION" > $VERSION_FILE
echo "🔄 Updated project version to v$NEXT_VERSION ($DATE)"

git add .
git commit -m "🚀 Updated project version to v$NEXT_VERSION ($DATE)"
git push origin main
