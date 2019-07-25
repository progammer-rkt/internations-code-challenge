# User Management application - API

This is created based on Symfony 4.3 framework

### How to install

1. Clone the project
    ```
    git clone https://github.com/progammer-rkt/internations-code-challenge.git
    ```
2. Switch to `backend` branch
    ```
    git checkout backend
    ```
3. Install all project dependencies
    ```
    composer install
    ```
4. Specify database in `.env` file
    ```
    DATABASE_URL=mysql://user:password@127.0.0.1:3306/database_name

5. Create the database
    ```
    php bin/console doctrine:database:create
    ```
6. Perform database migrations
    ```
    php bin/console doctrine:migration:migrate
    ```
7. Create an admin user
    ```
    curl -X POST -H "Content-Type: application/json" http://localhost/api/login_check -d '{"username":"johndoe","password":"test"}'
    ```
8. This will provide the token. Now add this token as Bearer in every api request.


### Architecture & Request Flow

Request flow and the architecture is shown below:

![API Request Flow Diagram](doc/img/API Request Flow Diagram.jpg)

