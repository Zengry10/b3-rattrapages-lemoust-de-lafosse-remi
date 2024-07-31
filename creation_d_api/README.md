# Creation API PHP Symfony



This is a simple Symfony + API Platform application that helps distributors make orders

# Ressource vidéo YTB project

First of all, here are the 3 example videos explaining certain parts of the statement. 

Below, you'll find all the information and explanations you need.

1 - https://youtu.be/NCgSPlnWeWk
2 - https://youtu.be/nbIbEfjkils
3 - https://youtu.be/qCEnaGXPHXU

## Getting Started
These instructions will get a copy of the project up and running on your machine.

### Prerequisites
- Docker compose `version 2` installed on your machine.

### Installation

1. Clone the repository to your local machine:

```bash
git clone git@github.com:yommie/product-api.git
```

2. Copy the contents of `.env.example` into a newly created `.env` file and modify the values according to your setup.

3. Build and run the Docker containers by running the following command:

```bash
make run
```

Application would be available locally on port `9876`

This project comes with an Open API UI to test the API endpoints. The docs can be accessed at `/docs`.

> You can check the `Makefile` for other available commands.

## Credentials

After building the project, you can use the following users to test

### Admin
**username**: admin

**password**: password

### Normal User
**username**: user

**password**: password

## Currency units

In this application, currency is stored in `integers` and not `floats`. This means that the currency is stored in it's base form. Take `USD` as an example. `100` cents make up `1 USD`.

Hence, `7000` would not mean `seven thousand dollars` but would mean `7000` / `100` which would be `70` dollars.

This was done to avoid some unexpected behaviors that come with float operations.

## Protected Routes

The following routes are accessible to the general public

- POST `/api/users`

  User registration

- POST `/api/login_check`
  
  User login

- GET `/docs`
  
  API docs for testing

The following routes requires authentication to be accessed

- GET `POST /api/products`

  Get products

- GET `/api/product/:id`

  Get single product

- GET `/api/baskets`

  Get authenticated user basket

- POST `/api/baskets`
  
  Add a product to the basket

- GET `/api/product/cancel`

  Cancel a basket

- GET `/api/product/checkout`

  Checkout a basket

- GET `/api/product/validate`

  Validate a basket

The following routes can only be accessed by admins

- POST `/api/products`

  Create a product resource

- PATCH `/api/products/:id/add-to-stock`
  
  Add more units to a product

- GET `/api/users/`

  List all users

- GET `/api/users/:id`

  Get single user

## API Endpoints

## User Registration

### POST /api/users

**Request**

```bash
curl -X 'POST' \
  'http://127.0.0.1:9876/api/users' \
  -H 'accept: application/json' \
  -H 'Content-Type: application/json' \
  -d '{
  "username": "newuser",
  "password": "password"
}'
```

**Response `201`**

```json
{
  "id": 18,
  "username": "newuser",
  "createdAt": "2024-07-31T08:01:09+00:00"
}
```

## User Login

### POST /api/login_check

**Request**

```bash
curl -X 'POST' \
  'http://127.0.0.1:9876/api/login_check' \
  -H 'accept: application/json' \
  -H 'Content-Type: application/json' \
  -d '{
  "username": "user",
  "password": "password"
}'
```
**Response `200`**

```json
{
  "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE3MjI0MTI3NjIsImV4cCI6MTcyMjQxNjM2Miwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoidXNlciJ9.Z7MQJ0nFwu7Pzzw0aeYRV-g2hvxU9RU8d1aYQ98bxnJF1pdo1tbWGWx6MTWxOywxZzA3VU1h7h49Fh_c-vyp0xz0b7z13HYmQz91ANQnRs6y9e72LuFkT3WR9Rl1_F13JqaslQ8OBVqOSWPfFR1cxO-DFTkeHg5ZGhvYbey90LtaaJX--fjgK4R61SHD7ZnBcSoD0ZNl5xZqdWH3qam91cGw4uCPNPkZo1dGYrDJX-BSoMYfWZVDWivS1Id-g-Q6xwDJcdnSDMVlqiioxq5hrUULR5lB-mPmcVd_ipaA0XJ7J9cZxnTm8mzrLDPk7qdhFdpcIuiNArXFPXdyOnrCzw"
}
```

## List Products

### POST /api/products

**Request**

