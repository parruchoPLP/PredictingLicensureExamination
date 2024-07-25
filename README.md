# Predicting Electronics Engineers Licensure Examination Performance

## Installation

To run the project, follow these steps:

1. Install python and pip.

2. Install flask through pip:
    ```sh
    pip install flask
    ```
    
3. Install the necessary python libraries through pip:
   ```sh
   pip install pandas scikit-learn joblib numpy matplotlib
   ```

4. Make sure gd extension is enabled in the php configuration file (php.ini)

5. Open the terminal and do the following:
   ```sh
   cd Thesis
   composer update
   cp .env.example .env
   php artisan key:generate
   npm install -D tailwindcss postcss autoprefixer
   ```

6. Open a new terminal to start the flask development server:
    ```sh
    cd ThesisPredictiveModel
    py app.py
    ```

8. Open a new terminal to start laravel and npm development server:
    ```sh
    cd Thesis
    ```
    ```sh
    php artisan serve
    ```
    ```sh
    npm run dev
    ```
