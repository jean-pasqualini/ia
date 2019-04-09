run:
	docker build -t ia ./
	docker run --rm -it -v $(PWD):/app ia php /app/console --curse

bash:
	docker build -t ia ./
	docker run --rm -it -v $(PWD):/app ia bash