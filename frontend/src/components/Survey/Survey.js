import React, { Component } from 'react';
import { connect } from 'react-redux'
import * as surveysActions from '../../actions/surveys';
import { Icon, Spin } from 'antd';

import Graph from '../AmCharts/Graph';

import ('./survey.css');

class Survey extends Component {
    componentWillMount() {
        const {fetchSurvey, id} = this.props;
        fetchSurvey(id);
    }

    getQCMData(data){
        let result=[];
        for(const item in data){
            result.push({'name':item,'value':data[item]});
        }
        return (
            <Graph title="Products Data" data={result} axis="Amount" />
        )
    }
    parseDate(date){
        return new Date(Date.parse(date)).toUTCString();
    }
    renderSurvey(survey) {
        const {qcm, date, numeric} = survey;

        return (
            <div className="survey">
                <p>{survey.survey.name}</p>

                <div className="qcm">
                    <h4>{qcm.question}</h4>
                    <div>{this.getQCMData(qcm.answer)}</div>
                </div>
                <div className="numeric">
                    <h4>{numeric.question}</h4>
                    <div>{numeric.answer}</div>
                </div>
                <div className="date">
                    <h4>{date.question}</h4>
                    <div>
                        {
                            date.answer.map((date,index) => {
                                return (
                                    <p className="list-group-item" key={index}>
                                        {this.parseDate(date)}
                                    </p>
                                )
                            })
                        }
                    </div>
                </div>
            </div>
        );
    }

    render() {
        const { survey, loading, error } = this.props.survey;
        if(loading) {
            return(
            <div className="survey">
                <h3>Loading...</h3>
                <Spin />
            </div>
            )
        } else if(error) {
            return <div className="alert alert-danger"><Icon type="disconnect" /> Error: {error.message}</div>
        }

        return (
            <div className="survey-container">
                {this.renderSurvey(survey)}
            </div>
        );
    }
}

const mapStateToProps = (state) => {
    return {
        survey: state.survey.survey,
        error: state.survey.error,
        loading: state.survey.loading

    };
}

const mapDispatchToProps = (dispatch) => {
    return {
        fetchSurvey: (id) => {
            const request = dispatch(surveysActions.fetchSurvey(id));
            request.payload.then((response) => {
                dispatch(surveysActions.fetchSurveySuccess(response.data))
            }).catch((err)=>{
                dispatch(surveysActions.fetchSurveyFailure(err))
            })
        }
    }
}

export default connect(mapStateToProps, mapDispatchToProps)(Survey);