```bash
curl -X 'GET' \
  'http://127.0.0.1:9876/api/products?page=1' \
  -H 'accept: application/json' \
  -H 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE3MjI0MTI3NjIsImV4cCI6MTcyMjQxNjM2Miwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoidXNlciJ9.Z7MQJ0nFwu7Pzzw0aeYRV-g2hvxU9RU8d1aYQ98bxnJF1pdo1tbWGWx6MTWxOywxZzA3VU1h7h49Fh_c-vyp0xz0b7z13HYmQz91ANQnRs6y9e72LuFkT3WR9Rl1_F13JqaslQ8OBVqOSWPfFR1cxO-DFTkeHg5ZGhvYbey90LtaaJX--fjgK4R61SHD7ZnBcSoD0ZNl5xZqdWH3qam91cGw4uCPNPkZo1dGYrDJX-BSoMYfWZVDWivS1Id-g-Q6xwDJcdnSDMVlqiioxq5hrUULR5lB-mPmcVd_ipaA0XJ7J9cZxnTm8mzrLDPk7qdhFdpcIuiNArXFPXdyOnrCzw'
```

**Response `200`**

```json
{
  "collection": [
    {
      "id": 1,
      "name": "assumenda beatae",
      "imagePath": "66a9eb3b4f7e7486532019.png",
      "description": "Repudiandae nulla ratione et cum perspiciatis quis. Alias totam omnis animi veniam. Saepe dolorum dolorem odio suscipit architecto pariatur quasi.",
      "price": 57895,
      "note": "Aut accusamus nulla sed quasi ducimus qui. Molestiae eveniet voluptatem rerum sit ipsam fuga. Et quas eligendi aut ipsum numquam. Vel eligendi ullam corrupti ea illo tenetur numquam nihil. Porro expedita sequi dolorem consequatur eos.",
      "unitsRemaining": 18,
      "createdAt": "2024-07-31T07:57:46+00:00"
    },
    {
      "id": 2,
      "name": "quo labore",
      "imagePath": "66a9eb3b4f7e7486532019.png",
      "description": "Commodi nihil adipisci sit aut autem libero consectetur nobis. Exercitationem corrupti amet possimus labore et tempora dolorem. Ipsum rerum ad et facere.",
      "price": 75956,
      "note": "Provident id facere aut et tenetur et ipsum. Est voluptates totam veniam in. Quisquam aut illum quaerat qui et dolorem. Optio modi enim provident accusantium expedita. Asperiores molestiae natus quasi est eos quae.",
      "unitsRemaining": 70,
      "createdAt": "2024-07-31T07:57:46+00:00"
    },
    {
      "id": 3,
      "name": "temporibus explicabo",
      "imagePath": "66a9eb3b4f7e7486532019.png",
      "description": "Aspernatur unde ea praesentium dolor vitae ea iusto sint. Quos at dolore recusandae et. Qui commodi minus et praesentium.",
      "price": 85296,
      "note": "Aspernatur quae sed possimus sit qui tempore. Unde minima distinctio rerum illo ea ut. Fugiat ratione quia fugit. Voluptatum commodi magnam itaque consequuntur sed voluptatum autem. Minus nulla voluptates et nostrum ducimus.",
      "unitsRemaining": 60,
      "createdAt": "2024-07-31T07:57:46+00:00"
    },
    {
      "id": 4,
      "name": "est illo",
      "imagePath": "66a9eb3b4f7e7486532019.png",
      "description": "Dolores provident est assumenda. Nostrum at optio explicabo ratione nihil qui. Autem distinctio officiis aperiam ex.",
      "price": 14523,
      "note": "Et non dolores illo in recusandae ut accusantium. Magnam non totam et voluptate assumenda et aut. Quo qui qui fuga perferendis blanditiis error et. Sit beatae ad incidunt odio fugiat voluptas molestiae. Ut magni enim quae iure.",
      "unitsRemaining": 58,
      "createdAt": "2024-07-31T07:57:46+00:00"
    },
    {
      "id": 5,
      "name": "doloribus autem",
      "imagePath": "66a9eb3b4f7e7486532019.png",
      "description": "Est blanditiis rerum illo nulla. Commodi veniam repudiandae minima sunt suscipit cum quisquam quas. Quae odit nisi modi cumque aut.",
      "price": 84932,
      "note": "Voluptatem modi et laborum perspiciatis enim eaque sed. Laborum suscipit quasi veritatis sed tenetur suscipit. Quo deserunt laudantium optio laudantium officiis est voluptatem. Est fugiat qui amet consequuntur. Occaecati incidunt fugit sunt ipsa facilis.",
      "unitsRemaining": 58,
      "createdAt": "2024-07-31T07:57:46+00:00"
    },
    {
      "id": 6,
      "name": "iusto id",
      "imagePath": "66a9eb3b4f7e7486532019.png",
      "description": "Veniam eum excepturi itaque ratione. Sequi tempore sint hic vitae voluptatem vel. Eaque iusto odio provident corporis occaecati sint.",
      "price": 24042,
      "note": "Dicta aliquid quasi odio quia aliquam eum. Amet ea rerum animi optio. Laboriosam consequatur ut veniam animi ea et. Deserunt ut non quaerat praesentium nisi ducimus. Ducimus voluptate tempore qui et sed.",
      "unitsRemaining": 80,
      "createdAt": "2024-07-31T07:57:46+00:00"
    },
    {
      "id": 7,
      "name": "velit quo",
      "imagePath": "66a9eb3b4f7e7486532019.png",
      "description": "Sed quam non ex vitae nisi magni nulla eum. Voluptatem sunt et fugit officiis rerum explicabo. Consequuntur culpa iusto sed eos.",
      "price": 87690,
      "note": "Maiores aut modi modi natus. Explicabo et et omnis maiores consequatur possimus ipsum. Ut vitae ea ut quia pariatur. Esse ut dolorum laboriosam expedita nostrum dolorem in impedit. Odio et reprehenderit mollitia assumenda adipisci.",
      "unitsRemaining": 20,
      "createdAt": "2024-07-31T07:57:46+00:00"
    },
    {
      "id": 8,
      "name": "voluptas dolores",
      "imagePath": "66a9eb3b4f7e7486532019.png",
      "description": "Error quia reiciendis doloribus aspernatur quia. A officia iusto voluptas ratione eligendi. Consectetur rerum nisi doloribus aliquid.",
      "price": 49521,
      "note": "Vero sunt dolorem voluptas maiores. Numquam non est cumque consequatur. Harum officia recusandae consequuntur nulla aut. Ut rerum eum quis velit est repellendus. Impedit in et ut sit.",
      "unitsRemaining": 35,
      "createdAt": "2024-07-31T07:57:46+00:00"
    },
    {
      "id": 9,
      "name": "sunt dignissimos",
      "imagePath": "66a9eb3b4f7e7486532019.png",
      "description": "Ut dolores ut dignissimos autem optio quidem aspernatur aliquam. Nostrum est doloremque et aut velit deserunt tempore libero. Itaque occaecati et sint sunt voluptas.",
      "price": 64630,
      "note": "Officiis nesciunt quas incidunt amet pariatur accusamus deserunt. Praesentium accusantium et rem sunt quis illo officia. Eos a autem quam quisquam quam omnis commodi est. Perferendis rem velit ratione dolorem velit. Ea quos sit neque dolores voluptatem qui facere.",
      "unitsRemaining": 92,
      "createdAt": "2024-07-31T07:57:46+00:00"
    },
    {
      "id": 10,
      "name": "nihil beatae",
      "imagePath": "66a9eb3b4f7e7486532019.png",
      "description": "Maxime pariatur quos commodi facere reiciendis magnam. Omnis et dolorum sequi odit. Praesentium deserunt sit nihil itaque.",
      "price": 26542,
      "note": "Vitae qui accusamus veniam illo nobis sapiente eum neque. Quo et magni corporis fugiat rerum sunt. Saepe natus qui laboriosam sed quibusdam. Et esse quisquam magnam est. Voluptatibus sed quia autem dolores.",
      "unitsRemaining": 13,
      "createdAt": "2024-07-31T07:57:46+00:00"
    }
  ],
  "totalItems": 45,
  "itemsPerPage": 10,
  "currentPage": 1,
  "totalPages": 5
}
```

