import React, { Component } from 'react';
import { PieChart, Pie, Sector, Cell , Legend} from 'recharts';
import _ from "lodash"

const COLORS = ['#0E6EB8', '#A0A0A0'];


class SimplePieChart extends Component {
  data = [
    {name:'City Products',value: this.props.surveyResult[1].result},
    {name:'Other products',value: 11630.5-this.props.surveyResult[1].result},
  ];
	render () {
    console.log("Value: ", this.props.surveyResult[1].result)
  	return (
    	<PieChart width={400} height={300}>
        <Pie
          data={[
            {name:'City Products',value: this.props.surveyResult[1].result},
            {name:'Other products',value: 11630.5-this.props.surveyResult[1].result},
          ]}
          cx={200}
          innerRadius={60}
          outerRadius={80}
          label={100}
          dataKey='value'
          fill="#8884d8"
          paddingAngle={5}
        >
        	{
          	this.data.map((entry, index) => <Cell fill={COLORS[index % COLORS.length]}/>)
          }
        </Pie>
        <Legend />
      </PieChart>
    )
  }
}

export default SimplePieChart
