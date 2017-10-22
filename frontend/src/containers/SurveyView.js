import React from 'react'

export const SurveyView = ({match}) => {
    const {id} = match.params;
    return (
    <div>
    <h1>Survey {id}</h1>
    <p>TODO</p>
    </div>
    )
}