## Get Product

### GET /api/product/:id

**Request**

```bash
curl -X 'GET' \
  'http://127.0.0.1:9876/api/product/1' \
  -H 'accept: application/json' \
  -H 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE3MjI0MTI3NjIsImV4cCI6MTcyMjQxNjM2Miwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoidXNlciJ9.Z7MQJ0nFwu7Pzzw0aeYRV-g2hvxU9RU8d1aYQ98bxnJF1pdo1tbWGWx6MTWxOywxZzA3VU1h7h49Fh_c-vyp0xz0b7z13HYmQz91ANQnRs6y9e72LuFkT3WR9Rl1_F13JqaslQ8OBVqOSWPfFR1cxO-DFTkeHg5ZGhvYbey90LtaaJX--fjgK4R61SHD7ZnBcSoD0ZNl5xZqdWH3qam91cGw4uCPNPkZo1dGYrDJX-BSoMYfWZVDWivS1Id-g-Q6xwDJcdnSDMVlqiioxq5hrUULR5lB-mPmcVd_ipaA0XJ7J9cZxnTm8mzrLDPk7qdhFdpcIuiNArXFPXdyOnrCzw'
```

**Response `200`**

```json
{
  "id": 1,
  "name": "assumenda beatae",
  "imagePath": "/images/products/66a9eb3b4f7e7486532019.png",
  "description": "Repudiandae nulla ratione et cum perspiciatis quis. Alias totam omnis animi veniam. Saepe dolorum dolorem odio suscipit architecto pariatur quasi.",
  "price": 57895,
  "note": "Aut accusamus nulla sed quasi ducimus qui. Molestiae eveniet voluptatem rerum sit ipsam fuga. Et quas eligendi aut ipsum numquam. Vel eligendi ullam corrupti ea illo tenetur numquam nihil. Porro expedita sequi dolorem consequatur eos.",
  "unitsRemaining": 18,
  "createdAt": "2024-07-31T07:57:46+00:00"
}
```

