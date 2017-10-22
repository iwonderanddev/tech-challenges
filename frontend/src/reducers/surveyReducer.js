import {
	FETCH_SURVEY,
	FETCH_SURVEY_SUCCESS,
	FETCH_SURVEY_FAILURE,
} from '../actions/surveys';

const INITIAL_STATE = {
	survey: {
		survey: [],
		error:null,
		loading: true
	}
};

export default function(state = INITIAL_STATE, action) {
	let error;
	switch(action.type) {

		case FETCH_SURVEY: // start fetching surveys
			return { ...state, survey: {survey:[], error: null, loading: true} };
		case FETCH_SURVEY_SUCCESS:
			return { ...state, survey: {survey: action.payload, error:null, loading: false} };
		case FETCH_SURVEY_FAILURE:
			error = action.payload;
		return { ...state, survey: {survey: [], error: error, loading: false} };
			default:
			return state;
	}
}
