# API Documentation

This document provides details on the API endpoints for the HybridDrive application.

---

## User Registration

**Endpoint:** `/api/register.php`

**Method:** `POST`

**Description:** Registers a new user in the system.

**Request Body:**

```json
{
  "username": "your_username",
  "password": "your_password"
}
```

**Parameters:**

*   `username` (string, required): The desired username for the new account.
*   `password` (string, required): The desired password for the new account.

**Responses:**

*   **201 Created:** User was successfully registered.
    ```json
    {
      "message": "User was successfully registered."
    }
    ```
*   **400 Bad Request:** The `username` or `password` was not provided.
    ```json
    {
      "message": "Username and password are required."
    }
    ```
*   **500 Internal Server Error:** An error occurred while attempting to register the user.
    ```json
    {
      "message": "Unable to register the user."
    }
    ```

---

## User Login

**Endpoint:** `/api/login.php`

**Method:** `POST`

**Description:** Authenticates a user and starts a session.

**Request Body:**

```json
{
  "username": "your_username",
  "password": "your_password"
}
```

**Parameters:**

*   `username` (string, required): The user's username.
*   `password` (string, required): The user's password.

**Responses:**

*   **200 OK:** Successfully logged in.
    ```json
    {
      "message": "Successfully logged in."
    }
    ```
*   **400 Bad Request:** The `username` or `password` was not provided.
    ```json
    {
      "message": "Username and password are required."
    }
    ```
*   **401 Unauthorized:** Login failed due to incorrect credentials.
    ```json
    {
      "message": "Login failed."
    }
    ```

---

## User Logout

**Endpoint:** `/api/logout.php`

**Method:** `GET`

**Description:** Destroys the current session and logs the user out.

**Responses:**

*   **302 Found:** Redirects the user to the login page (`/index.php`).

---

## Get Files

**Endpoint:** `/api/get_files.php`

**Method:** `GET`

**Description:** Retrieves a list of files for the currently logged-in user.

**Responses:**

*   **200 OK:** An array of file objects.
    ```json
    [
      {
        "id": "1",
        "name": "document.pdf",
        "size": "1024",
        "type": "application/pdf",
        "created_at": "2025-11-28 12:00:00"
      }
    ]
    ```
*   **401 Unauthorized:** The user is not logged in.
    ```json
    {
      "message": "You must be logged in to view files."
    }
    ```

---

## Upload File

**Endpoint:** `/api/upload.php`

**Method:** `POST`

**Description:** Uploads a file to the user's storage.

**Request Body:** `multipart/form-data`

**Parameters:**

*   `file` (file, required): The file to upload.

**Responses:**

*   **201 Created:** File was successfully uploaded.
    ```json
    {
      "message": "File was successfully uploaded."
    }
    ```
*   **400 Bad Request:** No file was uploaded.
    ```json
    {
      "message": "No file was uploaded."
    }
    ```
*   **401 Unauthorized:** The user is not logged in.
    ```json
    {
      "message": "You must be logged in to upload files."
    }
    ```
*   **500 Internal Server Error:** An error occurred while uploading the file or saving its information.
    ```json
    {
      "message": "Unable to upload the file."
    }
    ```

---

## Download File

**Endpoint:** `/api/download.php`

**Method:** `GET`

**Description:** Downloads a specific file.

**Query Parameters:**

*   `file_id` (integer, required): The ID of the file to download.

**Responses:**

*   **200 OK:** The file is sent as an attachment.
*   **400 Bad Request:** The `file_id` is not provided.
*   **401 Unauthorized:** The user is not logged in.
*   **404 Not Found:** The file was not found or the user does not have permission to access it.

---

## Delete File

**Endpoint:** `/api/delete.php`

**Method:** `GET`

**Description:** Deletes a specific file.

**Query Parameters:**

*   `file_id` (integer, required): The ID of the file to delete.

**Responses:**

*   **200 OK:** File was successfully deleted.
    ```json
    {
      "message": "File was successfully deleted."
    }
    ```
*   **400 Bad Request:** The `file_id` is not provided.
    ```json
    {
      "message": "File ID is required."
    }
    ```
*   **401 Unauthorized:** The user is not logged in.
    ```json
    {
      "message": "You must be logged in to delete files."
    }
    ```
*   **404 Not Found:** The file was not found or the user does not have permission to delete it.
    ```json
    {
      "message": "File not found or you don't have permission to delete it."
    }
    ```
*   **500 Internal Server Error:** An error occurred while deleting the file.
    ```json
    {
      "message": "Unable to delete file from the database."
    }
    ```
