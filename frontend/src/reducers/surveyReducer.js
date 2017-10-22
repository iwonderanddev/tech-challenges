import {
	FETCH_SURVEYS,
    FETCH_SURVEYS_SUCCESS,
    FETCH_SURVEYS_FAILURE,
} from '../actions/surveys';

const INITIAL_STATE = {
    surveys: {
        surveys: [],
        error:null,
        loading: false
    }
};

export default function(state = INITIAL_STATE, action) {
  let error;
  switch(action.type) {

  case FETCH_SURVEYS: // start fetching surveys
  	return { ...state, postsList: {posts:[], error: null, loading: true} };
  case FETCH_SURVEYS_SUCCESS:
    return { ...state, postsList: {posts: action.payload, error:null, loading: false} };
  case FETCH_SURVEYS_FAILURE:
    error = action.payload || {message: action.payload.message};
    return { ...state, postsList: {posts: [], error: error, loading: false} };
  default:
    return state;
  }
}
