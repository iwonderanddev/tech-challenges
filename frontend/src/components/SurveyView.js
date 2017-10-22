import React from 'react'
import { push } from 'react-router-redux'
import { bindActionCreators } from 'redux'
import { connect } from 'react-redux'

export const SurveyView = ({match}) => {
    const {id} = match.params;
    return (
    <div>
    <h1>Survey {id}</h1>
    <p>TODO</p>
    </div>
    )
}
