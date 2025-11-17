# Hybrid Drive

The project is built for educational purposes and is open source. It could easily be stolen and the author wouldn't care.

## 1. 🎯 General Product Requirements

* **Product Type:** The product must represent the **server side of an internet resource**.
* **Business Goal:** The product must implement a specific "business idea" presented by the "client" (according to the assignment).
* **Relevance:** The product must be relevant and have **practical value**, as well as meet modern requirements in the field of backend development.

---

## 2. 🛠️ Architectural and Technical Requirements

* **Technology Selection:** You must **select and justify the technologies** and **design patterns** (templates) to be used. The guide mentions techniques such as DDD, Clear Architecture, and MVC.
* **Architecture Design:** A mandatory requirement is **architecture design** of the software product being created.
* **Architecture Justification:** You must describe in detail the application of the selected **architectural pattern** to the architecture development.
* **Implementation:** The software product (server side) must be **implemented (developed) based on the created architecture**.
* **Independence:** The product must be **the result of independent work** (that is, it must be actual developed software, not just a report).

Ultimately, the result of your work should be a "successful and relevant internet resource" (its server side), developed in accordance with best practices.

---

# Project: HybridDrive (File Sharing Server Application)

**Concept:** Self-hosted file storage and sharing service, with a special focus on supporting **user-generated game content** (models, assets, screenshots).

**Architecture:**
* **Web Server / Reverse Proxy:** Nginx
* **Application Server (Business Logic):** Apache + PHP
* **Database (Metadata, Users):** PostgreSQL
* **Platform:** Docker (modular architecture)

## Detailed List of Tasks:

Based on your description and the manager's suggestion, the product tasks can be detailed as follows:

### 1. **System Core Implementation (Back-end):**
* **Authentication:** Create a user registration and login system (login/password).
* **File API:** Develop methods for securely uploading, downloading, and deleting files. Files in the system should be associated with a specific user.
* **Directory Structure:** Implement logic for storing file metadata and folder structure in a PostgreSQL database.

### 2. **Basic Web Interface (Front-end):**
* Create a minimalist interface that allows the user to:
* Log in to their account.
* View a list of their files and folders.
* Upload new files.
* Download or delete existing files.
* Create public links for sharing files (as in the screenshot example).

### 3. **Implementation of a 3D Model Viewer (Key Feature):**
* Integrate a specialized viewer (a library such as three.js or similar) into the web interface.
* Provide rendering (viewing) of 3D models directly in the browser without downloading.
* Implement support for the main formats specified by the manager:
* .gltf**
* .fbx**
* .obj**
* The user should be able to rotate the model to view it in preview mode.