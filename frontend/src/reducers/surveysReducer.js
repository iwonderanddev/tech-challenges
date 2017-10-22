import {
	FETCH_SURVEYS,
	FETCH_SURVEYS_SUCCESS,
	FETCH_SURVEYS_FAILURE
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

		case FETCH_SURVEYS:
			return { ...state, surveys:{...state.surveys, loading: true}};
		case FETCH_SURVEYS_SUCCESS:
			return { ...state, surveys: {surveys: action.payload, error:null, loading: false}};
		case FETCH_SURVEYS_FAILURE:
			error = action.payload && action.payload ? action.payload : null;
			return { ...state, surveys: {surveys: null, error:error, loading:false}};
		default:
			return state;
	}
}
