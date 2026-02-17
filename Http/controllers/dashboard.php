<?php

use Http\Models\Note;

$notes = json_decode(Note::get($connection), true)['data'] ?? [];

return view('dashboard', [
    'title' => 'Dashboard',
    'notes' => $notes
]);
