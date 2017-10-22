import {
	FETCH_SURVEY,
    FETCH_SURVEY_SUCCESS,
    FETCH_SURVEY_FAILURE
} from '../actions/surveys';

const INITIAL_STATE = {
    survey: {
        survey: [],
        error:null,
        loading: false
    }
};

export default function(state = INITIAL_STATE, action) {
  let error;
  switch(action.type) {

    case FETCH_SURVEY:
      return { ...state, activePost:{...state.activePost, loading: true}};
    case FETCH_SURVEY_SUCCESS:
      return { ...state, activePost: {post: action.payload, error:null, loading: false}};
    case FETCH_SURVEY_FAILURE:
      error = action.payload || {message: action.payload.message};
      return { ...state, activePost: {post: null, error:error, loading:false}};
    case RESET_ACTIVE_SURVEY:
      return { ...state, activePost: {post: null, error:null, loading: false}};
      default:
        return state;
    }
}
