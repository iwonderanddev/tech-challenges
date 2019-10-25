import React, {Component} from 'react'
import {ScatterChart, Scatter, XAxis, YAxis, CartesianGrid, Tooltip, Legend} from "recharts";
import _ from "lodash"

class SimpleScatterChart extends Component {
    transformObjectToArray = (object) => {
        let array = []
        for (let key in object) {
            if (object.hasOwnProperty(key)) {
                array.push({
                    date: object[key]
                })
            }
        }
        return array
    }

    date = this.transformObjectToArray(this.props.surveyResult[2].result)

    render() {
        console.log("transformed: ", this.transformObjectToArray(this.props.surveyResult[2].result))

        return (
          <div>
          Chart for Dates
          </div>
        )
    }
}

export default SimpleScatterChart
