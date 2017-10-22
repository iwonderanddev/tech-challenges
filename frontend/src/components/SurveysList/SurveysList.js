import React, { Component } from 'react';
import { connect } from 'react-redux'
import { Link } from 'react-router-dom';
import * as surveysActions from '../../actions/surveys';
import { Icon, Spin, Button } from 'antd';

require('./surveysList.css');
class SurveysList extends Component {
    componentWillMount() {
        const {fetchSurveys} = this.props;
        fetchSurveys();
    }

    renderSurveys(surveys) {
        return surveys.map((survey,index) => {
            return (
                <li className="list-group-item" key={index}>
                    <Button type="primary" icon="notification" size='large'>
                        <Link to={`surveys/${survey.code}`}> {survey.name} ({survey.code})</Link>
                    </Button>

                </li>
            );
        });
    }

    render() {
        const { surveys, loading, error } = this.props.surveys;
        if(loading) {
            return(
            <div className="surveysList">
                <h3>Loading...</h3>
                <Spin />
            </div>
            )
        } else if(error) {
            return <div className="alert alert-danger"><Icon type="disconnect" /> Error: {error.message}</div>
        }

        return (
            <div className="surveysList">
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
                dispatch(surveysActions.fetchSurveysSuccess(response.data))
            }).catch((err)=>{
                dispatch(surveysActions.fetchSurveysFailure(err))
            })
        }
    }
}

export default connect(mapStateToProps, mapDispatchToProps)(SurveysList);
