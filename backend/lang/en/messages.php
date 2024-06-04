<?php
$data = [
    'create_success' => function ($value) {
        return "Data $value created successfully";
    },
    'update_success' => function ($value) {
        return "Data $value updated successfully";
    },
    'delete_success' => function ($value) {
        return "Data $value deleted successfully";
    },
    'get_success' => function ($value) {
        return "Data $value retrieved successfully";
    },
    'status_change_success' => function ($value) {
        return "Data $value status changed successfully";
    },
    'not_found' => function ($value) {
        return "Data $value not found";
    },
];

return [
    'internal_server_error' => 'Internal server error',

    'create_note_api_success' => $data['create_success']('note'),
    'update_note_api_success' => $data['update_success']('note'),
    'delete_note_api_success' => $data['delete_success']('note'),
    'get_note_api_success' => $data['get_success']('note'),
    'note_not_found' => $data['not_found']('note'),
];
