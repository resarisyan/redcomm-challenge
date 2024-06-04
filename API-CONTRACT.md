# API CONTRACT

## Notes API
The Notes API provides endpoints for managing notes in the application. The API supports the following operations:

- Create a new note
- Get a list of all notes with pagination and search
- Get a single note by ID
- Update a note
- Delete a note

### Base URL
The base URL for the Notes API is `/api/v1/notes`.

### Endpoints

#### Create a New Note
- **URL**: `/api/v1/notes`
- **Method**: `POST`
- **Request Body**:
    ```json
    {
        "title": "string",
        "description": "string"
    }
    ```
- **Response**:
    - **Status Code**: `201 Created`
    - **Body**:
        ```json
        {
            "status": "success",
            "message": "Note created successfully",
            "data": {
                "id": "integer",
                "title": "string",
                "desc": "string",
                "created_at": "datetime",
                "updated_at": "datetime"
            }
        }
        ```

#### Get All Notes
- **URL**: `/api/v1/notes`
- **Method**: `GET`
- **Parameters**:
    - `page` (optional): The page number for pagination (default: 1)
    - `search` (optional): Search query to filter notes by title or description
- **Response**:
    - **Status Code**: `200 OK`
    - **Body**:
        ```json
        {
            "status": "success",
            "message": "Notes retrieved successfully",
            "data":{
                "current_page": "integer",
                "data": [
                    {
                        "id": "integer",
                        "title": "string",
                        "desc": "string",
                        "created_at": "datetime",
                        "updated_at": "datetime"
                    },
                    ...
                ],
                "first_page_url": "string",
                "from": "integer",
                "last_page": "integer",
                "last_page_url": "string",
                "links": [
                    {
                        "url": "string",
                        "label": "string",
                        "active": "boolean"
                    },
                    ...
                ],
                "next_page_url": "string",
                "path": "string",
                "per_page": "integer",
                "prev_page_url": "string",
                "to": "integer",
                "total": "integer"
            }
        }
        ```

#### Get a Single Note
- **URL**: `/api/v1/notes/{id}`
- **Method**: `GET`
- **Response**:
    - **Status Code**: `200 OK`
    - **Body**:
        ```json
        {
            "status": "success",
            "message": "Note retrieved successfully",
            "data": {
                "id": "integer",
                "title": "string",
                "desc": "string",
                "created_at": "datetime",
                "updated_at": "datetime"
            }
        }
        ```

#### Update a Note
- **URL**: `/api/v1/notes/{id}`
- **Method**: `PUT`
- **Request Body**:
    ```json
    {
        "title": "string",
        "description": "string"
    }
    ```
- **Response**:
    - **Status Code**: `200 OK`
    - **Body**:
        ```json
        {
            "status": "success",
            "message": "Note updated successfully",
            "data": {
                "id": "integer",
                "title": "string",
                "desc": "string",
                "created_at": "datetime",
                "updated_at": "datetime"
            }
        }
        ```

#### Delete a Note
- **URL**: `/api/v1/notes/{id}`
- **Method**: `DELETE`
- **Response**:
    - **Status Code**: `200 OK`
    - **Body**:
        ```json
        {
            "status": "success",
            "message": "Note deleted successfully"
        }
        ```

### Error Responses
The API returns the following error responses:

- **400 Bad Request**: Invalid request data
- **404 Not Found**: Resource not found
- **500 Internal Server Error**: Server error