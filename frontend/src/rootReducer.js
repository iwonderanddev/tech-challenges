import { combineReducers } from 'redux'
import { routerReducer } from 'react-router-redux'
import surveysReducer from './reducers/surveysReducer'
import surveyReducer from './reducers/surveyReducer'

export default combineReducers({
    routing: routerReducer,
    surveys: surveysReducer,
    survey : surveyReducer

})