## Add product to basket

### POST /api/baskets

**Request**

```bash
curl -X 'POST' \
  'http://127.0.0.1:9876/api/baskets' \
  -H 'accept: application/json' \
  -H 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE3MjI0MTI3NjIsImV4cCI6MTcyMjQxNjM2Miwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoidXNlciJ9.Z7MQJ0nFwu7Pzzw0aeYRV-g2hvxU9RU8d1aYQ98bxnJF1pdo1tbWGWx6MTWxOywxZzA3VU1h7h49Fh_c-vyp0xz0b7z13HYmQz91ANQnRs6y9e72LuFkT3WR9Rl1_F13JqaslQ8OBVqOSWPfFR1cxO-DFTkeHg5ZGhvYbey90LtaaJX--fjgK4R61SHD7ZnBcSoD0ZNl5xZqdWH3qam91cGw4uCPNPkZo1dGYrDJX-BSoMYfWZVDWivS1Id-g-Q6xwDJcdnSDMVlqiioxq5hrUULR5lB-mPmcVd_ipaA0XJ7J9cZxnTm8mzrLDPk7qdhFdpcIuiNArXFPXdyOnrCzw' \
  -H 'Content-Type: application/json' \
  -d '{
  "productId": 1,
  "quantity": 2
}'
```

**Response `200`**

```json
{
  "id": 1,
  "totalPrice": 115790,
  "status": "draft",
  "createdAt": "2024-07-31T08:10:17+00:00",
  "basketItems": [
    {
      "id": 1,
      "product": {
        "id": 1,
        "name": "assumenda beatae",
        "imagePath": "/images/products/66a9eb3b4f7e7486532019.png",
        "description": "Repudiandae nulla ratione et cum perspiciatis quis. Alias totam omnis animi veniam. Saepe dolorum dolorem odio suscipit architecto pariatur quasi.",
        "price": 57895
      },
      "quantity": 2,
      "unitPrice": 57895,
      "totalPrice": 115790,
      "createdAt": "2024-07-31T08:10:17+00:00"
    }
  ]
}
```

## Remove product from basket

### POST /api/basket-item/:id

The `id` passed in the request is that of the basket item.

**Request**

```bash
curl -X 'DELETE' \
  'http://127.0.0.1:9876/api/basket-item/1' \
  -H 'accept: */*' \
  -H 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE3MjI0MTI3NjIsImV4cCI6MTcyMjQxNjM2Miwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoidXNlciJ9.Z7MQJ0nFwu7Pzzw0aeYRV-g2hvxU9RU8d1aYQ98bxnJF1pdo1tbWGWx6MTWxOywxZzA3VU1h7h49Fh_c-vyp0xz0b7z13HYmQz91ANQnRs6y9e72LuFkT3WR9Rl1_F13JqaslQ8OBVqOSWPfFR1cxO-DFTkeHg5ZGhvYbey90LtaaJX--fjgK4R61SHD7ZnBcSoD0ZNl5xZqdWH3qam91cGw4uCPNPkZo1dGYrDJX-BSoMYfWZVDWivS1Id-g-Q6xwDJcdnSDMVlqiioxq5hrUULR5lB-mPmcVd_ipaA0XJ7J9cZxnTm8mzrLDPk7qdhFdpcIuiNArXFPXdyOnrCzw'
```

**Response `204`**

No response body for this request. A successful response would have the `204` HTTP status code

## View basket

### GET /api/baskets

**Request**

