import React from 'react'

import Survey from '../../components/Survey/Survey'
import ('./surveyView.css');

export const SurveyView = ({match}) => {
    const {id} = match.params;
    return (
    <div className="survey-view">
        <h1>Survey {id}</h1>
        <Survey id={id} />
    </div>
    )
}
