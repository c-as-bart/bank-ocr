### Installation
```shell script
docker-compose up -d --build
docker-compose exec php composer install
```

### Run
```shell script
docker-compose exec php bin/console bank-ocr:account-numbers:process
```

### Path to result
```shell script
./data/result.txt
```