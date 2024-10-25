from flask import Flask, request, jsonify
import pandas as pd
import joblib
from sklearn.preprocessing import LabelEncoder, StandardScaler
import os

app = Flask(__name__)

# Load the pre-trained model
model_file_path = 'random_forest_licensure_model.pkl'
try:
    model = joblib.load(model_file_path)
except Exception as e:
    print(f"An error occurred while loading the model: {e}")
    model = None

# Load label encoders
label_encoder_gender = LabelEncoder()

# Load the dataset (for label encoder fitting)
file_path = 'TrainingData.csv'
df = pd.read_csv(file_path)

# Fit label encoders
label_encoder_gender.fit(df['PERFORMANCE'])

# Endpoint for batch prediction
@app.route('/batchpredict', methods=['POST'])
def batch_predict():
    if model is None:
        return jsonify({'error': 'Model not loaded!'}), 500

    try:
        # Get file path from the request
        file_path = request.json.get('file_path')
        if not file_path:
            return jsonify({'error': 'File path is required'}), 400

        # Use raw strings or escape backslashes
        file_path = file_path.replace("\\", "\\\\")
        df_input = pd.read_csv(file_path)
        app.logger.info("Received file: %s", file_path)

        # Check if all required fields are present in the input data
        required_fields = [
            'ECE 111', 'ECE 112', 'ECE 114', 'ECE 121', 'ECE 122', 'ECE 131', 
            'ECE 132', 'ECE 133', 'ECE 141', 'ECE 143', 'ECE 142', 'ECE 146', 
            'ECE 152', 'ECE 153', 'ECE 156', 'ECE 151', 'ECE 154', 'ECE 158', 
            'ECE 155', 'ECE 162', 'ECE 160', 'ECE 163', 'ECE 164', 'ECE 166', 
            'ECE 167', 'ECE 168', 'ECE 202'
        ]

        if not all(field in df_input.columns for field in required_fields):
            return jsonify({'error': 'Missing required fields'}), 400

        # Standardize the numerical features
        columns_to_standardize = [
            'ECE 111', 'ECE 112', 'ECE 114', 'ECE 121', 'ECE 122', 'ECE 131', 
            'ECE 132', 'ECE 133', 'ECE 141', 'ECE 143', 'ECE 142', 'ECE 146', 
            'ECE 152', 'ECE 153', 'ECE 156', 'ECE 151', 'ECE 154', 'ECE 158', 
            'ECE 155', 'ECE 162', 'ECE 160', 'ECE 163', 'ECE 164', 'ECE 166', 
            'ECE 167', 'ECE 168', 'ECE 202'
        ]
        scaler = StandardScaler()
        df_input[columns_to_standardize] = scaler.fit_transform(df_input[columns_to_standardize])

        # Make predictions for new data
        predictions = model.predict(df_input[required_fields])

        # Mapping numeric labels to categories (assuming binary classification: 0 - Fail, 1 - Pass)
        df_input['PERFORMANCE'] = ['Pass' if pred == 1 else 'Fail' for pred in predictions]
        df_input[columns_to_standardize] = scaler.inverse_transform(df_input[columns_to_standardize])
        df_input.rename(columns={'PERFORMANCE':'EXPECTED PERFORMANCE'}, inplace=True)
        df_input.to_csv(file_path, index=False)
        app.logger.info("Predictions saved to %s", file_path)

        return jsonify({'message': 'Predictions made successfully!', 'output_file': file_path})
    except Exception as e:
        app.logger.error("Prediction error: %s", e)
        return jsonify({'error': f'Prediction error: {e}'}), 400

# Route for the root URL
@app.route('/')
def index():
    return 'Welcome to the Licensure Exam Prediction API!'

if __name__ == '__main__':
    app.run(debug=True)
