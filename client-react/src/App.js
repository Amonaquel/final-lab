import React, { useState, useEffect } from 'react';
import './App.css';

const API_URL = 'http://localhost:3000';

function App() {
  const [bookmarks, setBookmarks] = useState([]);
  const [title, setTitle] = useState('');
  const [url, setUrl] = useState('');
  const [error, setError] = useState('');

  useEffect(() => {
    fetchAllBookmarks();
  }, []);

  const fetchAllBookmarks = async () => {
    try {
      const response = await fetch(`${API_URL}/api/readAll.php`);
      const data = await response.json();
      if (data && data.length > 0) {
        setBookmarks(data);
      }
    } catch (error) {
      console.error('Error fetching bookmarks:', error);
    }
  };

  const addNewBookmark = async (e) => {
    e.preventDefault();
    if (title && url) {
      try {
        const options = {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ title, link: url })
        };
        await fetch(`${API_URL}/api/create.php`, options);
        setTitle('');
        setUrl('');
        setError('');
        fetchAllBookmarks();
      } catch (error) {
        console.error('Error adding bookmark:', error);
      }
    } else {
      setError('Both title and URL are required.');
    }
  };

  const deleteBookmark = async (id) => {
    try {
      const options = {
        method: 'DELETE',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id })
      };
      await fetch(`${API_URL}/api/delete.php`, options);
      fetchAllBookmarks();
    } catch (error) {
      console.error('Error deleting bookmark:', error);
    }
  };

  return (
    <div className="App">
      <div className="content">
        <h1 className="page-title">The Best Bookmark Website Ever <span>😊</span></h1>
        <form onSubmit={addNewBookmark}>
          <input
            type="text"
            value={title}
            onChange={(e) => setTitle(e.target.value)}
            placeholder="Bookmark title..."
          />
          <input
            type="text"
            value={url}
            onChange={(e) => setUrl(e.target.value)}
            placeholder="Bookmark URL..."
          />
          <button type="submit">Add Bookmark</button>
        </form>
        {error && <p className="errorMessage">{error}</p>}
        <ul className="bookmarkList">
          {bookmarks.map((bookmark) => (
            <li key={bookmark.id}>
              <a href={bookmark.url} target="_blank" rel="noopener noreferrer">
                {bookmark.title}
              </a>
              <span
                className="delete-btn"
                onClick={() => deleteBookmark(bookmark.id)}
                title="Delete"
              >
                X
              </span>
            </li>
          ))}
        </ul>
      </div>
    </div>
  );
}

export default App;