```bash
curl -X 'GET' \
  'http://127.0.0.1:9876/api/baskets' \
  -H 'accept: application/json' \
  -H 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE3MjI0MTI3NjIsImV4cCI6MTcyMjQxNjM2Miwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoidXNlciJ9.Z7MQJ0nFwu7Pzzw0aeYRV-g2hvxU9RU8d1aYQ98bxnJF1pdo1tbWGWx6MTWxOywxZzA3VU1h7h49Fh_c-vyp0xz0b7z13HYmQz91ANQnRs6y9e72LuFkT3WR9Rl1_F13JqaslQ8OBVqOSWPfFR1cxO-DFTkeHg5ZGhvYbey90LtaaJX--fjgK4R61SHD7ZnBcSoD0ZNl5xZqdWH3qam91cGw4uCPNPkZo1dGYrDJX-BSoMYfWZVDWivS1Id-g-Q6xwDJcdnSDMVlqiioxq5hrUULR5lB-mPmcVd_ipaA0XJ7J9cZxnTm8mzrLDPk7qdhFdpcIuiNArXFPXdyOnrCzw'
```

**Response `200`**

```json
{
  "id": 1,
  "totalPrice": 343658,
  "status": "draft",
  "createdAt": "2024-07-31T08:10:17+00:00",
  "basketItems": [
    {
      "id": 2,
      "product": {
        "id": 2,
        "name": "quo labore",
        "imagePath": "/images/products/66a9eb3b4f7e7486532019.png",
        "description": "Commodi nihil adipisci sit aut autem libero consectetur nobis. Exercitationem corrupti amet possimus labore et tempora dolorem. Ipsum rerum ad et facere.",
        "price": 75956
      },
      "quantity": 3,
      "unitPrice": 75956,
      "totalPrice": 227868,
      "createdAt": "2024-07-31T08:11:58+00:00"
    }
  ]
}
```

## Validate basket

### GET /api/baskets/validate

This step is required before checking out.

**Request**

```bash
curl -X 'POST' \
  'http://127.0.0.1:9876/api/baskets/validate' \
  -H 'accept: application/json' \
  -H 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE3MjI0MTI3NjIsImV4cCI6MTcyMjQxNjM2Miwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoidXNlciJ9.Z7MQJ0nFwu7Pzzw0aeYRV-g2hvxU9RU8d1aYQ98bxnJF1pdo1tbWGWx6MTWxOywxZzA3VU1h7h49Fh_c-vyp0xz0b7z13HYmQz91ANQnRs6y9e72LuFkT3WR9Rl1_F13JqaslQ8OBVqOSWPfFR1cxO-DFTkeHg5ZGhvYbey90LtaaJX--fjgK4R61SHD7ZnBcSoD0ZNl5xZqdWH3qam91cGw4uCPNPkZo1dGYrDJX-BSoMYfWZVDWivS1Id-g-Q6xwDJcdnSDMVlqiioxq5hrUULR5lB-mPmcVd_ipaA0XJ7J9cZxnTm8mzrLDPk7qdhFdpcIuiNArXFPXdyOnrCzw' \
  -d ''
```

**Response `200`**

```json
{
  "id": 1,
  "totalPrice": 343658,
  "status": "validated",
  "createdAt": "2024-07-31T08:10:17+00:00",
  "basketItems": [
    {
      "id": 2,
      "product": {
        "id": 2,
        "name": "quo labore",
        "imagePath": "/images/products/66a9eb3b4f7e7486532019.png",
        "description": "Commodi nihil adipisci sit aut autem libero consectetur nobis. Exercitationem corrupti amet possimus labore et tempora dolorem. Ipsum rerum ad et facere.",
        "price": 75956
      },
      "quantity": 3,
      "unitPrice": 75956,
      "totalPrice": 227868,
      "createdAt": "2024-07-31T08:11:58+00:00"
    }
  ]
}
```

## Checkout basket

### GET /api/baskets/checkout

This completes the order.

**Request**

```bash
curl -X 'POST' \
  'http://127.0.0.1:9876/api/baskets/checkout' \
  -H 'accept: application/json' \
  -H 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE3MjI0MTI3NjIsImV4cCI6MTcyMjQxNjM2Miwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoidXNlciJ9.Z7MQJ0nFwu7Pzzw0aeYRV-g2hvxU9RU8d1aYQ98bxnJF1pdo1tbWGWx6MTWxOywxZzA3VU1h7h49Fh_c-vyp0xz0b7z13HYmQz91ANQnRs6y9e72LuFkT3WR9Rl1_F13JqaslQ8OBVqOSWPfFR1cxO-DFTkeHg5ZGhvYbey90LtaaJX--fjgK4R61SHD7ZnBcSoD0ZNl5xZqdWH3qam91cGw4uCPNPkZo1dGYrDJX-BSoMYfWZVDWivS1Id-g-Q6xwDJcdnSDMVlqiioxq5hrUULR5lB-mPmcVd_ipaA0XJ7J9cZxnTm8mzrLDPk7qdhFdpcIuiNArXFPXdyOnrCzw' \
  -d ''
```

