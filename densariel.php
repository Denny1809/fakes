from google.colab import drive
drive.mount('/content/drive')


import os

source = "/content/drive/MyDrive/DeepFake/deddy.png" # @param {type:"string"}
target = "/content/drive/MyDrive/DeepFake/575p4d.mp4" # @param {type:"string"}

def create_output_path(source, target):
    # Extract the file names from the paths
    source_filename = source.split("/")[-1].split(".")[0]
    target_filename = target.split("/")[-1].split(".")[0]

    # Extract the folder path from the target
    target_folder = "/".join(target.split("/")[:-1])

    # Create the output path by combining the target folder, target filename, and source filename
    output_filename = f"{target_filename}-{source_filename}.mp4"
    output_path = f"{target_folder}/{output_filename}"

    return output_path

output = create_output_path(source, target)
print(output)

!git clone https://github.com/s0md3v/roop
%cd roop
!pip install onnxruntime-gpu && pip install -r requirements.txt
!wget https://civitai.com/api/download/models/85159 -O inswapper_128.onnx

command = f"python run.py -s '{source}' -t '{target}' -o '{output}' --keep-frames --keep-fps --output-video-quality 18 --execution-provider cuda --frame-processor face_swapper face_enhancer"

!{command}

!python run.py -h