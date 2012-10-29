#!/bin/bash

ITEM_DIR="/srv/http/www/alerts"

function create_item() {
    local title="$1"
    local text="$2"
    echo "$text" > "$ITEM_DIR/$title"
}

create_item "$@"
