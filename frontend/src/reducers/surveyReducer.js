import {
	FETCH_SURVEYS,
    FETCH_SURVEYS_SUCCESS,
    FETCH_SURVEYS_FAILURE,
} from '../actions/surveys';

const INITIAL_STATE = {
    surveys: {
        surveys: [],
        error:null,
        loading: true
    }
};

export default function(state = INITIAL_STATE, action) {
  let error;
  switch(action.type) {

  case FETCH_SURVEYS: // start fetching surveys
  	return { ...state, surveysList: {surveys:[], error: null, loading: true} };
  case FETCH_SURVEYS_SUCCESS:
    return { ...state, surveysList: {surveys: action.payload, error:null, loading: false} };
  case FETCH_SURVEYS_FAILURE:
  	console.log('pay',action.payload);
    error = action.payload;
    return { ...state, surveysList: {surveys: [], error: error, loading: false} };
  default:
    return state;
  }
}
