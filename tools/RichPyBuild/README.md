# RichPyBuild

A tool for creating ZIP archivees of folders, configurable to excludes files, folders, or file types.

## Requirements

Requires Python 3.

The following python dependencies are required.

```python
sys
os
zipfile
pathlib
tkinter
json
```

## Basic Usage
From the command line:
```console
python path\to\pybuild.py
```

With no additional arguments supplied a popup window will request an originating directory to archive.

After selecting the originating directory the user will be asked for a location and file name to save the ZIP archive.

## Configuration

Inside the folder needing to be archived should be a  `project.json` file that contains an array like the following example:

```json
{
    "pybuild": {
        "exclude_files" : [
            ".gitattributes",
            ".gitignore"
        ],
        "exclude_extensions" : [
            ".zip"
        ],
        "exclude_folders" : [
            ".git",
            ".github",
            ".vscode",
            "tests"
        ]
    }
}
```

You can have specific files excluded from the archive, specific folders, and specific file types.

## Purpose
**RichPyBuild** serves as an additional custom tool to be submitted against Richard Webster's Innovation Project dissertation for 2022, University of Chester module CO6008.
