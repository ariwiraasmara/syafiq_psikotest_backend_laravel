// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
export const FETCH_VARIABELS = 'FETCH_VARIABELS';
export const ADD_VARIABEL = 'ADD_VARIABEL';
export const UPDATE_VARIABEL = 'UPDATE_VARIABEL';
export const DELETE_VARIABEL = 'DELETE_VARIABEL';

export const fetchVariabels = () => async dispatch => {
  try {
    const response = await fetch('/api/variabels');
    const data = await response.json();
    dispatch({ type: FETCH_VARIABELS, payload: data });
  } catch (error) {
    console.error('Error fetching variabels:', error);
  }
};

export const addVariabel = (variabel) => async dispatch => {
  try {
    const response = await fetch('/api/variabels', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(variabel),
    });
    const data = await response.json();
    dispatch({ type: ADD_VARIABEL, payload: data });
  } catch (error) {
    console.error('Error adding variabel:', error);
  }
};

export const updateVariabel = (id, variabel) => async dispatch => {
  try {
    const response = await fetch(`/api/variabels/${id}`, {
      method: 'PUT',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(variabel),
    });
    const data = await response.json();
    dispatch({ type: UPDATE_VARIABEL, payload: data });
  } catch (error) {
    console.error('Error updating variabel:', error);
  }
};

export const deleteVariabel = (id) => async dispatch => {
  try {
    await fetch(`/api/variabels/${id}`, {
      method: 'DELETE',
    });
    dispatch({ type: DELETE_VARIABEL, payload: id });
  } catch (error) {
    console.error('Error deleting variabel:', error);
  }
};