# Kafka php docker box

For development && testing purpose.

=======================================================================

##Current software versions

####Client (php app)
- php 7.1
- librdkafka - 0.9.5.0 (feel free to change version in docker-compose.yml)
- rdkafka - 3.0.3

####Server
- kafka - 0.11.0.0 (feel free to change version in docker-compose.yml)
- zookeeper - 3.4.5

## Initialization

```bash
docker-compose up -d
``` 

## Testing
Producer test:
```bash
docker-compose exec php_app php producer_test.php
```

Low consumer test
```bash
docker-compose exec php_app php consumer_low_level_test.php
```