**Response `200`**

```json
{
  "id": 1,
  "totalPrice": 343658,
  "status": "completed",
  "createdAt": "2024-07-31T08:10:17+00:00",
  "basketItems": [
    {
      "id": 2,
      "product": {
        "id": 2,
        "name": "quo labore",
        "imagePath": "/images/products/66a9eb3b4f7e7486532019.png",
        "description": "Commodi nihil adipisci sit aut autem libero consectetur nobis. Exercitationem corrupti amet possimus labore et tempora dolorem. Ipsum rerum ad et facere.",
        "price": 75956
      },
      "quantity": 3,
      "unitPrice": 75956,
      "totalPrice": 227868,
      "createdAt": "2024-07-31T08:11:58+00:00"
    }
  ]
}
```

## Cancel basket

### GET /api/baskets/cancel

This cancels the order.

**Request**

```bash
curl -X 'POST' \
  'http://127.0.0.1:9876/api/baskets/cancel' \
  -H 'accept: application/json' \
  -H 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE3MjI0MTI3NjIsImV4cCI6MTcyMjQxNjM2Miwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoidXNlciJ9.Z7MQJ0nFwu7Pzzw0aeYRV-g2hvxU9RU8d1aYQ98bxnJF1pdo1tbWGWx6MTWxOywxZzA3VU1h7h49Fh_c-vyp0xz0b7z13HYmQz91ANQnRs6y9e72LuFkT3WR9Rl1_F13JqaslQ8OBVqOSWPfFR1cxO-DFTkeHg5ZGhvYbey90LtaaJX--fjgK4R61SHD7ZnBcSoD0ZNl5xZqdWH3qam91cGw4uCPNPkZo1dGYrDJX-BSoMYfWZVDWivS1Id-g-Q6xwDJcdnSDMVlqiioxq5hrUULR5lB-mPmcVd_ipaA0XJ7J9cZxnTm8mzrLDPk7qdhFdpcIuiNArXFPXdyOnrCzw' \
  -d ''
```

**Response `200`**

```json
{
  "id": 2,
  "totalPrice": 255888,
  "status": "cancelled",
  "createdAt": "2024-07-31T08:23:02+00:00",
  "basketItems": [
    {
      "id": 3,
      "product": {
        "id": 3,
        "name": "temporibus explicabo",
        "imagePath": "/images/products/66a9eb3b4f7e7486532019.png",
        "description": "Aspernatur unde ea praesentium dolor vitae ea iusto sint. Quos at dolore recusandae et. Qui commodi minus et praesentium.",
        "price": 85296
      },
      "quantity": 3,
      "unitPrice": 85296,
      "totalPrice": 255888,
      "createdAt": "2024-07-31T08:23:02+00:00"
    }
  ]
}
```

## Rate a product

### GET /api/products/add-rating

> Only products that have been completely ordered by a user can be rated. A `403` forbidden status code would be returned if product has not been ordered. Minimum rating is `1` and max rating is `5`

**Request**

```bash
curl -X 'POST' \
  'http://127.0.0.1:9876/api/products/add-rating' \
  -H 'accept: application/json' \
  -H 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE3MjI0MTI3NjIsImV4cCI6MTcyMjQxNjM2Miwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoidXNlciJ9.Z7MQJ0nFwu7Pzzw0aeYRV-g2hvxU9RU8d1aYQ98bxnJF1pdo1tbWGWx6MTWxOywxZzA3VU1h7h49Fh_c-vyp0xz0b7z13HYmQz91ANQnRs6y9e72LuFkT3WR9Rl1_F13JqaslQ8OBVqOSWPfFR1cxO-DFTkeHg5ZGhvYbey90LtaaJX--fjgK4R61SHD7ZnBcSoD0ZNl5xZqdWH3qam91cGw4uCPNPkZo1dGYrDJX-BSoMYfWZVDWivS1Id-g-Q6xwDJcdnSDMVlqiioxq5hrUULR5lB-mPmcVd_ipaA0XJ7J9cZxnTm8mzrLDPk7qdhFdpcIuiNArXFPXdyOnrCzw' \
  -H 'Content-Type: application/json' \
  -d '{
  "productId": 2,
  "rating": 4,
  "note": "This product was awesome"
}'
```

