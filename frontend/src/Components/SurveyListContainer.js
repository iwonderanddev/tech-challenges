import React, {Component} from 'react';
import SurveyList from "./SurveyList";
import _ from 'lodash';
import axios from 'axios';
import SimpleBarChart from "./SimpleBarChart";
import SimplePieChart from "./SimplePieChart";
import SimpleScatterChart from "./SimpleScatterChart";
import { Grid, Button } from 'semantic-ui-react'

class SurveyListContainer extends Component {
  constructor(props){
      super(props)
      this.state = {
          survey: null,
          surveyResult: null,
      }
  }

  async componentDidMount() {
      await this.getSurvey()
  }

  //Retrieve the list of surveys
  getSurvey = async () => {
      const response = await axios.get(
          "http://localhost:3000/api/list.json"
      )
      this.setState({
          survey: _.orderBy(response.data, ['code', 'name'], ['asc', 'asc']),
      })
      console.log("Response: "+ response)
  };

  //Retrieve data from the survey clicked
  onSurveyClick = async (surveyId) => {
      const response = await axios.get(
          "http://localhost:3000/api/" + surveyId + ".json"
      )
      this.setState({
          surveyResult: response.data
      })
      console.log('Results: ', response.data)
  }


  render() {

    return (
      <React.Fragment>
      <h1 align="center-right">City Dashboard</h1>
        <SurveyList
          survey={this.state.survey}
          onSurveyClick={this.onSurveyClick}
        />

        {this.state.surveyResult &&
            <SimpleBarChart
                surveyResult={this.state.surveyResult}
            />
        }
        {this.state.surveyResult &&
            <SimplePieChart
                surveyResult={this.state.surveyResult}
            />
        }

      </React.Fragment>

      // No Chart for Dates : Not Working
    );
  }
}

export default SurveyListContainer
