# MQT Lab Assignment


## Getting Started

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
2. Run command to start the containers
   ``` bash
    make start
    ```

## Requirements.

1. Creare Producer Kafka din consola (terminal).
   ``` bash
   docker exec -it kafka bash
   kafka-topics --create --topic mqt-lab-topic --bootstrap-server localhost:9092 --partitions 1 --replication-factor 1
   kafka-console-producer --topic mqt-lab-topic --bootstrap-server localhost:9092
   ```
2. Creare Consumer Kafka din consola (terminal).
   ``` bash
   docker exec -it kafka bash
   kafka-console-consumer --topic mqt-lab-topic --bootstrap-server localhost:9092
   ```
3. Creare ProducerAPI care trimite evenimente sub forma de siruri de cacactere pe Kafka.
    ```
    POST http://localhost/api/v1/char 
    {
        "content": "Hello World",
        "key": "some_key"
    }
    ``` 
4. Creare ConsumerAPI Kafka ptr Producer-ul de mai sus.
    ``` bash
    make start-char-consumer
    ```