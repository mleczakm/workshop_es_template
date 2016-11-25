FROM ubuntu:trusty
MAINTAINER Grimstad <grimstad@espeo.pl>

# Install base packages
ENV DEBIAN_FRONTEND noninteractive
ENV ES_PKG_NAME elasticsearch-2.3.5
ENV CLUSTER_NAME elasticsearch

RUN apt-get update
RUN apt-get install -y wget

ENV JAVA_HOME /usr/lib/jvm/java-8-openjdk-amd64

RUN apt-get install software-properties-common python-software-properties -y
RUN apt-get install gnome-terminal -y
RUN add-apt-repository ppa:openjdk-r/ppa -y
RUN add-apt-repository ppa:eugenesan/ppa -y            #ADD MC to repository
RUN apt-get update
RUN apt-get install mc -y
RUN apt-get install -y --no-install-recommends openjdk-8-jre
RUN rm -rf /var/lib/apt/lists/*

# Define commonly used JAVA_HOME variable
ENV JAVA_HOME /usr/lib/jvm/java-7-openjdk-amd64

# Install ElasticSearch.
RUN cd /
RUN wget https://download.elasticsearch.org/elasticsearch/elasticsearch/$ES_PKG_NAME.deb
RUN dpkg -i $ES_PKG_NAME.deb
RUN rm -f $ES_PKG_NAME.deb

# Copy scripts
RUN mkdir -p /etc/elasticsearch/scripts
COPY /resources/matching.groovy /etc/elasticsearch/scripts/matching.groovy

# Settings
COPY /resources/elasticsearch.yml /resources/elasticsearch.yml
RUN cat /resources/elasticsearch.yml >> /etc/elasticsearch/elasticsearch.yml

# Install KIBANA and SENSE
RUN wget -qO - https://packages.elastic.co/GPG-KEY-elasticsearch | sudo apt-key add -
RUN echo "deb http://packages.elastic.co/kibana/4.5/debian stable main" | sudo tee -a /etc/apt/sources.list
RUN sudo apt-get update && sudo apt-get install kibana -y
RUN sudo update-rc.d kibana defaults 95 10
RUN /opt/kibana/bin/kibana plugin --install elastic/sense
RUN /etc/init.d/kibana restart

# Define default command.
COPY /scripts/run.sh /scripts/run.sh
ENTRYPOINT ["/bin/bash", "/scripts/run.sh"]

EXPOSE 9200
EXPOSE 9300
EXPOSE 5601
