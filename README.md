# Bookstore
A plain PHP CRUD application where user can Add, Read, Update and delete book details.


### What users can do :
1. Read All Book details
2. Create New Book details
3. Update Book Title
4. Update Book Author

## Installation
---
- Install XAMMP on your PC
- Start by forking the repository, Click on fork at the top right corner on the repository
- Clone the repo using this command in your terminal :
```
git clone https://github.com/DevMukhtarr/Bookstore.git

```
- Install Dependencies with this command below :

```
composer install

```

- Add .env file and it should have JWT_SECRET_KEY and a strong string to encrypt the payload, An example is in `.env.example` which looks like this:

```
JWT_SECRET_KEY=XXXX
```

- start the server with this command

```
php -S localhost:8000
```

# Api Reference

Getting Started
- Base Url: The Base Url of the project is live at http://localhost:8000/
- Authentication: Authentication token will be available on sign in and sign up of user

# Endpoints
## Register
> POST /register

General:

- Register as a new user

> sample http://localhost:8000/register

Request sample:

```
{
    "name": "John Doe",
    "email": "Johndoe@gmail.com",
    "password": "johndoe123"
}
```

Response sample:

```
{
    "message": "Registration successful",
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImpvaG5kb2VAZ21haWwuY29tIn0.2URFMmvieU77uiu7Sa5SrQNpffENu-CSjQ26arsZSrE"
}
```
## Login

> POST /login

General:

- Login as a user

> sample http://localhost:8000/login

Request sample:

```
{
    "email": "Johndoe@gmail.com",
    "password": "johndoe123"
}
```

Response sample:

```
{
    "email": "Johndoe@gmail.com",
    "password": "johndoe123"
}
```
## Create New Book Details

> POST /add-book

General:

- Create New Book Details which includes Author and Title

> sample http://localhost:8000/add-book

Request sample:

Adding the JWT gotten from Login or Register response with `x-access-token` as the key i.e.

` 
eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6IkpvaG5kb2VAZ21haWwuY29tIiwiaWF0IjoxNjcyNjkxNjYxfQ.LBAONOO31VUC2-LB8OFTMf78YUYN9DVJ3ac81X7bK8Q`


```
{
    "author": "Napoleon Hill",
    "title": "Master Mind: The Memoirs of Napoleon Hill"
}
```

Response sample:

```
{
    "message": "New Book Uploaded"
}
```
