import { formData } from "./utils.js";

const $btnSaveTag = document.getElementById("btn-save-tag");
const $btnsEditTag = document.querySelectorAll("[data-action='edit']");
const $btnDeleteAction = document.querySelector("[data-action='delete']");
const $btnDeleteTag = document.querySelectorAll(
	"[commandfor='delete-tag-confirm']",
);

const $btnRestoreTags = document.querySelectorAll(
	"[commandfor='restore-tag-confirm']",
);
const $btnRestoreAction = document.querySelector("[data-action='Restore']");

document.getElementById("save-tag-form").addEventListener("submit", (e) => {
	e.preventDefault();

	$btnSaveTag.click();
});

if ($btnSaveTag) {
	$btnSaveTag.addEventListener("click", (e) => {
		let data = formData(document.getElementById("save-tag-form"));

		if ($btnSaveTag.dataset.action === "edit") {
			data.id = $btnSaveTag.dataset.id;

			fetch("/api/tags", {
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

		fetch("/api/tags", {
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

if ($btnsEditTag) {
	$btnsEditTag.forEach((btn) => {
		btn.addEventListener("click", (e) => {
			const tagId = btn.getAttribute("data-id");
			let tag;

			fetch(`/api/tags?id=${tagId}`)
				.then((res) => res.json())
				.then((data) => {
					if (data.success) {
						tag = data.data;

						document.getElementById("dialog-title").textContent =
							"Edit Tag";
						document.getElementById("name").value = tag.name;
						$btnSaveTag.textContent = "Update";
						$btnSaveTag.dataset.action = "edit";
						$btnSaveTag.dataset.id = tag.id;
					}
				})
				.catch((err) => {
					console.error(err);
				});
		});
	});
}

if ($btnDeleteTag) {
	$btnDeleteTag.forEach((btn) => {
		btn.addEventListener("click", (e) => {
			const tagId = btn.getAttribute("data-id");
			$btnDeleteAction.setAttribute("data-id", tagId);
		});
	});
}

if ($btnDeleteAction) {
	$btnDeleteAction.addEventListener("click", (e) => {
		const tagId = $btnDeleteAction.getAttribute("data-id");
		const tagToken = $btnDeleteAction.getAttribute("data-token");

		fetch("/api/tags", {
			method: "DELETE",
			headers: {
				"Content-Type": "application/json",
			},
			body: JSON.stringify({
				id: tagId,
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

if ($btnRestoreTags) {
	$btnRestoreTags.forEach((btn) => {
		btn.addEventListener("click", (e) => {
			const noteId = btn.getAttribute("data-id");
			$btnRestoreAction.setAttribute("data-id", noteId);
		});
	});
}

if ($btnRestoreAction) {
	$btnRestoreAction.addEventListener("click", (e) => {
		const id = $btnRestoreAction.dataset.id;
		const token = $btnRestoreAction.dataset.token;

		fetch("/api/tags", {
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
}
