FROM java:openjdk-8-jre

ARG SCALA_VERSION=${SCALA_VERSION:-"2.11"}
ARG KAFKA_VERSION=${KAFKA_VERSION:-"0.11.0.0"}
ARG KAFKA_HOME=/opt/kafka_${SCALA_VERSION}-${KAFKA_VERSION}
ENV SCALA_VERSION=$SCALA_VERSION
ENV KAFKA_VERSION=$KAFKA_VERSION
ENV KAFKA_HOME=$KAFKA_HOME


RUN echo "kafka home = $KAFKA_HOME \n"

# install Kafka, zookeeper, supervisor
RUN apt-get update && \
    apt-get install -y zookeeper supervisor dnsutils && \
    cd /opt && \
    curl http://www-eu.apache.org/dist/kafka/${KAFKA_VERSION}/kafka_${SCALA_VERSION}-${KAFKA_VERSION}.tgz | tar zxf -

#cleanup
RUN rm -rf /var/lib/apt/lists/* && \
        apt-get autoremove -y && \
        apt-get clean && \
        apt-get autoclean

ADD start-kafka.sh /usr/bin/start-kafka.sh
RUN chmod guo+x /usr/bin/start-kafka.sh

# supervisor config
ADD conf/supervisor/kafka.conf conf/supervisor/zookeeper.conf /etc/supervisor/conf.d/

# 2181 - zookeeper, 9092 - kafka
EXPOSE 2181 9092

CMD ["supervisord", "-n"]
