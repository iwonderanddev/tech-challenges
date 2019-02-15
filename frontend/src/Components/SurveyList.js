import React, {Component} from 'react'
import SurveyLine from "./SurveyLine";
import SurveyHeader from "./SurveyHeader";

class SurveyList extends Component {
  // Show the survey list
  displaySurvey = (survey) => {
    console.log("survey : ", survey);
    return survey.map((survey, index) => {
        return (
          <SurveyLine
            key={index}
            name={survey.name}
            code={survey.code}
            onSurveyClick={this.props.onSurveyClick}
          />)
    })
  }
  render() {

    console.log("Survey " + this.props.survey)
    return (
      <table>
          <SurveyHeader survey={this.props.survey}/>
          <tbody>
            {this.props.survey && this.displaySurvey(this.props.survey)}
          </tbody>
      </table>
    );
  }
}

export default SurveyList
