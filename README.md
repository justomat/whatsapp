# Usage

## Prerequisites

1. Git
2. Docker + Compose

## Setup

### Clone
```
git clone https://github.com/justomat/whatsapp
```

### First Run
```
docker compose up -d

php artisan migrate
```

### Register account
Using the browser go to http://localhost:8000/register

### API
Call the api as usual, you can see the list of all api at http://localhost:8000/swagger

### Listening to new messages
```
<!-- for each room -->
Echo.private(`chat.room.${roomId}`)
    .listen('MessageSent', (msg) => {
        console.log(msg);
    });
```
