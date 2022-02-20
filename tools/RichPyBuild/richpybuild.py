import sys
import os
import zipfile
import pathlib
import tkinter.filedialog
import tkinter.simpledialog
import tkinter.messagebox
import json

def zipdir(path, zip, build_file):

    exclude_files = []
    exclude_extensions = []
    exclude_folders = []
    keep_dir = True
    path_join = '..'

    if "exclude_files" in build_file:
        exclude_files = build_file["exclude_files"]
    
    if "exclude_extensions" in build_file:
        exclude_extensions = build_file["exclude_extensions"]

    if "exclude_folders" in build_file:
        exclude_folders = build_file["exclude_folders"]

    if "keep_dir" in build_file:
        keep_dir = bool(build_file["keep_dir"])

    if keep_dir == False:
        path_join = ''

    for root, dirs, files in os.walk(path):
        [dirs.remove(d) for d in list(dirs) if d in exclude_folders]
        [files.remove(f) for f in list(files) if f in exclude_files or pathlib.Path(f).suffix in exclude_extensions]

        for file in files:
            zip.write(
                os.path.join(root, file),
                os.path.relpath(
                    os.path.join(root, file), 
                    os.path.join(path, path_join)
                )
            )

def run(folder = ""):

    project_folder = ""
    file_name = ""

    if folder:
        if not os.path.isdir(folder):
            print("No project folder selected.")
            return
            
        project_folder = folder
    else:
        project_folder = tkinter.filedialog.askdirectory(
            initialdir="/",
            title="Select the project folder"
        )

    
    if project_folder == "":
        print("No project folder selected.")
        return

    file_name = tkinter.filedialog.asksaveasfilename(
        initialdir=project_folder,
        initialfile=os.path.basename(project_folder),
        filetypes=[(".zip file")]
    )
    if file_name == "":
        print("No file name given.")
        return

    build = {}

    project_file_path = project_folder + "/project.json"
    if os.path.exists(project_file_path):
        project_file = open(project_file_path)
        json_file = json.load(project_file)
        if "richpybuild" in json_file:
            build = json_file["richpybuild"]

    zip = zipfile.ZipFile(
        file_name + ".zip",
        "w",
        zipfile.ZIP_DEFLATED
    )
    zipdir(project_folder, zip, build)
    zip.close()

    if os.path.exists(file_name + ".zip"):
        print("Completed successfully")
        tkinter.messagebox.showinfo("Project zip created", "Completed successfully")

if __name__ == '__main__':
    folder = ""
    if len(sys.argv) > 1:
        folder = sys.argv[1]

    run(folder)
