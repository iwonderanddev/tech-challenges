import React, { Component } from 'react';
import { connect } from 'react-redux'
import * as surveysActions from '../actions/surveys';


class SurveysList extends Component {
    componentWillMount() {
        const {fetchSurveys} = this.props;
        fetchSurveys();
    }

    renderSurveys(surveys) {
        return surveys.map((survey) => {
            return (
                <li className="list-group-item" key={survey._id}>
                    {{survey}}
                </li>
            );
        });
    }

    render() {
        const { surveys, loading, error } = this.props.surveys;
console.log(surveys, error,loading);
        if(loading) {
            return(
            <div className="container">
                <h1>Surveys</h1>
                <h3>Loading...</h3>
            </div>
            )
        } else if(error) {
            return <div className="alert alert-danger">Error: {error.message}</div>
        }

        return (
            <div className="container">
                <h1>Surveys</h1>
                <ul className="list-group">
                    {this.renderSurveys(surveys)}
                </ul>
            </div>
        );
    }
}

const mapStateToProps = (state) => {
    return {
        surveys: state.surveys.surveys,
        error: state.surveys.error,
        loading: state.surveys.loading

    };
}

const mapDispatchToProps = (dispatch) => {
    return {
        fetchSurveys: () => {
            const request = dispatch(surveysActions.fetchSurveys());
            request.payload.then((response) => {
                console.log('resp',response);
                dispatch(surveysActions.fetchSurveysSuccess(response.payload.data))
            }).catch((err)=>{
                dispatch(surveysActions.fetchSurveysFailure(err))
            })
        }
    }
}

export default connect(mapStateToProps, mapDispatchToProps)(SurveysList);
