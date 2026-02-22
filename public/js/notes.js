import { formData, getTags } from "./utils.js";

const $btnSaveNote = document.getElementById("btn-save-note");
const $btnsEditNote = document.querySelectorAll("[data-action='edit']");
const $btnDeleteAction = document.querySelector("[data-action='delete']");
const $btnDeleteNote = document.querySelectorAll(
    "[commandfor='delete-note-confirm']",
);
const $btnRestoreNotes = document.querySelectorAll(
    "[commandfor='restore-note-confirm']",
);

const $formSearch = document.getElementById("search");
const $formFilterTag = document.getElementById("filter_tag");
const $formFilterPriority = document.getElementById("filter_priority");

const $tagFilter = document.getElementById("tag_f");
const $tagSelect = document.getElementById("note_tag");

const $priorityFilter = document.getElementById("priority_f");

const filters = new URLSearchParams(window.location.search);

document.getElementById("save-note-form").addEventListener("submit", (e) => {
    e.preventDefault();

    $btnSaveNote.click();
});

if ($btnSaveNote) {
    $btnSaveNote.addEventListener("click", (e) => {
        let data = formData(document.getElementById("save-note-form"));

        if ($btnSaveNote.dataset.action === "edit") {
            data.id = $btnSaveNote.dataset.id;

            fetch("/api/notes", {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(data),
            })
                .then((res) => res.json())
                .then((data) => {
                    if (data.success) {
                        window.location.reload();
                    }
                })
                .catch((err) => {
                    console.error(err);
                });
            return;
        }

        fetch("/api/notes", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(data),
        })
            .then((res) => res.json())
            .then((data) => {
                if (data.success) {
                    window.location.reload();
                }
            })
            .catch((err) => {
                console.error(err);
            });
    });
}

if ($btnsEditNote) {
    $btnsEditNote.forEach((btn) => {
        btn.addEventListener("click", (e) => {
            const noteId = btn.getAttribute("data-id");
            let note;
            // Call get note from API and save it in variable

            fetch(`/api/notes?id=${noteId}`)
                .then((res) => res.json())
                .then((data) => {
                    if (data.success) {
                        // Open edit note modal and fill the form with the note data
                        note = data.data;

                        document.getElementById("dialog-title").textContent =
                            "Edit Note";
                        document.getElementById("name").value = note.name;
                        document.getElementById("date").value = new Date(
                            note.date,
                        )
                            .toISOString()
                            .slice(0, 10);
                        document.getElementById("body").value = note.body;
                        document.getElementById("note_tag").value = note.tag_id;
                        document.getElementById("priority").value =
                            note.priority;
                        document
                            .getElementById("save-note-form")
                            .querySelector("input[name='_method']").value =
                            "PUT";
                        $btnSaveNote.textContent = "Update";
                        $btnSaveNote.dataset.action = "edit";
                        $btnSaveNote.dataset.id = note.id;
                    }
                })
                .catch((err) => {
                    console.error(err);
                });
        });
    });
}

if ($btnDeleteNote) {
    $btnDeleteNote.forEach((btn) => {
        btn.addEventListener("click", (e) => {
            const noteId = btn.getAttribute("data-id");
            $btnDeleteAction.setAttribute("data-id", noteId);
        });
    });
}

if ($btnDeleteAction) {
    $btnDeleteAction.addEventListener("click", (e) => {
        const noteId = $btnDeleteAction.getAttribute("data-id");
        const tagToken = $btnDeleteAction.getAttribute("data-token");

        fetch("/api/notes", {
            method: "DELETE",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                id: noteId,
                csrf_token: tagToken,
                _method: "DELETE",
            }),
        })
            .then((res) => res.json())
            .then((data) => {
                if (data.success) {
                    window.location.reload();
                }
            })
            .catch((err) => {
                console.error(err);
            });
    });
}

if ($btnRestoreNotes) {
    $btnRestoreNotes.forEach(($btn) => {
        $btn.addEventListener("click", (e) => {
            const id = $btn.dataset.id;
            const token = $btn.dataset.token;

            fetch("/api/notes", {
                method: "PATCH",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    id: id,
                    csrf_token: token,
                    _method: "PATCH",
                }),
            })
                .then((res) => res.json())
                .then((data) => {
                    if (data.success) {
                        window.location.reload();
                    }
                });
        });
    });
}

if ($formFilterTag) {
    // init tags filter with tags
    getTags().then((tags) => {
        tags.forEach((tag) => {
            let option1 = document.createElement("option");
            option1.value = tag.id;
            option1.textContent = tag.name;
            $tagFilter.append(option1);

            let option2 = document.createElement("option");
            option2.value = tag.id;
            option2.textContent = tag.name;
            $tagSelect.append(option2);
        });
    });

    if (filters.has("tag_f")) {
        $formFilterTag.value = filters.get("tag_f");
    }

    // Handle select changes
    $formFilterTag.addEventListener("change", (e) => {
        // pass query params
        //reload the page maintaining other query params
        if (filters.size < 1) {
            window.location.href =
                window.location.href + `?tag_f=${$tagFilter.value}`;
        }

        if (!filters.has("tag_f") && filters.size > 0) {
            window.location.href =
                window.location.href + `&tag_f=${$tagFilter.value}`;
        }

        if (filters.has("tag_f")) {
            window.location.href = window.location.href.replace(
                /tag_f=\d+/,
                `tag_f=${$tagFilter.value}`,
            );
        }
    });
}

if ($formFilterPriority) {
    if (filters.has("priority_f")) {
        $formFilterPriority.value = filters.get("priority_f");
    }

    // Handle select changes
    $formFilterPriority.addEventListener("change", (e) => {
        // pass query params
        //reload the page maintaining other query params
        if (filters.size < 1) {
            window.location.href =
                window.location.href + `?priority_f=${$priorityFilter.value}`;
        }

        if (!filters.has("priority_f") && filters.size > 0) {
            window.location.href =
                window.location.href + `&priority_f=${$priorityFilter.value}`;
        }

        if (filters.has("priority_f")) {
            window.location.href = window.location.href.replace(
                /priority_f=\w+/,
                `priority_f=${$priorityFilter.value}`,
            );
        }
    });
}
