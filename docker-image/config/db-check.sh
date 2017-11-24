#until nmap -P0 -sT –open -p3306 dbserver
#do
#  echo "Waiting for database connection..."
#  # wait for 5 seconds before check again
#  sleep 5
#done
while true; do
 NMAP=$(nmap -P0 -sT -p3306 dbserver)
 if [[ $NMAP == *"Host is up"* || $NMAP == *"closed"* ]]; then
    echo "connection!!!"
    break
 fi

 sleep 5
 echo "waiting for connection"
done