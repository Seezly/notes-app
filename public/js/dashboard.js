import { formData } from "./utils.js";

const $btnSaveNote = document.getElementById("btn-save-note");
const $btnsEditNote = document.querySelectorAll("[data-action='edit']");
const $btnDeleteAction = document.querySelector("[data-action='delete']");
const $btnDeleteNote = document.querySelectorAll(
    "[commandfor='delete-note-confirm']",
);

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
                    document.getElementById("date").value = new Date(note.date)
                        .toISOString()
                        .slice(0, 10);
                    document.getElementById("body").value = note.body;
                    document.getElementById("priority").value = note.priority;
                    document
                        .getElementById("save-note-form")
                        .querySelector("input[name='_method']").value = "PUT";
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

$btnDeleteNote.forEach((btn) => {
    btn.addEventListener("click", (e) => {
        const noteId = btn.getAttribute("data-id");
        $btnDeleteAction.setAttribute("data-id", noteId);
    });
});

$btnDeleteAction.addEventListener("click", (e) => {
    const noteId = $btnDeleteAction.getAttribute("data-id");

    fetch("/api/notes", {
        method: "DELETE",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({ id: noteId, _method: "DELETE" }),
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
