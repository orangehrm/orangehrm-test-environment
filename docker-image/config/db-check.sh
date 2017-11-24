until nmap -P0 -sT -p3306 dbserver
do
  echo "Waiting for database connection..."
  # wait for 5 seconds before check again
  sleep 5
done