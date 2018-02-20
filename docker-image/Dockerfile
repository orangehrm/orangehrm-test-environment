FROM rabbitmq:3.6-management

MAINTAINER orangehrm
LABEL authors = "Ridwan Shariffdeen <ridwan@orangehrmlive.com>, Chamin Wickramarathne  <chamin@orangehrmlive.com>"

#Installing netstat
RUN apt-get update \
  && DEBIAN_FRONTEND=noninteractive apt-get install -y \
    net-tools \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/*

# SSL certificates
RUN mkdir cert_rabbitmq
COPY ./config/certificate-SSL/cert.pem /cert_rabbitmq/cert.pem
COPY ./config/certificate-SSL/cacert.pem /cert_rabbitmq/cacert.pem
COPY ./config/certificate-SSL/key.pem /cert_rabbitmq/key.pem
COPY ./config/certificate-SSL/cacert.srl /cert_rabbitmq/cacert.srl
COPY ./config/certificate-SSL/cakey.pem /cert_rabbitmq/cakey.pem
COPY ./config/certificate-SSL/cert.csr /cert_rabbitmq/cert.csr

#Environment Variables
ENV RABBITMQ_SSL_CERTFILE /cert_rabbitmq/cert.pem
ENV RABBITMQ_SSL_KEYFILE /cert_rabbitmq/key.pem
ENV RABBITMQ_SSL_CACERTFILE /cert_rabbitmq/cacert.pem
ENV RABBITMQ_SSL_FAIL_IF_NO_PEER_CERT 'false'
ENV RABBITMQ_SERVER_ADDITIONAL_ERL_ARGS '-rabbit ssl_listeners [{"::",5671}] -rabbit ssl_options [{certfile,"/cert_rabbitmq/cert.pem"},{keyfile,"/cert_rabbitmq/key.pem"},{cacertfile,"/cert_rabbitmq/cacert.pem"},{verify,verify_peer},{depth,3},{fail_if_no_peer_cert,false}] -rabbit tcp_listeners [{"::",5672}]'