**Response `201`**

```json
{
  "id": 1,
  "product": {
    "id": 2,
    "name": "quo labore",
    "imagePath": "/images/products/66a9eb3b4f7e7486532019.png",
    "description": "Commodi nihil adipisci sit aut autem libero consectetur nobis. Exercitationem corrupti amet possimus labore et tempora dolorem. Ipsum rerum ad et facere.",
    "price": 75956
  },
  "rating": 4,
  "note": "This product was awesome",
  "createdAt": "2024-07-31T08:27:59+00:00"
}
```

## Add to product stock

### GET /api/products/:id/add-to-stock

**Request**

```bash
curl -X 'PATCH' \
  'http://127.0.0.1:9876/api/products/1/add-to-stock' \
  -H 'accept: application/json' \
  -H 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE3MjI0MTYyNjMsImV4cCI6MTcyMjQxOTg2Mywicm9sZXMiOlsiUk9MRV9BRE1JTiIsIlJPTEVfVVNFUiJdLCJ1c2VybmFtZSI6ImFkbWluIn0.lP4cWkuB-sp2pAuruxBRyCaivkAtOyiCPTjFV5cweqsFUw00AiMTFO6Srr5hTfAMRJU_qWm73miEfvW992_bHl5ZOMGRmevlG0MNU3FD8UO534JfyMuQDOdP-F3ez-EvyJPo9d--8hp1NNEN6whmfNIw3WoZctI86ajsGMZJcZTOGfkkOaIYfcysFKrIQbNYog_T7dtyhK1KrX354bV98PQGbortImJHAkHsckmAvG-AkduoEz5xVTu5v8rnExL758_AhQweqjGoKgfbSzhjE3wSHWlIAMoFazU-ZjdsXnuB9GqL3wqZkeWUh3MNOQ6RGRF9NLxtJUNvgJzHGT6hVQ' \
  -H 'Content-Type: application/json' \
  -d '{
  "units": 7
}'
```

**Response `200`**

```json
{
  "id": 1,
  "name": "assumenda beatae",
  "imagePath": "/images/products/66a9eb3b4f7e7486532019.png",
  "description": "Repudiandae nulla ratione et cum perspiciatis quis. Alias totam omnis animi veniam. Saepe dolorum dolorem odio suscipit architecto pariatur quasi.",
  "price": 57895,
  "note": "Aut accusamus nulla sed quasi ducimus qui. Molestiae eveniet voluptatem rerum sit ipsam fuga. Et quas eligendi aut ipsum numquam. Vel eligendi ullam corrupti ea illo tenetur numquam nihil. Porro expedita sequi dolorem consequatur eos.",
  "unitsRemaining": 25,
  "createdAt": "2024-07-31T07:57:46+00:00"
}
```

## Create product

### POST /api/products

**Request**

```bash
curl -X 'POST' \
  'http://127.0.0.1:9876/api/products' \
  -H 'accept: application/json' \
  -H 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE3MjI0MTYyNjMsImV4cCI6MTcyMjQxOTg2Mywicm9sZXMiOlsiUk9MRV9BRE1JTiIsIlJPTEVfVVNFUiJdLCJ1c2VybmFtZSI6ImFkbWluIn0.lP4cWkuB-sp2pAuruxBRyCaivkAtOyiCPTjFV5cweqsFUw00AiMTFO6Srr5hTfAMRJU_qWm73miEfvW992_bHl5ZOMGRmevlG0MNU3FD8UO534JfyMuQDOdP-F3ez-EvyJPo9d--8hp1NNEN6whmfNIw3WoZctI86ajsGMZJcZTOGfkkOaIYfcysFKrIQbNYog_T7dtyhK1KrX354bV98PQGbortImJHAkHsckmAvG-AkduoEz5xVTu5v8rnExL758_AhQweqjGoKgfbSzhjE3wSHWlIAMoFazU-ZjdsXnuB9GqL3wqZkeWUh3MNOQ6RGRF9NLxtJUNvgJzHGT6hVQ' \
  -H 'Content-Type: multipart/form-data' \
  -F 'name=Table' \
  -F 'imageFile=@/path/to/image.jpg;type=image/jpeg' \
  -F 'description=This is a test description' \
  -F 'price=70000' \
  -F 'note=A random note' \
  -F 'unitsRemaining=900'
```

