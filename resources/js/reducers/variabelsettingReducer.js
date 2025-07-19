// ! Copyright @
// ! PT. Solusi Psikologi Banten
// ! Syafiq Marzuki
// ! Syahri Ramadhan Wiraasmara (ARI)
import {
    FETCH_VARIABELS,
    ADD_VARIABEL,
    UPDATE_VARIABEL,
    DELETE_VARIABEL
} from '../actions/variabelsettingActions';

const initialState = {
    variabels: [],
};

const variabelsettingReducer = (state = initialState, action) => {
  switch (action.type) {
    case FETCH_VARIABELS:
      return { ...state, variabels: action.payload };
    case ADD_VARIABEL:
      return { ...state, variabels: [...state.variabels, action.payload] };
    case UPDATE_VARIABEL:
      return {
        ...state,
        variabels: state.variabels.map(variabel =>
          variabel.id === action.payload.id ? action.payload : variabel
        ),
      };
    case DELETE_VARIABEL:
      return {
        ...state,
        variabels: state.variabels.filter(variabel => variabel.id !== action.payload),
      };
    default:
      return state;
  }
};

export default variabelsettingReducer;