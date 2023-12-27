RABBITMQ_CONTAINER_NAME := rabbitmq

start:
	docker-compose up -d

restart:
	docker-compose restart $(RABBITMQ_CONTAINER_NAME)

stop:
	docker-compose down

logs:
	docker-compose logs -f $(RABBITMQ_CONTAINER_NAME)

enter:
	docker-compose exec $(RABBITMQ_CONTAINER_NAME) bash