**Response `201`**

```json
{
  "id": 46,
  "name": "Table",
  "imagePath": "/images/products/66a9fd630bce3888450013.jpg",
  "description": "This is a test description",
  "price": 70000,
  "note": "A random note",
  "unitsRemaining": 900,
  "createdAt": "2024-07-31T09:01:23+00:00"
}
```

## List Users

### GET /api/users?page=1

**Request**

```bash
curl -X 'GET' \
  'http://127.0.0.1:9876/api/users?page=1' \
  -H 'accept: application/json' \
  -H 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE3MjI0MTYyNjMsImV4cCI6MTcyMjQxOTg2Mywicm9sZXMiOlsiUk9MRV9BRE1JTiIsIlJPTEVfVVNFUiJdLCJ1c2VybmFtZSI6ImFkbWluIn0.lP4cWkuB-sp2pAuruxBRyCaivkAtOyiCPTjFV5cweqsFUw00AiMTFO6Srr5hTfAMRJU_qWm73miEfvW992_bHl5ZOMGRmevlG0MNU3FD8UO534JfyMuQDOdP-F3ez-EvyJPo9d--8hp1NNEN6whmfNIw3WoZctI86ajsGMZJcZTOGfkkOaIYfcysFKrIQbNYog_T7dtyhK1KrX354bV98PQGbortImJHAkHsckmAvG-AkduoEz5xVTu5v8rnExL758_AhQweqjGoKgfbSzhjE3wSHWlIAMoFazU-ZjdsXnuB9GqL3wqZkeWUh3MNOQ6RGRF9NLxtJUNvgJzHGT6hVQ'
```

**Response `200`**

```json
{
  "collection": [
    {
      "id": 1,
      "username": "admin",
      "createdAt": "2024-07-31T07:57:39+00:00"
    },
    {
      "id": 2,
      "username": "user",
      "createdAt": "2024-07-31T07:57:39+00:00"
    },
    {
      "id": 3,
      "username": "shields.grace",
      "createdAt": "2024-07-31T07:57:40+00:00"
    },
    {
      "id": 4,
      "username": "okunze",
      "createdAt": "2024-07-31T07:57:40+00:00"
    },
    {
      "id": 5,
      "username": "lenora93",
      "createdAt": "2024-07-31T07:57:41+00:00"
    },
    {
      "id": 6,
      "username": "julianne.jones",
      "createdAt": "2024-07-31T07:57:41+00:00"
    },
    {
      "id": 7,
      "username": "chadrick.kihn",
      "createdAt": "2024-07-31T07:57:41+00:00"
    },
    {
      "id": 8,
      "username": "david.connelly",
      "createdAt": "2024-07-31T07:57:42+00:00"
    },
    {
      "id": 9,
      "username": "yraynor",
      "createdAt": "2024-07-31T07:57:42+00:00"
    },
    {
      "id": 10,
      "username": "edibbert",
      "createdAt": "2024-07-31T07:57:43+00:00"
    }
  ],
  "totalItems": 18,
  "itemsPerPage": 10,
  "currentPage": 1,
  "totalPages": 2
}
```

## Get User

### GET /api/users/:id

**Request**

```bash
curl -X 'GET' \
  'http://127.0.0.1:9876/api/users/5' \
  -H 'accept: application/json' \
  -H 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE3MjI0MTYyNjMsImV4cCI6MTcyMjQxOTg2Mywicm9sZXMiOlsiUk9MRV9BRE1JTiIsIlJPTEVfVVNFUiJdLCJ1c2VybmFtZSI6ImFkbWluIn0.lP4cWkuB-sp2pAuruxBRyCaivkAtOyiCPTjFV5cweqsFUw00AiMTFO6Srr5hTfAMRJU_qWm73miEfvW992_bHl5ZOMGRmevlG0MNU3FD8UO534JfyMuQDOdP-F3ez-EvyJPo9d--8hp1NNEN6whmfNIw3WoZctI86ajsGMZJcZTOGfkkOaIYfcysFKrIQbNYog_T7dtyhK1KrX354bV98PQGbortImJHAkHsckmAvG-AkduoEz5xVTu5v8rnExL758_AhQweqjGoKgfbSzhjE3wSHWlIAMoFazU-ZjdsXnuB9GqL3wqZkeWUh3MNOQ6RGRF9NLxtJUNvgJzHGT6hVQ'
```

**Response `200`**

```json
{
  "id": 5,
  "username": "lenora93",
  "createdAt": "2024-07-31T07:57:41+00:00"
}
```
