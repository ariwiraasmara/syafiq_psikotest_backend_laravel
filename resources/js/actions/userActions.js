// ! Copyright @
// ! Syafiq
// ! Syahri Ramadhan Wiraasmara (ARI)
export const FETCH_USERS = 'FETCH_USERS';
export const ADD_USER = 'ADD_USER';
export const UPDATE_USER = 'UPDATE_USER';

export const fetchUsers = () => async dispatch => {
  try {
    const response = await fetch('/api/users');
    const data = await response.json();
    dispatch({ type: FETCH_USERS, payload: data });
  } catch (error) {
    console.error('Error fetching users:', error);
  }
};

export const addUser = (user) => async dispatch => {
  try {
    const response = await fetch('/api/users', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(user),
    });
    const data = await response.json();
    dispatch({ type: ADD_USER, payload: data });
  } catch (error) {
    console.error('Error adding user:', error);
  }
};

export const updateUser = (id, user) => async dispatch => {
  try {
    const response = await fetch(`/api/users/${id}`, {
      method: 'PUT',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(user),
    });
    const data = await response.json();
    dispatch({ type: UPDATE_USER, payload: data });
  } catch (error) {
    console.error('Error updating user:', error);
  }
};