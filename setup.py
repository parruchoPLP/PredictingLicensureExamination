import os
import subprocess
import sys

def run_command(command):
    result = subprocess.run(command, shell=True)
    if result.returncode != 0:
        sys.exit(f"Error: Command '{command}' failed")

def main():
    model_dir = "/ThesisPredictiveModel"
    laravel_dir = "/Thesis"
    venv_dir = os.path.join(model_dir, "venv")

    # Create virtual environment if it doesn't exist
    if not os.path.exists(venv_dir):
        print("Creating virtual environment...")
        run_command(f"python -m venv {venv_dir}")

    # Activate virtual environment
    activate_script = os.path.join(venv_dir, "Scripts", "activate") if os.name == "nt" else os.path.join(venv_dir, "bin", "activate")
    print(f"Activating virtual environment: {activate_script}")
    activate_command = f"source {activate_script}" if os.name != "nt" else activate_script

    # Define the commands to run
    python_commands = [
        f"{activate_command} && pip install -r requirements.txt",
    ]

    laravel_commands = [
        "composer update",
        "npm install -D tailwindcss postcss autoprefixer",
        "npm install chartjs",
        "npm install chartjs-plugin-datalabels",
        "npm install flowbite",
        "cp .env.example .env",
        "php artisan key:generate"

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

    # Run each command

    for command in laravel_commands:
        print(f"Running command: {command}")
        run_command(command)

    print("Laravel setup completed successfully.")
    
if __name__ == "__main__":
    main()
