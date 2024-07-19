# Base image from Ollama
FROM ollama/ollama:latest

# Install necessary tools
RUN apt-get update && apt-get install -y \
    curl \
    jq \
    && rm -rf /var/lib/apt/lists/*

# Install Python and required libraries
RUN apt-get update && apt-get install -y python3 python3-pip
COPY requirements.txt .
RUN pip3 install -r requirements.txt

# Copy your application into the container
COPY . /app
WORKDIR /app

# Expose the port
EXPOSE 11434

# Command to run
CMD ["python3", "main.py"]
