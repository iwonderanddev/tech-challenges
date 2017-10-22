import React, { Component } from 'react';
import { connect } from 'react-redux'
import * as surveysActions from '../actions/surveys';


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
            <ul>
                {
                    result.map((item,index) => {
                    return (
                        <li className="list-group-item" key={index}>
                            {item.name} : {item.value}
                        </li>
                    )
                })
            }
            </ul>
        );
    }
    renderSurvey(survey) {
        const {qcm, date, numeric} = survey;

        return (
            <div className="survey">
                <p>{survey.survey.name}</p>

                <ul>
                    <li>{qcm.question}</li>
                    <li>{this.getQCMData(qcm.answer)}</li>
                </ul>
                <ul>
                    <li>{numeric.question}</li>
                    <li>{numeric.answer}</li>
                </ul>
                <ul>
                    <li>{date.question}</li>
                    <li>
                        {
                            date.answer.map((date,index) => {
                                return (
                                    <span className="list-group-item" key={index}>
                                        {date} 
                                    </span>
                                )
                            })
                        }
                    </li>
                </ul>
            </div>
        );
    }

    render() {
        const { survey, loading, error } = this.props.survey;
        if(loading) {
            return(
            <div className="container">
                <h3>Loading...</h3>
            </div>
            )
        } else if(error) {
            return <div className="alert alert-danger">Error: {error.message}</div>
        }

        return (
            <div className="container">
                <ul className="survey-container">
                    {this.renderSurvey(survey)}
                </ul>
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
