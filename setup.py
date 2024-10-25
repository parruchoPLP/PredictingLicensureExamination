import os
import subprocess
import sys
import shutil

def run_command(command):
    result = subprocess.run(command, shell=True)
    if result.returncode != 0:
        sys.exit(f"Error: Command '{command}' failed")

def copy_file(src, dest):
    try:
        shutil.copyfile(src, dest)
        print(f"Copied {src} to {dest}")
    except IOError as e:
        sys.exit(f"Unable to copy file {src} to {dest}: {e}")

def main():
    # Get the current working directory (the root of the project)
    root_dir = os.getcwd()
    print(f"Root directory: {root_dir}")

    # Define relative paths to the model and laravel directories
    model_dir = os.path.join(root_dir, "ThesisPredictiveModel")
    laravel_dir = os.path.join(root_dir, "Thesis")
    venv_dir = os.path.join(model_dir, "venv")

    # Ensure directories exist
    if not os.path.exists(model_dir):
        sys.exit("Error: ThesisPredictiveModel directory not found.")
    if not os.path.exists(laravel_dir):
        sys.exit("Error: Thesis directory not found.")

    # Create virtual environment if it doesn't exist
    if not os.path.exists(venv_dir):
        print("Creating virtual environment...")
        run_command(f"python -m venv {venv_dir}")

    # Activate virtual environment
    activate_script = os.path.join(venv_dir, "Scripts", "activate") if os.name == "nt" else os.path.join(venv_dir, "bin", "activate")
    activate_command = f"source {activate_script}" if os.name != "nt" else activate_script

    # Define the commands to run
    python_commands = [
        f"{activate_command} && pip install pandas scikit-learn joblib numpy matplotlib flask imblearn seaborn shap"
    ]

    laravel_commands = [
        "composer update",
        "npm install -D tailwindcss postcss autoprefixer",
        "npm install chartjs",
        "npm install chartjs-plugin-datalabels",
        "npm install flowbite",
        "php artisan key:generate",
        "php artisan migrate --force",
        "php artisan user:create-default",
    ]

    # Change directory to the python folder
    os.chdir(model_dir)

    # Run each command
    for command in python_commands:
        print(f"Running command: {command}")
        run_command(command)

    print("Python setup completed successfully.")

    # Change directory to laravel project
    os.chdir(laravel_dir)

    # Copy .env.example to .env
    copy_file('.env.example', '.env')

    # Run each command
    for command in laravel_commands:
        print(f"Running command: {command}")
        run_command(command)

    print("Laravel setup completed successfully.")

if __name__ == "__main__":
    main()
