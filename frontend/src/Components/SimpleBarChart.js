import React, {Component} from 'react'
import {BarChart, CartesianGrid, XAxis, YAxis, Tooltip, Legend, Bar} from "recharts"
import _ from "lodash"


class SimpleBarChart extends Component {
  transformObjectToArray = (object) => {
      let array = []
      for (let key in object) {
          if (object.hasOwnProperty(key)) {
              array.push({
                  productName: key,
                  productValue: object[key]
              })
          }
      }
      return _.orderBy(array, ['productName'], ['asc'])
  }

    render() {
      console.log("transformed: ", this.transformObjectToArray(this.props.surveyResult[0].result))
      return (
        <BarChart width={600} height={300} data={this.transformObjectToArray(this.props.surveyResult[0].result)}>
          <CartesianGrid strokeDasharray="3 3" />
          <XAxis dataKey="productName" />
          <YAxis />
          <Tooltip />
          <Legend />
          <Bar dataKey="productValue" fill="#0E6EB8" />
        </BarChart>
      )
    }
}

export default SimpleBarChart
