import React, {Component} from 'react'

class SurveyHeader extends Component {

    render() {
      console.log("SurveyHeader : ")
        return (
          <thead>
              <tr>
                  <th>Name</th>
                  <th>Code</th>
              </tr>
          </thead>
        )
    }
}

export default SurveyHeader
