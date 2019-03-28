#!/usr/bin/env bash
ping -c 5 dbserver

while true; do
 NMAP=$(nmap -P0 -sT -p3306 dbserver)
 echo "$NMAP\n"

 time=$(date)
 if [[ $NMAP == *"Host is up"* && $NMAP == *"open"* ]]; then
    echo "connection!!!\n"
    echo $time
    break
 fi

 sleep 5
 echo "waiting for connection\n"
 echo "$time\n"
done