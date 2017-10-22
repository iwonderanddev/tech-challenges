import axios from 'axios';

//SURVEY list
export const FETCH_SURVEYS = 'FETCH_SURVEYS';
export const FETCH_SURVEYS_SUCCESS = 'FETCH_SURVEYS_SUCCESS';
export const FETCH_SURVEYS_FAILURE = 'FETCH_SURVEYS_FAILURE';
export const RESET_SURVEYS = 'RESET_SURVEYS';

//Fetch SURVEY
export const FETCH_SURVEY = 'FETCH_SURVEY';
export const FETCH_SURVEY_SUCCESS = 'FETCH_SURVEY_SUCCESS';
export const FETCH_SURVEY_FAILURE = 'FETCH_SURVEY_FAILURE';
export const RESET_ACTIVE_SURVEY = 'RESET_ACTIVE_SURVEY';

const ROOT_URL = 'http://localhost:8080/api';

export function fetchSurveys() {
    const request = axios({
        method: 'get',
        url: `${ROOT_URL}/surveys`,
        headers: []
    });

    return {
        type: FETCH_SURVEYS,
        payload: request
    };
}

export function fetchSurveysSuccess(response) {
    return {
        type: FETCH_SURVEYS_SUCCESS,
        payload: response
    };
}

export function fetchSurveysFailure(error) {
    return {
        type: FETCH_SURVEYS_FAILURE,
        payload: error
    };
}

export function fetchSurvey(id) {
    const request = axios.get(`${ROOT_URL}/surveys/${id}`);

    return {
        type: FETCH_SURVEY,
        payload: request
    };
}


export function fetchSurveySuccess(activeSurvey) {
    return {
        type: FETCH_SURVEY_SUCCESS,
        payload: activeSurvey
    };
}

export function fetchSurveyFailure(error) {
    return {
        type: FETCH_SURVEY_FAILURE,
        payload: error
    };
}
