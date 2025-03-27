# Docker Bursztyn 25

A Docker-based project containing:
- Laravel (PHP)
- Vue.js (Node.js)
- Nginx
- Elasticsearch
- MongoDB

## 🚀 Installation

### 1️⃣ Prerequisites
Make sure you have installed:
- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/install/)

### 2️⃣ Clone the repository
```sh
git clone https://github.com/username/docker-bursztyn-25.git
cd docker-bursztyn-25
```

### ️⃣ Copy and fill the .env file for Laravel
```sh
cp app/.env.example app/.env
```

###  ⃣ Copy and fill the .env file for docker-compose

```sh
cp .env.example .env
```

### ️⃣ Build and start the containers

```sh
docker-compose up --build -d
```
### 🌐 Available Services

| Service | 	URL                    |
|---|-------------------------|
| Frontend (Vue) | 	http://localhost:5173  |
| Backend (API) | 	http://localhost:8080  |
| Nginx | 	http://localhost:8080  |
| Elasticsearch	| http://localhost:9200   |
| MongoDB | 	 http://localhost:27017 |

### 🔧 Managing Containers

Check running containers:

```sh
docker ps
```
Stop all containers:

```shell
docker-compose down
```

Restart containers:

```sh
docker-compose restart
```


### 🔧 Backend configuration

In app container create an APP_KEY

```shell
./artisan key:generate
```

Run migrations

```shell
./artisan migrate:install
```




### 📌 Additional Information

Laravel runs on PHP-FPM and communicates with Nginx.
Vue.js uses a development server.
Elasticsearch and MongoDB are set up for local use.
You can add custom configurations in docker-compose.override.yml.


### 👤 Author
Tomasz Zymni
