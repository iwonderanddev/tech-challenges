import React, {Component} from 'react'



class SurveyLine extends Component {
  //Function executed when clicked on a line
  handleClick = async (i) => {
    await this.props.onSurveyClick(this.props.code)
    console.log("click: "+ i + this.props.code)
  }
  //Ici this.props.name <=> this.props.survey.name
  render() {

    console.log("name: ", this.props.name)

    return (
      <tr onClick={this.handleClick} >
          <td width="30%">
              {this.props.name}
          </td>
          <td>
              {this.props.code}
          </td>
      </tr>
    );
  }
}

export default SurveyLine
