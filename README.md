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
5. Creare ProducerAPI care trimite evenimente sub forma json pe Kafka.
    ```
    POST http://localhost/api/v1/json 
    {
        "content": {
            "name": "John",
            "age": 30
        },
        "key": "some_key"
    }
    ```
6. Creare ConsumerAPI Kafka ptr Producer-ul de mai sus.
    ``` bash
    make start-json-consumer
    ```
   
7. Creare ProducerAPI care trimite evenimente sub forma de obiecte definite (clase Java, C#, etc) in API pe Kafka.
     ``` bash
    POST http://localhost/api/v1/json 
    {
        "content": {
            "name": "John",
            "age": 30
        },
        "key": "some_key"
    }
    ```

8. Creare ConsumerAPI Kafka ptr Producer-ul de mai sus.
    ``` bash
   docker exec -it kafka bash
   kafka-console-consumer --topic object-topic --bootstrap-server localhost:9092
    ```
9. Creare ProducerAPI si publicare mesaje folosind schema for Kafka.
    > All the above already use schema
10. Creare ConsumerAPI for Kafka si consumare mesaje folosind schema.
    > All the above already use schema

11. Creare pipeline: un ConsumerAPI poate deveni mai departe Producator.
   I converted the first char-consumer to also produce messages to a new topic.

12. Folositi: Confluent REST proxy si prin cereri HTTP: creati un topic, cititi mesajele din topic.
    Creare mesaje si topic:  
   ``` bash
      curl -X POST \
      -H "Content-Type: application/vnd.kafka.json.v2+json" \
      -H "Accept: application/vnd.kafka.v2+json" \
      --data '{"records":[{"key":"jsmith","value":"alarm clock"},{"key":"htanaka","value":"batteries"},{"key":"awalther","value":"bookshelves"}]}' \
      "http://localhost:8082/topics/purchases"    
   ```

    Creare consumer:
    ``` bash
      curl -X POST \
      -H "Content-Type: application/vnd.kafka.v2+json" \
      --data '{"name": "ci1", "format": "json", "auto.offset.reset": "earliest"}' \
      http://localhost:8082/consumers/cg1
    ```
    Subscribe consumer la topic:
    ``` bash
      curl -X POST \
      -H "Content-Type: application/vnd.kafka.v2+json" \
      --data '{"topics":["purchases"]}' \
      http://localhost:8082/consumers/cg1/instances/ci1/subscription
    ```
    Citire mesaje:
    ``` bash
      curl -X GET \
      -H "Accept: application/vnd.kafka.json.v2+json" \
      http://localhost:8082/consumers/cg1/instances/ci1/records

      sleep 10

      curl -X GET \
      -H "Accept: application/vnd.kafka.json.v2+json" \
      http://localhost:8082/consumers/cg1/instances/ci1/records      ```
   ```
13. Creare API care publica evenimente pe 2 topic-uri Kafka. Folosind Kafka Streams, agregati datele de pe cele 2 topic-uri in alt topic.
    ``` bash
     curl -X POST \
      -H "Content-Type: application/json" \
      --data '{"message-1":"mihai", "message-2":"nicolae"}' \
      http://localhost/api/v1/double
    ```
