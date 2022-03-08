# RichPyBuild

A tool for creating ZIP archives of folders, configurable to excludes files, folders, or file types.

[![License: GPL v3](https://img.shields.io/badge/License-GPLv3-blue.svg)](https://www.gnu.org/licenses/gpl-3.0)

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
python path\to\richpybuild.py
```

With no additional arguments supplied a popup window will request an originating directory to archive.

This directory can also be passed as an argument to skip the request:

```console
python path\to\richpybuild.py path\to\project_folder
```

After selecting the originating directory the user will be asked for a location and file name to save the ZIP archive.

## Configuration

Inside the folder needing to be archived can be placed a  `project.json` file that contains an array like the following example:

```json
{
    "richpybuild": {
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
        ],
        "keep_dir": true
    }
}
```

You can have specific files excluded from the archive, specific folders, and specific file types. This file is not a requirement and without any configuration the ZIP archive will just contain all files/folders from the given directory.

The `"keep_dir"` option means the ZIP archive will have a folder named after the source directory with the files inside it. Default is `true`.

If the folder structure of the source was like this:

```markdown
SourceFolder/
    File1
    File2
    Folder1/
        File3
```

Then the folder structure in the archive for `"keep_dir": true` would be:

```markdown
Archive.zip/
    SourceFolder/
        File1
        File2
        Folder1/
            File3
```

For `"keep_dir": false` the archive folder would be:

```markdown
Archive.zip/
    File1
    File2
    Folder1/
        File3
```

## Purpose
**RichPyBuild** serves as an additional custom tool to be submitted against Richard Webster's Innovation Project dissertation for 2022, University of Chester module CO6008.
