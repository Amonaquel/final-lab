const apiUrl = 'http://localhost:3000/api';

const bookmarkListElem = document.getElementById("bookmarkList");
document.getElementById("add-btn").addEventListener("click", addNewBookmark);

document.body.onload = function () {
  fetchAllBookmarks().catch(console.error);
};

async function fetchAllBookmarks() {
  const response = await fetch(`${apiUrl}/readAll.php`);
  const bookmarks = await response.json();
  if (bookmarks && bookmarks.length > 0) {
    bookmarks.forEach(addItem);
  }
}

async function addNewBookmark() {
  const title = document.getElementById("bookmark-title").value.trim();
  const url = document.getElementById("bookmark-url").value.trim();

  if (title && url) {
    const options = {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ title, link: url })
    };
    await fetch(`${apiUrl}/create.php`, options);
    location.reload();
  } else {
    document.getElementById("errorMessage").textContent = "Both title and URL are required.";
  }
}

async function deleteBookmark(e) {
  const data = { id: this.id };
  const options = {
    method: 'DELETE',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
  };

  await fetch(`${apiUrl}/delete.php`, options);
  location.reload();
}

function addItem(item) {
  const li = document.createElement("li");
  const link = document.createElement("a");
  link.href = item.url;
  link.textContent = item.title;
  link.target = "_blank";

  const spanDelete = document.createElement("span");
  spanDelete.textContent = "X";
  spanDelete.title = "Delete";
  spanDelete.id = item.id;
  spanDelete.addEventListener("click", deleteBookmark);

  li.appendChild(link);
  li.appendChild(document.createTextNode(" "));
  li.appendChild(spanDelete);
  bookmarkListElem.appendChild(li);
}
