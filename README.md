# Hybrid Drive

The project is built for educational purposes and is open source. It could easily be stolen and the author wouldn't care.

# Project: HybridDrive (File Sharing Server Application)

**Concept:** Self-hosted file storage and sharing service, with a special focus on supporting user-generated content

**Architecture:**
* **Web Server / Reverse Proxy:** Nginx
* **Application Server (Business Logic):** Apache + PHP
* **Database (Metadata, Users):** PostgreSQL
* **Platform:** Docker (modular architecture)

## Details:

### 1. **System Core Implementation (Back-end):**
* **Authentication:** Create a user registration and login system (login/password).
* **File API:** Develop methods for securely uploading, downloading, and deleting files. Files in the system are associated with a specific user.
* **Directory Structure:** Implement logic for storing file metadata and folder structure in a PostgreSQL database.

### 2. **Basic Web Interface (Front-end):**
* Create a minimalist interface that allows the user to:
* Log in to their account.
* View a list of their files and folders.
* Upload new files.
* Download or delete existing files.
* Create public links for sharing files (as in the screenshot example).

### 3. **Implementation of a 3D Model Viewer:**
*this sub-paragraph is relevant for client part*
* Integrate a specialized viewer (a library such as three.js or similar) into the web interface.
* Provide rendering (viewing) of 3D models directly in the browser without downloading.
* Implement support for the main formats specified by the manager:
* .gltf**
* .fbx**
* .obj**

### 4. **Android Mobile Application**

[Hybrid Drive android application](https://github.com/raaveinm/HybridDrive_Android)