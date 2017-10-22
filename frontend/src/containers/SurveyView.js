import React from 'react'

import Survey from '../components/Survey'

export const SurveyView = ({match}) => {
    const {id} = match.params;
    return (
    <div>
    <h1>Survey {id}</h1>
    <Survey id={id} />
    </div>
    )
}
