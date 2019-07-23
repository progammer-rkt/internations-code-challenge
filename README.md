# User Management application

This project is bootstrapped with [Create React App](https://github.com/facebook/create-react-app).

### How to install

You need `npm` tool to launch this application

1. Clone the project
    ```
    git clone https://github.com/progammer-rkt/internations-code-challenge.git
    ```
2. Switch to `frontend` branch
    ```
    git checkout frontend
    ```
3. Install all project dependencies
    ```
    npm install
    ```
4. Edit configuration and specify the API base url.
    ```
    # src/Config/index.js
    export default {
        ...
        service: {
            api: {
            url: 'http://user-manager.test/' # paste the base url here
            }
        }
        };
    ```
5. Launch the application
    ```
    npm start
    ```
6. Go to browser and open the url `http://localhost:3000`

## Available Scripts

In the project directory, you can run:

### `npm start`
