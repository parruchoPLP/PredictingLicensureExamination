# Predicting Electronics Engineers Licensure Examination Performance

## Installation

To run the project, follow these steps:

1. Install python and pip.

2. Install flask through pip:
    ```sh
    pip install flask
    ```

4. Go to project directory, open terminal and enter the following:
   ```sh
   composer install
   cp .env.example .env
   php artisan key:generate
   npm install -D tailwindcss postcss autoprefixer
   ```

5. Go to ThesisPredictiveModel directory and open terminal.

6. Start the flask development server:
    ```sh
    python app.py
    ```

7. Go to Thesis laravel directory and open terminal.
   
8. Start laravel server and tailwind:
    ```sh
    php artisan serve
    ```
    ```sh
    npm run dev
    ```
