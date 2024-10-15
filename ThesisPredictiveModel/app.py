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
            'CALCULUS I', 'CALCULUS II', 'DIFFERENTIAL EQUATIONS', 
            'CHEMISTRY FOR ENGINEERS', 'PHYSICS FOR ENGINEERS', 
            'COMPUTER AIDED DRAFTING', 'ENGINEERING ECONOMICS', 
            'ENGINEERING MANAGEMENT', 'PHYSICS II', 'MATERIAL SCIENCE AND ENGINEERING',
            'COMPUTER PROGRAMMING', 'ENVIRONMENTAL SCIENCE AND ENGINEERING',
            'ADVANCED ENGINEERING MATHEMATICS', 'ELECTROMAGNETICS',
            'ECE LAWS, CONTRACTS, ETHICS, STANDARDS AND SAFETY',
            'ELECTRONICS 1: ELECTRONIC DEVICES AND CIRCUITS', 
            'ELECTRONICS 2: ELECTRONIC CIRCUIT ANALYSIS AND DESIGN', 
            'SIGNALS, SPECTRA AND SIGNAL PROCESSING', 
            'COMMUNICATIONS 1: PRINCIPLES OF COMMUNICATION SYSTEMS', 
            'COMMUNICATIONS 4: TRANSMISSION MEDIA AND ANTENNA SYSTEM AND DESIGN',
            'DIGITAL ELECTRONICS 1: LOGIC CIRCUITS AND SWITCHING THEORY', 
            'DIGITAL ELECTRONICS 2: MICROPROCESSOR, MICROCONTROLLER SYSTEM AND DESIGN',
            'FEEDBACK AND CONTROL SYSTEMS', 'DESIGN 1/CAPSTONE PROJECT 1', 
            'DESIGN 2/ CAPSTONE PROJECT 2', 'SEMINARS/COLLOQUIUM', 
            'ECE ELECTIVE: INDUSTRIAL ELECTRONICS'
        ]

        if not all(field in df_input.columns for field in required_fields):
            return jsonify({'error': 'Missing required fields'}), 400

        # Standardize the numerical features
        columns_to_standardize = [
            'CALCULUS I', 'CALCULUS II', 'DIFFERENTIAL EQUATIONS', 
            'CHEMISTRY FOR ENGINEERS', 'PHYSICS FOR ENGINEERS', 
            'COMPUTER AIDED DRAFTING', 'ENGINEERING ECONOMICS', 
            'ENGINEERING MANAGEMENT', 'PHYSICS II', 'MATERIAL SCIENCE AND ENGINEERING',
            'COMPUTER PROGRAMMING', 'ENVIRONMENTAL SCIENCE AND ENGINEERING',
            'ADVANCED ENGINEERING MATHEMATICS', 'ELECTROMAGNETICS',
            'ECE LAWS, CONTRACTS, ETHICS, STANDARDS AND SAFETY',
            'ELECTRONICS 1: ELECTRONIC DEVICES AND CIRCUITS', 
            'ELECTRONICS 2: ELECTRONIC CIRCUIT ANALYSIS AND DESIGN', 
            'SIGNALS, SPECTRA AND SIGNAL PROCESSING', 
            'COMMUNICATIONS 1: PRINCIPLES OF COMMUNICATION SYSTEMS', 
            'COMMUNICATIONS 4: TRANSMISSION MEDIA AND ANTENNA SYSTEM AND DESIGN',
            'DIGITAL ELECTRONICS 1: LOGIC CIRCUITS AND SWITCHING THEORY', 
            'DIGITAL ELECTRONICS 2: MICROPROCESSOR, MICROCONTROLLER SYSTEM AND DESIGN',
            'FEEDBACK AND CONTROL SYSTEMS', 'DESIGN 1/CAPSTONE PROJECT 1', 
            'DESIGN 2/ CAPSTONE PROJECT 2', 'SEMINARS/COLLOQUIUM', 
            'ECE ELECTIVE: INDUSTRIAL ELECTRONICS'
        ]
        scaler = StandardScaler()
        df_input[columns_to_standardize] = scaler.fit_transform(df_input[columns_to_standardize])

        # Make predictions for new data
        predictions = model.predict(df_input[required_fields])

        # Mapping numeric labels to categories (assuming binary classification: 0 - Fail, 1 - Pass)
        df_input['predicted_licensure_outcome'] = ['Expected to Pass' if pred == 1 else 'Expected to Fail' for pred in predictions]
        df_input[columns_to_standardize] = scaler.inverse_transform(df_input[columns_to_standardize])

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
